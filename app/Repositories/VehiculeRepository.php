<?php

namespace App\Repositories;

use App\Models\Vehicule;

class VehiculeRepository
{
    /**
     * Get all vehicules.
     */
    public function getAll()
    {
        return Vehicule::latest()->get();
    }

    /**
     * Get all vehicules with counts.
     */
    public function getAllWithCounts(array $relations = [])
    {
        $query = Vehicule::query();
        
        foreach ($relations as $relation) {
            $query->withCount($relation);
        }
        
        return $query->latest()->get();
    }

    /**
     * Find vehicule by ID.
     */
    public function findById(int $id): ?Vehicule
    {
        return Vehicule::find($id);
    }

    /**
     * Find vehicule by ID with relations.
     */
    public function findByIdWithRelations(int $id, array $relations = []): ?Vehicule
    {
        return Vehicule::with($relations)->find($id);
    }

    /**
     * Create a new vehicule.
     */
    public function create(array $data): Vehicule
    {
        return Vehicule::create($data);
    }

    /**
     * Update a vehicule.
     */
    public function update(Vehicule $vehicule, array $data): bool
    {
        return $vehicule->update($data);
    }

    /**
     * Delete a vehicule (soft delete).
     */
    public function delete(Vehicule $vehicule): bool
    {
        return $vehicule->delete();
    }
}



