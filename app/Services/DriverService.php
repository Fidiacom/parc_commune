<?php

namespace App\Services;

use App\Http\Requests\StoreDriverRequest;
use App\Http\Requests\UpdateDriverRequest;
use App\Managers\DriverManager;
use App\Models\Driver;
use Illuminate\Http\UploadedFile;

class DriverService
{
    protected DriverManager $manager;

    public function __construct(DriverManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Get all drivers with permis relation.
     */
    public function getAllDrivers()
    {
        $repository = $this->manager->getRepository();
        return $repository->getAllWithRelations(['permis']);
    }

    /**
     * Get driver by ID with relations.
     */
    public function getDriverById(int $id, array $relations = ['permis']): ?Driver
    {
        $repository = $this->manager->getRepository();
        return $repository->findByIdWithRelations($id, $relations);
    }

    /**
     * Create a new driver from request.
     */
    public function createDriver(StoreDriverRequest $request): Driver
    {
        $driverData = [
            Driver::FIRST_NAME_AR_COLUMN => $request->first_name_ar,
            Driver::FIRST_NAME_FR_COLUMN => $request->first_name_fr,
            Driver::LAST_NAME_AR_COLUMN => $request->last_name_ar,
            Driver::LAST_NAME_FR_COLUMN => $request->last_name_fr,
            Driver::ROLE_AR_COLUMN => $request->role_ar,
            Driver::ROLE_FR_COLUMN => $request->role_fr,
            Driver::CIN_COLUMN => $request->cin,
            Driver::PHONE_COLUMN => $request->phone,
        ];

        $image = $request->hasFile('image') ? $request->file('image') : null;
        $permisIds = $request->permisType ?? [];

        return $this->manager->createDriver($driverData, $image, $permisIds);
    }

    /**
     * Update a driver from request.
     */
    public function updateDriver(Driver $driver, UpdateDriverRequest $request): Driver
    {
        $driverData = [
            Driver::FIRST_NAME_AR_COLUMN => $request->first_name_ar,
            Driver::FIRST_NAME_FR_COLUMN => $request->first_name_fr,
            Driver::LAST_NAME_AR_COLUMN => $request->last_name_ar,
            Driver::LAST_NAME_FR_COLUMN => $request->last_name_fr,
            Driver::ROLE_AR_COLUMN => $request->role_ar,
            Driver::ROLE_FR_COLUMN => $request->role_fr,
            Driver::CIN_COLUMN => $request->cin,
            Driver::PHONE_COLUMN => $request->phone,
        ];

        $image = $request->hasFile('image') ? $request->file('image') : null;
        $permisIds = $request->permisType ?? [];

        return $this->manager->updateDriver($driver, $driverData, $image, $permisIds);
    }

    /**
     * Delete a driver.
     */
    public function deleteDriver(Driver $driver): bool
    {
        return $this->manager->deleteDriver($driver);
    }

    /**
     * Check if a driver is available in a given period.
     * A driver is available if they don't have any active mission orders that overlap with the period.
     */
    public function isDriverAvailable(int $driverId, string $startDate, ?string $endDate = null): bool
    {
        $driver = $this->getDriverById($driverId, ['missionOrders']);
        
        if (!$driver) {
            return false;
        }

        // Get all active mission orders (not done yet)
        $activeMissionOrders = \App\Models\MissionOrder::where('driver_id', $driverId)
            ->whereNull('done_at')
            ->get();

        $start = \Carbon\Carbon::parse($startDate);
        $end = $endDate ? \Carbon\Carbon::parse($endDate) : null;

        foreach ($activeMissionOrders as $missionOrder) {
            $missionStart = \Carbon\Carbon::parse($missionOrder->getStart());
            $missionEnd = $missionOrder->getEnd() ? \Carbon\Carbon::parse($missionOrder->getEnd()) : null;

            // If mission is permanent (no end date), it blocks all dates from its start onwards
            if ($missionOrder->isPermanent()) {
                // Permanent mission blocks if requested start is on or after mission start
                if ($start->greaterThanOrEqualTo($missionStart)) {
                    return false;
                }
                // Also check if requested period overlaps with permanent mission
                if ($end && $end->greaterThanOrEqualTo($missionStart)) {
                    return false;
                }
            } else {
                // Mission has an end date - check for overlap
                if ($end) {
                    // Both have end dates - check for overlap
                    // Overlap occurs if: start <= missionEnd AND end >= missionStart
                    if ($start->lessThanOrEqualTo($missionEnd) && $end->greaterThanOrEqualTo($missionStart)) {
                        return false;
                    }
                } else {
                    // Requested period has no end (permanent) - check if it starts before or during existing mission
                    // If requested start is before or equal to mission end, there's overlap
                    if ($start->lessThanOrEqualTo($missionEnd)) {
                        return false;
                    }
                }
            }
        }

        return true;
    }

    /**
     * Get all available drivers for a given period.
     */
    public function getAvailableDrivers(string $startDate, ?string $endDate = null)
    {
        $allDrivers = $this->getAllDrivers();
        $availableDrivers = [];

        foreach ($allDrivers as $driver) {
            if ($this->isDriverAvailable($driver->getId(), $startDate, $endDate)) {
                $availableDrivers[] = $driver;
            }
        }

        return collect($availableDrivers);
    }
}

