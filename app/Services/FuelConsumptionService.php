<?php

namespace App\Services;

use App\Models\PaymentVoucher;
use App\Models\Vehicule;
use Illuminate\Support\Collection;

/**
 * Fuel consumption figures and alerts, computed from "carburant" payment vouchers.
 *
 * Method: full tank to full tank. The fuel of a voucher was burnt during the km
 * driven since the previous voucher, so the first voucher's litres are never
 * counted (that fuel was used before the first km reading).
 *
 * Alerts use the latest fill-up only: litres of the latest voucher ÷ km since
 * the previous one. A correct fill-up therefore clears the alert right away.
 */
class FuelConsumptionService
{
    /**
     * Fuel vouchers of a vehicle, oldest first. Optional date range (voucher date, else invoice date).
     */
    public function fuelVouchers(Vehicule $vehicule, ?string $from = null, ?string $to = null): Collection
    {
        $query = PaymentVoucher::where('vehicule_id', $vehicule->getId())
            ->where('category', 'carburant')
            ->whereNotNull('fuel_liters');

        if ($from) {
            $query->whereRaw('COALESCE(voucher_date, invoice_date) >= ?', [$from]);
        }
        if ($to) {
            $query->whereRaw('COALESCE(voucher_date, invoice_date) <= ?', [$to]);
        }

        return $query->orderByRaw('COALESCE(voucher_date, invoice_date) asc')
            ->orderBy('vehicle_km')
            ->orderBy('id')
            ->get();
    }

    /**
     * Fuel vouchers of every vehicle in one query, keyed by vehicle id.
     */
    public function fuelVouchersByVehicle(): Collection
    {
        return PaymentVoucher::where('category', 'carburant')
            ->whereNotNull('fuel_liters')
            ->orderByRaw('COALESCE(voucher_date, invoice_date) asc')
            ->orderBy('vehicle_km')
            ->orderBy('id')
            ->get()
            ->groupBy('vehicule_id');
    }

    /**
     * Consumption of the latest fill-up in L/100km, or null if there is not enough data.
     */
    public function latestKm(Collection $vouchers): ?array
    {
        return $this->latestInterval($vouchers, 'vehicle_km', 100);
    }

    /**
     * Consumption of the latest fill-up in L/H, or null if there is not enough data.
     */
    public function latestHours(Collection $vouchers): ?array
    {
        return $this->latestInterval($vouchers, 'vehicle_hours', 1);
    }

    /**
     * Statistics shown on the vehicle pages (all-time averages + latest fill-up + alert flags).
     */
    public function stats(Vehicule $vehicule, Collection $vouchers): array
    {
        $stats = [
            'total_fuel_liters' => 0,
            'total_fuel_cost' => 0,
            'total_km' => 0,
            'total_hours' => 0,
            'average_consumption_100km' => null,
            'average_consumption_hour' => null,
            'average_price_per_liter' => null,
            'latest_consumption_100km' => null,
            'latest_consumption_hour' => null,
            'latest_interval_km' => null,
            'latest_interval_hours' => null,
            'exceeds_max_consumption' => false,
            'exceeds_max_consumption_km' => false,
            'exceeds_max_consumption_hour' => false,
            'below_min_consumption_km' => false,
            'below_min_consumption_hour' => false,
            'last_fuel_entry' => $vouchers->last(),
        ];

        $stats['total_fuel_liters'] = (float) $vouchers->sum(fn ($v) => (float) $v->getFuelLiters());
        $stats['total_fuel_cost'] = (float) $vouchers->sum(fn ($v) => (float) $v->getAmount());

        if ($stats['total_fuel_liters'] > 0) {
            $stats['average_price_per_liter'] = $stats['total_fuel_cost'] / $stats['total_fuel_liters'];
        }

        // All-time averages (first voucher's litres excluded)
        $km = $this->average($vouchers, 'vehicle_km', 100);
        if ($km) {
            $stats['total_km'] = $km['distance'];
            $stats['average_consumption_100km'] = $km['value'];
        }

        $hours = $this->average($vouchers, 'vehicle_hours', 1);
        if ($hours) {
            $stats['total_hours'] = $hours['distance'];
            $stats['average_consumption_hour'] = $hours['value'];
        }

        // Latest fill-up and alert flags
        $alert = $this->alert($vehicule, $vouchers);
        $latestKm = $this->latestKm($vouchers);
        $latestHours = $this->latestHours($vouchers);

        $stats['latest_consumption_100km'] = $latestKm['value'] ?? null;
        $stats['latest_interval_km'] = $latestKm['distance'] ?? null;
        $stats['latest_consumption_hour'] = $latestHours['value'] ?? null;
        $stats['latest_interval_hours'] = $latestHours['distance'] ?? null;

        if ($alert) {
            $stats['exceeds_max_consumption_km'] = $alert['exceeds_km'];
            $stats['exceeds_max_consumption_hour'] = $alert['exceeds_hour'];
            $stats['below_min_consumption_km'] = $alert['below_km'];
            $stats['below_min_consumption_hour'] = $alert['below_hour'];
            $stats['exceeds_max_consumption'] = $alert['exceeds_km'] || $alert['exceeds_hour'];
        }

        return $stats;
    }

    /**
     * Compare the latest fill-up with the vehicle's limits.
     * Returns null when no limit is broken.
     */
    public function alert(Vehicule $vehicule, ?Collection $vouchers = null): ?array
    {
        $vouchers ??= $this->fuelVouchers($vehicule);

        $latestKm = $this->latestKm($vouchers);
        $latestHours = $this->latestHours($vouchers);

        $maxKm = $vehicule->getMaxFuelConsumption100km();
        $minKm = $vehicule->getMinFuelConsumption100km();
        $maxHour = $vehicule->getMaxFuelConsumptionHour();
        $minHour = $vehicule->getMinFuelConsumptionHour();

        $valueKm = $latestKm['value'] ?? null;
        $valueHour = $latestHours['value'] ?? null;

        $exceedsKm = $valueKm !== null && $maxKm && $valueKm > $maxKm;
        $belowKm = $valueKm !== null && $minKm && $valueKm < $minKm;
        $exceedsHour = $valueHour !== null && $maxHour && $valueHour > $maxHour;
        $belowHour = $valueHour !== null && $minHour && $valueHour < $minHour;

        if (!$exceedsKm && !$belowKm && !$exceedsHour && !$belowHour) {
            return null;
        }

        return [
            'vehicule' => $vehicule,
            // Kept as "average_*" so the dashboard view stays compatible; it is the latest fill-up value.
            'average_consumption_km' => $valueKm,
            'average_consumption_hour' => $valueHour,
            'interval_km' => $latestKm['distance'] ?? null,
            'interval_hours' => $latestHours['distance'] ?? null,
            'latest_liters' => $latestKm['liters'] ?? ($latestHours['liters'] ?? null),
            'max_consumption_km' => $maxKm,
            'min_consumption_km' => $minKm,
            'max_consumption_hour' => $maxHour,
            'min_consumption_hour' => $minHour,
            'exceeds_km' => $exceedsKm,
            'below_km' => $belowKm,
            'exceeds_hour' => $exceedsHour,
            'below_hour' => $belowHour,
            'excess_km' => $exceedsKm ? $valueKm - $maxKm : null,
            'deficit_km' => $belowKm ? $minKm - $valueKm : null,
            'excess_hour' => $exceedsHour ? $valueHour - $maxHour : null,
            'deficit_hour' => $belowHour ? $minHour - $valueHour : null,
        ];
    }

    /**
     * Alerts for every vehicle (one query for all vouchers).
     *
     * @return array<int, array> keyed by vehicle id
     */
    public function allAlerts(): array
    {
        $vouchersByVehicle = $this->fuelVouchersByVehicle();
        $alerts = [];

        $vehicles = Vehicule::where(function ($query) {
            $query->whereNotNull('max_fuel_consumption_100km')
                ->orWhereNotNull('min_fuel_consumption_100km')
                ->orWhereNotNull('max_fuel_consumption_hour')
                ->orWhereNotNull('min_fuel_consumption_hour');
        })->get();

        foreach ($vehicles as $vehicule) {
            $alert = $this->alert($vehicule, $vouchersByVehicle->get($vehicule->getId(), collect()));
            if ($alert) {
                $alerts[$vehicule->getId()] = $alert;
            }
        }

        return $alerts;
    }

    /**
     * Vehicles whose latest fill-up is above the maximum (dashboard "Consommation élevée").
     */
    public function vehiclesExceedingMax(): array
    {
        return array_values(array_filter(
            $this->allAlerts(),
            fn (array $alert) => $alert['exceeds_km'] || $alert['exceeds_hour']
        ));
    }

    /**
     * Latest interval on one counter (km or hours).
     * "Latest" is the voucher with the highest reading; "previous" is the highest reading strictly below it.
     */
    private function latestInterval(Collection $vouchers, string $counter, int $per): ?array
    {
        $readings = $this->withReading($vouchers, $counter);

        if ($readings->count() < 2) {
            return null;
        }

        $latest = $readings->last();
        $latestReading = (float) $latest->{$counter};
        $previous = $readings->filter(fn ($v) => (float) $v->{$counter} < $latestReading)->last();

        if (!$previous) {
            return null;
        }

        $distance = $latestReading - (float) $previous->{$counter};
        $liters = (float) $latest->getFuelLiters();

        if ($distance <= 0 || $liters <= 0) {
            return null;
        }

        return [
            'value' => $liters / $distance * $per,
            'liters' => $liters,
            'distance' => $distance,
            'latest' => $latest,
            'previous' => $previous,
        ];
    }

    /**
     * All-time average on one counter: litres of every voucher except the first ÷ distance covered.
     */
    private function average(Collection $vouchers, string $counter, int $per): ?array
    {
        $readings = $this->withReading($vouchers, $counter);

        if ($readings->count() < 2) {
            return null;
        }

        $distance = (float) $readings->last()->{$counter} - (float) $readings->first()->{$counter};
        $liters = (float) $readings->slice(1)->sum(fn ($v) => (float) $v->getFuelLiters());

        if ($distance <= 0 || $liters <= 0) {
            return null;
        }

        return ['value' => $liters / $distance * $per, 'distance' => $distance];
    }

    /**
     * Vouchers that have a reading on this counter, sorted by that reading (stable on date order).
     */
    private function withReading(Collection $vouchers, string $counter): Collection
    {
        return $vouchers
            ->filter(fn ($v) => $v->{$counter} !== null && (float) $v->{$counter} > 0)
            ->sortBy(fn ($v) => (float) $v->{$counter}, SORT_NUMERIC)
            ->values();
    }
}
