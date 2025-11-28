<?php

namespace App\Repositories;

use App\Models\ReformeStatusAttachment;

class ReformeStatusAttachmentRepository
{
    /**
     * Create a new reforme status attachment.
     */
    public function create(array $data): ReformeStatusAttachment
    {
        return ReformeStatusAttachment::create($data);
    }

    /**
     * Get all attachments for a reforme status historique.
     */
    public function getByReformeStatusHistoriqueId(int $reformeStatusHistoriqueId)
    {
        return ReformeStatusAttachment::where(ReformeStatusAttachment::REFORME_STATUS_HISTORIQUE_ID_COLUMN, $reformeStatusHistoriqueId)->get();
    }

    /**
     * Delete a reforme status attachment.
     */
    public function delete(int $attachmentId): bool
    {
        $attachment = ReformeStatusAttachment::find($attachmentId);
        if ($attachment) {
            return $attachment->delete();
        }
        return false;
    }

    /**
     * Find attachment by ID.
     */
    public function findById(int $attachmentId): ?ReformeStatusAttachment
    {
        return ReformeStatusAttachment::find($attachmentId);
    }
}

