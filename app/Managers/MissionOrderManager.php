<?php

namespace App\Managers;

use App\Models\MissionOrder;
use App\Models\Driver;
use App\Models\Vehicule;
use App\Repositories\MissionOrderRepository;
use App\Repositories\VehiculeRepository;

class MissionOrderManager
{
    protected MissionOrderRepository $repository;
    protected VehiculeRepository $vehiculeRepository;

    public function __construct(
        MissionOrderRepository $repository,
        VehiculeRepository $vehiculeRepository
    ) {
        $this->repository = $repository;
        $this->vehiculeRepository = $vehiculeRepository;
    }

    /**
     * Get the repository instance.
     */
    public function getRepository(): MissionOrderRepository
    {
        return $this->repository;
    }

    /**
     * Create a mission order with validation.
     */
    public function createMissionOrder(array $missionOrderData): MissionOrder
    {
        // Validate driver has required permis
        $driver = Driver::with('permis')->find($missionOrderData[MissionOrder::DRIVER_ID_COLUMN]);
        $vehicule = Vehicule::join('categorie_permis', 'vehicules.permis_id', '=', 'categorie_permis.id')
            ->find($missionOrderData[MissionOrder::VEHICULE_ID_COLUMN]);

        if (!$driver || !$vehicule) {
            throw new \Exception('Driver or Vehicule not found');
        }

        if (!$driver->permis->pluck('id')->contains($vehicule->permis_id)) {
            throw new \Exception('Driver should have: Permis ' . $vehicule->label);
        }

        return $this->repository->create($missionOrderData);
    }

    /**
     * Update a mission order with validation.
     */
    public function updateMissionOrder(MissionOrder $missionOrder, array $missionOrderData): MissionOrder
    {
        // Validate driver has required permis if driver or vehicule changed
        if (isset($missionOrderData[MissionOrder::DRIVER_ID_COLUMN]) || isset($missionOrderData[MissionOrder::VEHICULE_ID_COLUMN])) {
            $driverId = $missionOrderData[MissionOrder::DRIVER_ID_COLUMN] ?? $missionOrder->getDriverId();
            $vehiculeId = $missionOrderData[MissionOrder::VEHICULE_ID_COLUMN] ?? $missionOrder->getVehiculeId();

            $driver = Driver::with('permis')->find($driverId);
            $vehicule = Vehicule::join('categorie_permis', 'vehicules.permis_id', '=', 'categorie_permis.id')
                ->find($vehiculeId);

            if (!$driver || !$vehicule) {
                throw new \Exception('Driver or Vehicule not found');
            }

            if (!$driver->permis->pluck('id')->contains($vehicule->permis_id)) {
                throw new \Exception('Driver should have: Permis ' . $vehicule->label);
            }
        }

        $this->repository->update($missionOrder, $missionOrderData);
        return $missionOrder->fresh();
    }

    /**
     * Mark mission order as returned and update vehicule KM.
     */
    public function returnFromMissionOrder(MissionOrder $missionOrder, string $returnDate, int $actualKm): MissionOrder
    {
        // Update mission order
        $this->repository->update($missionOrder, [
            MissionOrder::DONE_AT_COLUMN => $returnDate,
        ]);

        // Update vehicule total KM
        $vehicule = $this->vehiculeRepository->findById($missionOrder->getVehiculeId());
        if ($vehicule) {
            $this->vehiculeRepository->update($vehicule, [
                'total_km' => $actualKm,
            ]);
        }

        return $missionOrder->fresh();
    }

    /**
     * Delete mission order.
     */
    public function deleteMissionOrder(MissionOrder $missionOrder): bool
    {
        return $this->repository->delete($missionOrder);
    }
}

