<?php

namespace App\Services;

use App\Managers\MissionCompanionManager;
use App\Models\MissionCompanion;
use Illuminate\Http\Request;

class MissionCompanionService
{
    protected MissionCompanionManager $manager;

    public function __construct(MissionCompanionManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Get all mission companions.
     */
    public function getAllMissionCompanions()
    {
        return $this->manager->getRepository()->getAll();
    }

    public function getMissionCompanionById(int $id): ?MissionCompanion
    {
        return $this->manager->getRepository()->findById($id);
    }

    public function createMissionCompanion(Request $request): MissionCompanion
    {
        $data = [
            MissionCompanion::FIRST_NAME_FR_COLUMN => $request->first_name_fr,
            MissionCompanion::LAST_NAME_FR_COLUMN => $request->last_name_fr,
            MissionCompanion::FIRST_NAME_AR_COLUMN => $request->first_name_ar,
            MissionCompanion::LAST_NAME_AR_COLUMN => $request->last_name_ar,
            MissionCompanion::CIN_COLUMN => $request->cin,
        ];

        return $this->manager->createMissionCompanion($data);
    }

    public function updateMissionCompanion(MissionCompanion $companion, Request $request): MissionCompanion
    {
        $data = [
            MissionCompanion::FIRST_NAME_FR_COLUMN => $request->first_name_fr,
            MissionCompanion::LAST_NAME_FR_COLUMN => $request->last_name_fr,
            MissionCompanion::FIRST_NAME_AR_COLUMN => $request->first_name_ar,
            MissionCompanion::LAST_NAME_AR_COLUMN => $request->last_name_ar,
            MissionCompanion::CIN_COLUMN => $request->cin,
        ];

        return $this->manager->updateMissionCompanion($companion, $data);
    }

    public function deleteMissionCompanion(MissionCompanion $companion): bool
    {
        return $this->manager->deleteMissionCompanion($companion);
    }
}
