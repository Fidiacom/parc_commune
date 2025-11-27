<?php

namespace App\Managers;

use App\Models\Driver;
use App\Repositories\DriverRepository;
use App\Services\FileUploadService;
use Illuminate\Http\UploadedFile;

class DriverManager
{
    protected DriverRepository $repository;
    protected FileUploadService $fileUploadService;

    public function __construct(
        DriverRepository $repository,
        FileUploadService $fileUploadService
    ) {
        $this->repository = $repository;
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * Get the repository instance.
     */
    public function getRepository(): DriverRepository
    {
        return $this->repository;
    }

    /**
     * Create a driver with all related data.
     */
    public function createDriver(array $driverData, ?UploadedFile $image = null, ?array $permisIds = null): Driver
    {
        // Handle image upload
        if ($image) {
            $driverData[Driver::IMAGE_COLUMN] = $this->fileUploadService->uploadFile($image, 'drivers');
        }

        // Create driver
        $driver = $this->repository->create($driverData);

        // Handle permis relationships
        if ($permisIds && is_array($permisIds) && count($permisIds) > 0) {
            $this->attachPermis($driver, $permisIds);
        }

        return $driver->fresh(['permis']);
    }

    /**
     * Update a driver with all related data.
     */
    public function updateDriver(Driver $driver, array $driverData, ?UploadedFile $image = null, ?array $permisIds = null): Driver
    {
        // Handle image upload if new image is provided
        if ($image) {
            // Delete old image if exists
            if ($driver->getImage()) {
                $this->fileUploadService->deleteFile($driver->getImage());
            }
            $driverData[Driver::IMAGE_COLUMN] = $this->fileUploadService->uploadFile($image, 'drivers');
        }

        // Update driver
        $this->repository->update($driver, $driverData);

        // Handle permis relationships
        if ($permisIds !== null) {
            $this->syncPermis($driver, $permisIds);
        }

        return $driver->fresh(['permis']);
    }

    /**
     * Attach permis to driver.
     */
    public function attachPermis(Driver $driver, array $permisIds): void
    {
        if (count($permisIds) > 0) {
            $driver->permis()->attach($permisIds);
        }
    }

    /**
     * Sync permis for driver (detach all and attach new ones).
     */
    public function syncPermis(Driver $driver, array $permisIds): void
    {
        // Detach all existing permis
        $driver->permis()->detach();

        // Attach new permis
        if (count($permisIds) > 0) {
            $driver->permis()->attach($permisIds);
        }
    }

    /**
     * Delete driver (soft delete).
     */
    public function deleteDriver(Driver $driver): bool
    {
        // Delete image if exists
        if ($driver->getImage()) {
            $this->fileUploadService->deleteFile($driver->getImage());
        }

        // Detach all permis
        $driver->permis()->detach();

        return $this->repository->delete($driver);
    }
}

