<?php

namespace App\Repositories;

use App\Models\MissionCompanion;

class MissionCompanionRepository
{
    /**
     * Get all mission companions.
     */
    public function getAll()
    {
        return MissionCompanion::orderBy('first_name_fr')->orderBy('last_name_fr')->get();
    }

    /**
     * Find mission companion by ID.
     */
    public function findById(int $id): ?MissionCompanion
    {
        return MissionCompanion::find($id);
    }

    /**
     * Create a mission companion.
     */
    public function create(array $data): MissionCompanion
    {
        return MissionCompanion::create($data);
    }

    /**
     * Update a mission companion.
     */
    public function update(MissionCompanion $companion, array $data): bool
    {
        return $companion->update($data);
    }

    /**
     * Delete a mission companion.
     */
    public function delete(MissionCompanion $companion): bool
    {
        return $companion->delete();
    }
}
