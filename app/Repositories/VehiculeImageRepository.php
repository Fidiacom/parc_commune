<?php

namespace App\Repositories;

use App\Models\VehiculeImage;
use App\Models\Vehicule;

class VehiculeImageRepository
{
    /**
     * Create a new vehicule image.
     */
    public function create(array $data): VehiculeImage
    {
        return VehiculeImage::create($data);
    }

    /**
     * Get all images for a vehicule.
     */
    public function getByVehiculeId(int $vehiculeId)
    {
        return VehiculeImage::where(VehiculeImage::VEHICULE_ID_COLUMN, $vehiculeId)->get();
    }

    /**
     * Get main image for a vehicule.
     */
    public function getMainImage(int $vehiculeId): ?VehiculeImage
    {
        return VehiculeImage::where(VehiculeImage::VEHICULE_ID_COLUMN, $vehiculeId)
            ->where(VehiculeImage::IS_MAIN_COLUMN, true)
            ->first();
    }

    /**
     * Set main image for a vehicule (unset others).
     */
    public function setMainImage(int $vehiculeId, int $imageId): bool
    {
        // Unset all main images for this vehicule
        VehiculeImage::where(VehiculeImage::VEHICULE_ID_COLUMN, $vehiculeId)
            ->update([VehiculeImage::IS_MAIN_COLUMN => false]);

        // Set the new main image
        return VehiculeImage::where('id', $imageId)
            ->where(VehiculeImage::VEHICULE_ID_COLUMN, $vehiculeId)
            ->update([VehiculeImage::IS_MAIN_COLUMN => true]);
    }

    /**
     * Delete a vehicule image.
     */
    public function delete(int $imageId): bool
    {
        $image = VehiculeImage::find($imageId);
        if ($image) {
            return $image->delete();
        }
        return false;
    }

    /**
     * Find image by ID.
     */
    public function findById(int $imageId): ?VehiculeImage
    {
        return VehiculeImage::find($imageId);
    }
}



