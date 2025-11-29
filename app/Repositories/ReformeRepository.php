<?php

namespace App\Repositories;

use App\Models\Reforme;

class ReformeRepository
{
    /**
     * Get all reformes.
     */
    public function getAll()
    {
        return Reforme::with(['vehicule', 'statusHistoriques', 'attachments'])
            ->latest()
            ->get();
    }

    /**
     * Get all reformes with counts.
     */
    public function getAllWithCounts(array $relations = [])
    {
        $query = Reforme::query();
        
        foreach ($relations as $relation) {
            $query->withCount($relation);
        }
        
        return $query->latest()->get();
    }

    /**
     * Find reforme by ID.
     */
    public function findById(int $id): ?Reforme
    {
        return Reforme::find($id);
    }

    /**
     * Find reforme by ID with relations.
     */
    public function findByIdWithRelations(int $id, array $relations = []): ?Reforme
    {
        return Reforme::with($relations)->find($id);
    }

    /**
     * Create a new reforme.
     */
    public function create(array $data): Reforme
    {
        return Reforme::create($data);
    }

    /**
     * Update a reforme.
     */
    public function update(Reforme $reforme, array $data): bool
    {
        return $reforme->update($data);
    }

    /**
     * Delete a reforme (soft delete).
     */
    public function delete(Reforme $reforme): bool
    {
        return $reforme->delete();
    }
}




