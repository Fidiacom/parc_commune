<?php

namespace Tests\Feature;

use App\Models\PaymentVoucher;
use App\Models\User;
use App\Models\Vehicule;
use App\Services\FuelConsumptionService;
use Database\Seeders\VehiculeSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FuelConsumptionTest extends TestCase
{
    use RefreshDatabase;

    private FuelConsumptionService $service;
    private int $number = 1;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(); // base data (roles, admin, settings...)
        $this->seed(VehiculeSeeder::class);
        $this->service = app(FuelConsumptionService::class);
    }

    private function vehicle(string $matricule): Vehicule
    {
        return Vehicule::where('matricule', $matricule)->firstOrFail();
    }

    private function fuel(Vehicule $vehicule, ?int $km, float $liters, string $date, ?int $hours = null, bool $withInvoiceDate = true): PaymentVoucher
    {
        return PaymentVoucher::create([
            'voucher_number' => 'T-' . $this->number++,
            'voucher_date' => $date,
            'invoice_date' => $withInvoiceDate ? $date : null,
            'amount' => $liters * 12,
            'vehicule_id' => $vehicule->getId(),
            'vehicle_km' => $km,
            'vehicle_hours' => $hours,
            'category' => 'carburant',
            'fuel_liters' => $liters,
        ]);
    }

    private function dashboard()
    {
        $admin = User::where('email', 'admin@jamaycom.ma')->firstOrFail();

        return $this->actingAs($admin)->get('/');
    }

    public function test_alert_uses_latest_fill_up_and_clears_after_a_correct_one(): void
    {
        // Dacia Logan J223125: max 5.5 L/100km, min 4.0 L/100km
        $logan = $this->vehicle('J223125');

        $this->fuel($logan, 10000, 40, '2026-01-01'); // first fill: its fuel is not counted
        $this->fuel($logan, 10500, 25, '2026-01-10'); // 5.0 L/100km
        $this->fuel($logan, 11000, 45, '2026-01-20'); // 9.0 L/100km  -> too high

        $alert = $this->service->alert($logan);
        $this->assertNotNull($alert);
        $this->assertTrue($alert['exceeds_km']);
        $this->assertEqualsWithDelta(9.0, $alert['average_consumption_km'], 0.001);
        $this->assertEqualsWithDelta(3.5, $alert['excess_km'], 0.001);
        $this->assertSame(500.0, $alert['interval_km']);

        // All-time average excludes the first fill: (25 + 45) / 1000 km * 100 = 7.0
        $stats = $this->service->stats($logan, $this->service->fuelVouchers($logan));
        $this->assertEqualsWithDelta(7.0, $stats['average_consumption_100km'], 0.001);
        $this->assertTrue($stats['exceeds_max_consumption']);

        $this->dashboard()->assertSee('Alertes - Consommation élevée')->assertSee('9,00 L/100km');

        // A correct fill-up: 25 L over 500 km = 5.0 L/100km -> alert disappears
        $this->fuel($logan, 11500, 25, '2026-01-30');

        $this->assertNull($this->service->alert($logan));
        $this->assertSame([], $this->service->vehiclesExceedingMax());
        $this->dashboard()->assertDontSee('Alertes - Consommation élevée');
    }

    public function test_vouchers_without_invoice_date_are_ordered_by_km(): void
    {
        $logan = $this->vehicle('J223125');

        $this->fuel($logan, 10000, 40, '2026-01-01');
        $this->fuel($logan, 10500, 25, '2026-01-10');
        // Created from the app: no invoice date. It is still the latest fill-up (highest km).
        $this->fuel($logan, 11000, 50, '2026-01-20', null, false);

        $latest = $this->service->latestKm($this->service->fuelVouchers($logan));

        $this->assertEqualsWithDelta(10.0, $latest['value'], 0.001);
        $this->assertSame(11000, (int) $latest['latest']->getVehicleKm());
    }

    public function test_back_dated_voucher_does_not_become_the_latest(): void
    {
        $logan = $this->vehicle('J223125');

        $this->fuel($logan, 10000, 40, '2026-01-01');
        $this->fuel($logan, 11000, 50, '2026-01-20');
        // Entered later but with an older reading: the latest is still the 11000 km voucher
        $this->fuel($logan, 10500, 25, '2026-02-01');

        $latest = $this->service->latestKm($this->service->fuelVouchers($logan));

        $this->assertSame(11000, (int) $latest['latest']->getVehicleKm());
        $this->assertEqualsWithDelta(10.0, $latest['value'], 0.001); // 50 L / 500 km
    }

    public function test_hour_based_vehicle(): void
    {
        // J126485: max 12 L/H, min 8 L/H, no km limits
        $engine = $this->vehicle('J126485');

        $this->fuel($engine, null, 100, '2026-01-01', 1000);
        $this->fuel($engine, null, 150, '2026-01-10', 1010); // 15 L/H -> too high

        $alert = $this->service->alert($engine);
        $this->assertTrue($alert['exceeds_hour']);
        $this->assertEqualsWithDelta(15.0, $alert['average_consumption_hour'], 0.001);

        $this->fuel($engine, null, 100, '2026-01-20', 1020); // 10 L/H -> fine
        $this->assertNull($this->service->alert($engine));
    }

    public function test_low_consumption_shows_in_notifications_but_not_in_high_alerts(): void
    {
        $logan = $this->vehicle('J223125'); // min 4.0 L/100km

        $this->fuel($logan, 10000, 40, '2026-01-01');
        $this->fuel($logan, 11000, 20, '2026-01-10'); // 2.0 L/100km -> too low

        $alert = $this->service->alert($logan);
        $this->assertTrue($alert['below_km']);
        $this->assertFalse($alert['exceeds_km']);
        $this->assertSame([], $this->service->vehiclesExceedingMax());

        $this->dashboard()->assertSee('Consommation faible (KM)')->assertDontSee('Alertes - Consommation élevée');
    }

    public function test_not_enough_data_means_no_alert(): void
    {
        $logan = $this->vehicle('J223125');

        $this->fuel($logan, 10000, 80, '2026-01-01');
        $this->assertNull($this->service->alert($logan));

        // Same km twice (typo / duplicate): no interval, no alert
        $this->fuel($logan, 10000, 80, '2026-01-02');
        $this->assertNull($this->service->alert($logan));
    }

    public function test_saving_a_fuel_voucher_only_moves_the_odometer_forward(): void
    {
        $logan = $this->vehicle('J223125'); // total_km 50000 in the seeder
        $admin = User::where('email', 'admin@jamaycom.ma')->firstOrFail();
        $post = fn (int $km, string $number) => $this->actingAs($admin)->post(route('admin.payment_voucher.store'), [
            'category' => 'carburant',
            'vehicule_id' => $logan->getId(),
            'voucher_number' => $number,
            'voucher_date' => '2026-01-10',
            'vehicle_km' => $km,
            'amount' => 300,
            'price_per_liter' => 12,
        ]);

        $post(50500, 'UP-1')->assertSessionHasNoErrors();
        $this->assertSame(50500, (int) $logan->fresh()->getTotalKm());
        $this->assertEqualsWithDelta(25.0, (float) PaymentVoucher::where('voucher_number', 'UP-1')->value('fuel_liters'), 0.001);

        // Back-dated voucher with a lower reading: odometer stays at 50500
        $post(49000, 'UP-2')->assertSessionHasNoErrors();
        $this->assertSame(50500, (int) $logan->fresh()->getTotalKm());
    }
}
