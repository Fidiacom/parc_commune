<?php

namespace App\Repositories;

use App\Models\MissionOrder;

class MissionOrderRepository
{
    /**
     * Get all mission orders.
     */
    public function getAll()
    {
        return MissionOrder::latest()->get();
    }

    /**
     * Get all mission orders with relations.
     */
    public function getAllWithRelations(array $relations = [])
    {
        return MissionOrder::with($relations)->latest()->get();
    }

    /**
     * Find mission order by ID.
     */
    public function findById(int $id): ?MissionOrder
    {
        return MissionOrder::find($id);
    }

    /**
     * Find mission order by ID with relations.
     */
    public function findByIdWithRelations(int $id, array $relations = []): ?MissionOrder
    {
        return MissionOrder::with($relations)->find($id);
    }

    /**
     * Create a new mission order.
     */
    public function create(array $data): MissionOrder
    {
        return MissionOrder::create($data);
    }

    /**
     * Update a mission order.
     */
    public function update(MissionOrder $missionOrder, array $data): bool
    {
        return $missionOrder->update($data);
    }

    /**
     * Delete a mission order (soft delete if enabled).
     */
    public function delete(MissionOrder $missionOrder): bool
    {
        return $missionOrder->delete();
    }
}

