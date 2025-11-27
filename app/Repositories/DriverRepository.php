<?php

namespace App\Repositories;

use App\Models\Driver;

class DriverRepository
{
    /**
     * Get all drivers.
     */
    public function getAll()
    {
        return Driver::latest()->get();
    }

    /**
     * Get all drivers with relations.
     */
    public function getAllWithRelations(array $relations = [])
    {
        return Driver::with($relations)->latest()->get();
    }

    /**
     * Find driver by ID.
     */
    public function findById(int $id): ?Driver
    {
        return Driver::find($id);
    }

    /**
     * Find driver by ID with relations.
     */
    public function findByIdWithRelations(int $id, array $relations = []): ?Driver
    {
        return Driver::with($relations)->find($id);
    }

    /**
     * Create a new driver.
     */
    public function create(array $data): Driver
    {
        return Driver::create($data);
    }

    /**
     * Update a driver.
     */
    public function update(Driver $driver, array $data): bool
    {
        return $driver->update($data);
    }

    /**
     * Delete a driver (soft delete).
     */
    public function delete(Driver $driver): bool
    {
        return $driver->delete();
    }
}

