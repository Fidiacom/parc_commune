<?php

namespace App\Services;

use App\Managers\VehiculeManager;
use App\Models\Vehicule;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class VehiculeService
{
    protected VehiculeManager $manager;

    public function __construct(VehiculeManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Get all vehicules (excluding reformed vehicles with confirmed/selled status).
     */
    public function getAllVehicules()
    {
        $repository = new \App\Repositories\VehiculeRepository();
        return $repository->getAllWithCounts(['images', 'attachments']);
    }

    /**
     * Get all vehicules including reformed ones (for vehicle list page).
     */
    public function getAllVehiculesIncludingReformed()
    {
        $repository = new \App\Repositories\VehiculeRepository();
        return $repository->getAllWithCountsIncludingReformed(['images', 'attachments']);
    }

    /**
     * Get vehicule by ID with relations.
     */
    public function getVehiculeById(int $id, array $relations = []): ?Vehicule
    {
        $repository = new \App\Repositories\VehiculeRepository();
        return $repository->findByIdWithRelations($id, $relations);
    }

    /**
     * Create a new vehicule from request.
     */
    public function createVehicule(Request $request): Vehicule
    {
        $vehiculeData = [
            'brand' => $request->brand,
            'model' => $request->model,
            'matricule' => $request->matricule,
            'num_chassis' => $request->chassis,
            'circulation_date' => $request->circulation_date,
            'total_km' => intval(str_replace('.', '', $request->km_actuel)),
            'total_hours' => $request->has('total_hours') && $request->total_hours ? intval(str_replace('.', '', $request->total_hours)) : null,
            'horses' => intval(str_replace('.', '', $request->horses)),
            'fuel_type' => $request->fuel_type,
            'min_fuel_consumption_100km' => $request->has('min_fuel_consumption_100km') && $request->min_fuel_consumption_100km ? $request->min_fuel_consumption_100km : null,
            'max_fuel_consumption_100km' => $request->has('max_fuel_consumption_100km') && $request->max_fuel_consumption_100km ? $request->max_fuel_consumption_100km : null,
            'min_fuel_consumption_hour' => $request->has('min_fuel_consumption_hour') && $request->min_fuel_consumption_hour ? $request->min_fuel_consumption_hour : null,
            'max_fuel_consumption_hour' => $request->has('max_fuel_consumption_hour') && $request->max_fuel_consumption_hour ? $request->max_fuel_consumption_hour : null,
            'airbag' => isset($request->airbag) ? 1 : 0,
            'abs' => isset($request->abs) ? 1 : 0,
            'permis_id' => $request->category,
            'inssurance_expiration' => $request->inssurance_expiration,
            'technicalvisite_expiration' => $request->technical_visit_expiration ?? null,
            'number_of_tires' => $request->numOfTires,
            'tire_size' => $request->tire_size,
            'threshold_vidange' => $request->threshold_vidange,
            'threshold_timing_chaine' => $request->threshold_timing_chaine,
            'km_actuel' => $request->km_actuel,
        ];

        $images = $request->hasFile('images') ? $request->file('images') : null;
        $files = $request->hasFile('files') ? $request->file('files') : null;

        $tireData = null;
        if ($request->has('tire_positions') && is_array($request->tire_positions)) {
            $tireData = [
                'positions' => $request->tire_positions,
                'thresholds' => $request->tire_thresholds,
                'nextKMs' => $request->tire_nextKMs,
            ];
        }

        return $this->manager->createVehicule($vehiculeData, $images, $files, $tireData);
    }

    /**
     * Update a vehicule from request.
     */
    public function updateVehicule(Vehicule $vehicule, Request $request): Vehicule
    {
        $data = [
            'brand' => $request->brand,
            'model' => $request->model,
            'matricule' => $request->matricule,
            'num_chassis' => $request->chassis,
            'circulation_date' => $request->circulation_date,
            'total_km' => intval(str_replace(['.', ','], '', $request->km_actuel)),
            'total_hours' => $request->has('total_hours') && $request->total_hours ? intval(str_replace(['.', ','], '', $request->total_hours)) : null,
            'horses' => intval(str_replace(['.', ','], '', $request->horses)),
            'fuel_type' => $request->fuel_type,
            'min_fuel_consumption_100km' => $request->has('min_fuel_consumption_100km') && $request->min_fuel_consumption_100km ? $request->min_fuel_consumption_100km : null,
            'max_fuel_consumption_100km' => $request->has('max_fuel_consumption_100km') && $request->max_fuel_consumption_100km ? $request->max_fuel_consumption_100km : null,
            'min_fuel_consumption_hour' => $request->has('min_fuel_consumption_hour') && $request->min_fuel_consumption_hour ? $request->min_fuel_consumption_hour : null,
            'max_fuel_consumption_hour' => $request->has('max_fuel_consumption_hour') && $request->max_fuel_consumption_hour ? $request->max_fuel_consumption_hour : null,
            'airbag' => isset($request->airbag) ? 1 : 0,
            'abs' => isset($request->abs) ? 1 : 0,
            'inssurance_expiration' => $request->inssurance_expiration,
            'technicalvisite_expiration' => $request->technical_visit_expiration ?? null,
            'number_of_tires' => $request->numOfTires,
            'tire_size' => $request->tire_size,
        ];

        // Handle new images
        if ($request->hasFile('images')) {
            $this->manager->addImages($vehicule, $request->file('images'));
        }

        // Handle tire updates or creation
        if ($request->has('tire_positions') && is_array($request->tire_positions)) {
            $tirePositions = $request->tire_positions;
            $tireThresholds = $request->tire_thresholds ?? [];
            $tireIds = $request->tire_ids ?? [];
            
            // Update existing tires
            if (!empty($tireIds) && is_array($tireIds)) {
                $tireData = [
                    'tire_ids' => $tireIds,
                    'positions' => $tirePositions,
                    'thresholds' => $tireThresholds,
                ];
                $this->manager->updateTires($vehicule, $tireData);
            }
            
            // Create new tires for positions without IDs
            foreach ($tirePositions as $index => $position) {
                $tireId = $tireIds[$index] ?? null;
                $threshold = $tireThresholds[$index] ?? null;
                
                // If no tire ID for this position, create a new tire
                if (!$tireId && $position && $threshold) {
                    $this->manager->createTire($vehicule, [
                        'position' => $position,
                        'threshold' => $threshold,
                    ]);
                }
            }
        }

        // Update vehicule
        $updatedVehicule = $this->manager->updateVehicule($vehicule, $data);

        // Handle threshold updates for vidange and timing chaine
        if ($request->has('threshold_vidange') && $request->threshold_vidange) {
            $this->manager->updateVidangeThreshold($vehicule, intval(str_replace(['.', ','], '', $request->threshold_vidange)));
        }

        if ($request->has('threshold_timing_chaine') && $request->threshold_timing_chaine) {
            $this->manager->updateTimingChaineThreshold($vehicule, intval(str_replace(['.', ','], '', $request->threshold_timing_chaine)));
        }

        return $updatedVehicule;
    }

    /**
     * Add images to vehicule.
     */
    public function addImages(Vehicule $vehicule, array $images): void
    {
        $this->manager->addImages($vehicule, $images);
    }

    /**
     * Add attachments to vehicule.
     */
    public function addAttachments(Vehicule $vehicule, array $files): void
    {
        $this->manager->addAttachments($vehicule, $files);
    }

    /**
     * Delete an image.
     */
    public function deleteImage(int $imageId): bool
    {
        return $this->manager->deleteImage($imageId);
    }

    /**
     * Delete an attachment.
     */
    public function deleteAttachment(int $attachmentId): bool
    {
        return $this->manager->deleteAttachment($attachmentId);
    }

    /**
     * Set main image.
     */
    public function setMainImage(int $vehiculeId, int $imageId): bool
    {
        return $this->manager->setMainImage($vehiculeId, $imageId);
    }

    /**
     * Delete vehicule (soft delete).
     */
    public function deleteVehicule(Vehicule $vehicule): bool
    {
        return $this->manager->deleteVehicule($vehicule);
    }
}

