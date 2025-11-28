<?php

namespace App\Repositories;

use App\Models\ReformeAttachment;

class ReformeAttachmentRepository
{
    /**
     * Create a new reforme attachment.
     */
    public function create(array $data): ReformeAttachment
    {
        return ReformeAttachment::create($data);
    }

    /**
     * Get all attachments for a reforme.
     */
    public function getByReformeId(int $reformeId)
    {
        return ReformeAttachment::where(ReformeAttachment::REFORME_ID_COLUMN, $reformeId)->get();
    }

    /**
     * Delete a reforme attachment.
     */
    public function delete(int $attachmentId): bool
    {
        $attachment = ReformeAttachment::find($attachmentId);
        if ($attachment) {
            return $attachment->delete();
        }
        return false;
    }

    /**
     * Find attachment by ID.
     */
    public function findById(int $attachmentId): ?ReformeAttachment
    {
        return ReformeAttachment::find($attachmentId);
    }
}


