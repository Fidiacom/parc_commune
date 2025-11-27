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
}

