<?php

namespace App\Services;

use App\Managers\MissionOrderManager;
use App\Models\MissionOrder;
use Illuminate\Http\Request;

class MissionOrderService
{
    protected MissionOrderManager $manager;

    public function __construct(MissionOrderManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Get all mission orders with relations.
     */
    public function getAllMissionOrders(array $relations = ['driver', 'vehicule'])
    {
        $repository = $this->manager->getRepository();
        return $repository->getAllWithRelations($relations);
    }

    /**
     * Get mission order by ID with relations.
     */
    public function getMissionOrderById(int $id, array $relations = ['driver', 'vehicule']): ?MissionOrder
    {
        $repository = $this->manager->getRepository();
        return $repository->findByIdWithRelations($id, $relations);
    }

    /**
     * Create a new mission order from request.
     */
    public function createMissionOrder(Request $request): MissionOrder
    {
        $isPermanent = isset($request->mission_order_type);
        
        $missionOrderData = [
            MissionOrder::DRIVER_ID_COLUMN => $request->driver,
            MissionOrder::VEHICULE_ID_COLUMN => $request->vehicule,
            MissionOrder::PERMANENT_COLUMN => $isPermanent ? 1 : 0,
            MissionOrder::START_COLUMN => $request->start_date,
            MissionOrder::END_COLUMN => isset($request->end_date) ? $request->end_date : null,
            MissionOrder::REGISTRATION_DATETIME_COLUMN => $request->registration_datetime ?? null,
        ];

        // Only add mission fields and place_togo if mission is NOT permanent
        if (!$isPermanent) {
            $missionOrderData[MissionOrder::MISSION_FR_COLUMN] = $request->mission_fr ?? null;
            $missionOrderData[MissionOrder::MISSION_AR_COLUMN] = $request->mission_ar ?? null;
            $missionOrderData[MissionOrder::PLACE_TOGO_FR_COLUMN] = $request->place_togo_fr ?? null;
            $missionOrderData[MissionOrder::PLACE_TOGO_AR_COLUMN] = $request->place_togo_ar ?? null;
        }

        return $this->manager->createMissionOrder($missionOrderData);
    }

    /**
     * Update a mission order from request.
     */
    public function updateMissionOrder(MissionOrder $missionOrder, Request $request): MissionOrder
    {
        $isPermanent = isset($request->mission_order_type);
        
        $missionOrderData = [
            MissionOrder::DRIVER_ID_COLUMN => $request->driver,
            MissionOrder::VEHICULE_ID_COLUMN => $request->vehicule,
            MissionOrder::PERMANENT_COLUMN => $isPermanent ? 1 : 0,
            MissionOrder::START_COLUMN => $request->start_date,
            MissionOrder::REGISTRATION_DATETIME_COLUMN => $request->registration_datetime ?? null,
        ];

        if ($isPermanent) {
            $missionOrderData[MissionOrder::END_COLUMN] = null;
            // Clear mission and place_togo fields if permanent
            $missionOrderData[MissionOrder::MISSION_FR_COLUMN] = null;
            $missionOrderData[MissionOrder::MISSION_AR_COLUMN] = null;
            $missionOrderData[MissionOrder::PLACE_TOGO_FR_COLUMN] = null;
            $missionOrderData[MissionOrder::PLACE_TOGO_AR_COLUMN] = null;
        } else {
            $missionOrderData[MissionOrder::END_COLUMN] = $request->end_date;
            $missionOrderData[MissionOrder::MISSION_FR_COLUMN] = $request->mission_fr ?? null;
            $missionOrderData[MissionOrder::MISSION_AR_COLUMN] = $request->mission_ar ?? null;
            $missionOrderData[MissionOrder::PLACE_TOGO_FR_COLUMN] = $request->place_togo_fr ?? null;
            $missionOrderData[MissionOrder::PLACE_TOGO_AR_COLUMN] = $request->place_togo_ar ?? null;
        }

        return $this->manager->updateMissionOrder($missionOrder, $missionOrderData);
    }

    /**
     * Return from mission order and update vehicule KM.
     */
    public function returnFromMissionOrder(MissionOrder $missionOrder, Request $request): MissionOrder
    {
        return $this->manager->returnFromMissionOrder(
            $missionOrder,
            $request->return_date,
            $request->actual_km
        );
    }

    /**
     * Delete a mission order.
     */
    public function deleteMissionOrder(MissionOrder $missionOrder): bool
    {
        return $this->manager->deleteMissionOrder($missionOrder);
    }
}

