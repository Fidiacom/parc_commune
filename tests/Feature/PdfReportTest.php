<?php

namespace Tests\Feature;

use App\Models\MissionOrder;
use App\Models\User;
use App\Support\PdfHeader;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PdfReportTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config(['app.seed_demo' => true]);
        $this->seed();
    }

    private function admin(): User
    {
        return User::where('email', 'admin@jamaycom.ma')->firstOrFail();
    }

    public function test_payment_voucher_report_pdf_downloads_in_french_and_arabic(): void
    {
        foreach (['fr' => 'rapport-bons-de-paiement.pdf', 'ar' => 'rapport-bons-de-paiement-ar.pdf'] as $lang => $file) {
            $response = $this->actingAs($this->admin())
                ->get(route('admin.payment_voucher.report.pdf', ['lang' => $lang, 'category' => 'carburant']));

            $response->assertOk();
            $response->assertHeader('Content-Type', 'application/pdf');
            $this->assertStringContainsString($file, $response->headers->get('Content-Disposition'));
            $this->assertStringStartsWith('%PDF', $response->getContent());
        }
    }

    public function test_permanent_mission_order_prints_in_french_and_arabic(): void
    {
        $order = MissionOrder::where('permanent', true)->firstOrFail();

        foreach (['fr', 'ar'] as $lang) {
            $response = $this->actingAs($this->admin())
                ->get(route('admin.mission_order.print', $order->getId()) . '?person_type=driver&lang=' . $lang);

            $response->assertOk();
            $response->assertHeader('Content-Type', 'application/pdf');
            $this->assertStringStartsWith('%PDF', $response->getContent());
        }
    }

    public function test_single_mission_order_prints(): void
    {
        $order = MissionOrder::where('permanent', false)->firstOrFail();

        $response = $this->actingAs($this->admin())
            ->get(route('admin.mission_order.print', $order->getId()) . '?person_type=driver');

        $response->assertOk();
        $response->assertHeader('Content-Type', 'application/pdf');
    }

    public function test_header_lines_come_from_config_without_double_prefix(): void
    {
        config(['settings.province_fr' => 'PROVINCE DE TEST', 'settings.region_fr' => '']);

        $lines = PdfHeader::lines('fr');

        $this->assertContains('PROVINCE DE TEST', $lines);
        $this->assertNotContains('', $lines);
        foreach ($lines as $line) {
            $this->assertDoesNotMatchRegularExpression('/\b(\w+ DE) \1\b/', $line);
        }
    }

    public function test_commune_name_uses_settings_page_first_then_env(): void
    {
        $this->assertSame(config('settings.commune_fr'), PdfHeader::communeName('fr'));

        \App\Models\Setting::query()->first()->update(['commune_name_fr' => 'Commune de Test']);

        $this->assertSame('Commune de Test', PdfHeader::communeName('fr'));
    }
}
