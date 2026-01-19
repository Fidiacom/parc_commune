<?php

namespace App\Services;

use App\Managers\MissionOrderManager;
use App\Models\Driver;
use App\Models\MissionCompanion;
use App\Models\MissionOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Mpdf\Mpdf;

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
        $companionIds = $isPermanent ? [] : (array) $request->input('companions', []);
        
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

        return $this->manager->createMissionOrder($missionOrderData, $companionIds);
    }

    /**
     * Update a mission order from request.
     */
    public function updateMissionOrder(MissionOrder $missionOrder, Request $request): MissionOrder
    {
        $isPermanent = isset($request->mission_order_type);
        $companionIds = $isPermanent ? [] : (array) $request->input('companions', []);
        
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

        return $this->manager->updateMissionOrder($missionOrder, $missionOrderData, $companionIds);
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

    public function getPrintableMissionOrder(int $id, string $personType = 'driver', ?int $personId = null): array
    {
        $missionOrder = $this->getMissionOrderById($id, ['driver', 'vehicule', 'companions']);
        if (!$missionOrder) {
            return ['missionOrder' => null, 'subject' => null];
        }

        $personType = strtolower($personType);
        if ($personType !== 'companion') {
            $personType = 'driver';
        }

        if ($personType === 'driver') {
            $driver = $missionOrder->getDriver();
            if (!$driver) {
                return ['missionOrder' => $missionOrder, 'subject' => null];
            }

            return ['missionOrder' => $missionOrder, 'subject' => $this->buildDriverSubject($driver)];
        }

        if (!$personId) {
            return ['missionOrder' => $missionOrder, 'subject' => null];
        }

        $companion = $missionOrder->getCompanions()
            ->firstWhere(MissionCompanion::ID_COLUMN, $personId);
        if (!$companion) {
            return ['missionOrder' => $missionOrder, 'subject' => null];
        }

        return ['missionOrder' => $missionOrder, 'subject' => $this->buildCompanionSubject($companion)];
    }

    private function buildDriverSubject(Driver $driver): array
    {
        return [
            'name_fr' => $this->buildName(
                $driver->getFirstNameFr(),
                $driver->getLastNameFr(),
                $driver->getFirstNameAr(),
                $driver->getLastNameAr()
            ),
            'name_ar' => $this->buildName(
                $driver->getFirstNameAr(),
                $driver->getLastNameAr(),
                $driver->getFirstNameFr(),
                $driver->getLastNameFr()
            ),
            'role_fr' => $driver->getRoleFr(),
            'role_ar' => $driver->getRoleAr(),
        ];
    }

    private function buildCompanionSubject(MissionCompanion $companion): array
    {
        $fallback = $companion->getCin() ?? '';

        return [
            'name_fr' => $this->buildName(
                $companion->getFirstNameFr(),
                $companion->getLastNameFr(),
                $companion->getFirstNameAr(),
                $companion->getLastNameAr(),
                $fallback
            ),
            'name_ar' => $this->buildName(
                $companion->getFirstNameAr(),
                $companion->getLastNameAr(),
                $companion->getFirstNameFr(),
                $companion->getLastNameFr(),
                $fallback
            ),
            'role_fr' => null,
            'role_ar' => null,
        ];
    }

    private function buildName(
        ?string $firstNamePrimary,
        ?string $lastNamePrimary,
        ?string $firstNameFallback,
        ?string $lastNameFallback,
        string $fallback = ''
    ): string
    {
        $primary = trim(($firstNamePrimary ?? '') . ' ' . ($lastNamePrimary ?? ''));
        if ($primary !== '') {
            return $primary;
        }

        $secondary = trim(($firstNameFallback ?? '') . ' ' . ($lastNameFallback ?? ''));
        if ($secondary !== '') {
            return $secondary;
        }

        return $fallback;
    }

    public function generateMissionOrderPdf(MissionOrder $missionOrder, array $subject, $settings): array
    {
        $viewName = $missionOrder->isPermanent()
            ? 'admin.mission_order.print_permanent'
            : 'admin.mission_order.print_single';

        $html = View::make($viewName, [
            'missionOrder' => $missionOrder,
            'settings' => $settings,
            'subject' => $subject,
        ])->render();

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'orientation' => 'P',
            'margin_left' => 15,
            'margin_right' => 15,
            'margin_top' => 0,
            'margin_bottom' => 15,
            'margin_header' => 0,
            'margin_footer' => 9,
            'tempDir' => storage_path('app/temp'),
        ]);

        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;
        $mpdf->WriteHTML($html);

        return [
            'content' => $mpdf->Output('', 'S'),
            'filename' => 'order_de_mission_' . $missionOrder->getId() . '.pdf',
        ];
    }
}

