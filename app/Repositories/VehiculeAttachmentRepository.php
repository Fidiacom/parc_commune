<?php

namespace App\Repositories;

use App\Models\VehiculeAttachment;

class VehiculeAttachmentRepository
{
    /**
     * Create a new vehicule attachment.
     */
    public function create(array $data): VehiculeAttachment
    {
        return VehiculeAttachment::create($data);
    }

    /**
     * Get all attachments for a vehicule.
     */
    public function getByVehiculeId(int $vehiculeId)
    {
        return VehiculeAttachment::where(VehiculeAttachment::VEHICULE_ID_COLUMN, $vehiculeId)->get();
    }

    /**
     * Delete a vehicule attachment.
     */
    public function delete(int $attachmentId): bool
    {
        $attachment = VehiculeAttachment::find($attachmentId);
        if ($attachment) {
            return $attachment->delete();
        }
        return false;
    }

    /**
     * Find attachment by ID.
     */
    public function findById(int $attachmentId): ?VehiculeAttachment
    {
        return VehiculeAttachment::find($attachmentId);
    }
}



