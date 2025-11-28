<?php

namespace App\Repositories;

use App\Models\Vehicule;
use App\Models\Reforme;

class VehiculeRepository
{
    /**
     * Get all vehicules.
     */
    public function getAll()
    {
        return $this->excludeReformedVehicles(Vehicule::query())->latest()->get();
    }

    /**
     * Get all vehicules with counts.
     */
    public function getAllWithCounts(array $relations = [])
    {
        $query = $this->excludeReformedVehicles(Vehicule::query());
        
        foreach ($relations as $relation) {
            $query->withCount($relation);
        }
        
        return $query->latest()->get();
    }

    /**
     * Get all vehicules with counts (including reformed vehicles).
     */
    public function getAllWithCountsIncludingReformed(array $relations = [])
    {
        $query = Vehicule::query();
        
        foreach ($relations as $relation) {
            $query->withCount($relation);
        }
        
        return $query->latest()->get();
    }

    /**
     * Exclude vehicles with confirmed or selled reform status.
     */
    protected function excludeReformedVehicles($query)
    {
        return $query->whereDoesntHave('reformes', function ($q) {
            $q->whereIn('status', [Reforme::STATUS_CONFIRMED, Reforme::STATUS_SELLED]);
        });
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



