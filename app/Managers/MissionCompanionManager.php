<?php

namespace App\Managers;

use App\Repositories\MissionCompanionRepository;

class MissionCompanionManager
{
    protected MissionCompanionRepository $repository;

    public function __construct(MissionCompanionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getRepository(): MissionCompanionRepository
    {
        return $this->repository;
    }

    public function createMissionCompanion(array $data)
    {
        return $this->repository->create($data);
    }

    public function updateMissionCompanion($companion, array $data)
    {
        $this->repository->update($companion, $data);
        return $companion->fresh();
    }

    public function deleteMissionCompanion($companion): bool
    {
        return $this->repository->delete($companion);
    }
}
