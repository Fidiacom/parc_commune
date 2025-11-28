<?php

namespace App\Services;

use App\Managers\ReformeManager;
use App\Models\Reforme;
use Illuminate\Http\Request;

class ReformeService
{
    protected ReformeManager $manager;

    public function __construct(ReformeManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Get all reformes.
     */
    public function getAllReformes()
    {
        $repository = new \App\Repositories\ReformeRepository();
        return $repository->getAll();
    }

    /**
     * Get reforme by ID with relations.
     */
    public function getReformeById(int $id, array $relations = []): ?Reforme
    {
        $repository = new \App\Repositories\ReformeRepository();
        return $repository->findByIdWithRelations($id, $relations);
    }

    /**
     * Create a new reforme from request.
     */
    public function createReforme(Request $request): Reforme
    {
        $reformeData = [
            'vehicule_id' => $request->vehicule_id,
            'description' => $request->description,
            'status' => Reforme::STATUS_IN_PROGRESS,
        ];

        $files = $request->hasFile('files') ? $request->file('files') : null;

        return $this->manager->createReforme($reformeData, $files);
    }

    /**
     * Update a reforme from request.
     */
    public function updateReforme(Reforme $reforme, Request $request): Reforme
    {
        $data = [
            'description' => $request->description,
        ];

        // Handle new files/attachments
        if ($request->hasFile('files')) {
            $this->manager->addAttachments($reforme, $request->file('files'));
        }

        return $this->manager->updateReforme($reforme, $data);
    }

    /**
     * Update reforme status.
     */
    public function updateStatus(Reforme $reforme, Request $request): Reforme
    {
        $status = $request->status;
        $description = $request->description ?? null;
        $files = $request->hasFile('files') ? $request->file('files') : null;

        $this->manager->updateStatus($reforme, $status, $description, $files);
        
        return $reforme->fresh(['vehicule', 'attachments', 'statusHistoriques.attachments']);
    }

    /**
     * Add attachments to reforme.
     */
    public function addAttachments(Reforme $reforme, array $files): void
    {
        $this->manager->addAttachments($reforme, $files);
    }

    /**
     * Delete an attachment.
     */
    public function deleteAttachment(int $attachmentId): bool
    {
        return $this->manager->deleteAttachment($attachmentId);
    }

    /**
     * Delete a status attachment.
     */
    public function deleteStatusAttachment(int $attachmentId): bool
    {
        return $this->manager->deleteStatusAttachment($attachmentId);
    }

    /**
     * Delete reforme (soft delete).
     */
    public function deleteReforme(Reforme $reforme): bool
    {
        return $this->manager->deleteReforme($reforme);
    }
}

