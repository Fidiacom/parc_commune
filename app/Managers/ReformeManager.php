<?php

namespace App\Managers;

use App\Models\Reforme;
use App\Models\ReformeStatusHistorique;
use App\Models\ReformeAttachment;
use App\Models\ReformeStatusAttachment;
use App\Repositories\ReformeRepository;
use App\Repositories\ReformeAttachmentRepository;
use App\Repositories\ReformeStatusHistoriqueRepository;
use App\Repositories\ReformeStatusAttachmentRepository;
use App\Services\FileUploadService;
use Illuminate\Http\UploadedFile;

class ReformeManager
{
    protected ReformeRepository $repository;
    protected ReformeAttachmentRepository $attachmentRepository;
    protected ReformeStatusHistoriqueRepository $statusHistoriqueRepository;
    protected ReformeStatusAttachmentRepository $statusAttachmentRepository;
    protected FileUploadService $fileUploadService;

    public function __construct(
        ReformeRepository $repository,
        ReformeAttachmentRepository $attachmentRepository,
        ReformeStatusHistoriqueRepository $statusHistoriqueRepository,
        ReformeStatusAttachmentRepository $statusAttachmentRepository,
        FileUploadService $fileUploadService
    ) {
        $this->repository = $repository;
        $this->attachmentRepository = $attachmentRepository;
        $this->statusHistoriqueRepository = $statusHistoriqueRepository;
        $this->statusAttachmentRepository = $statusAttachmentRepository;
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * Get the repository instance.
     */
    public function getRepository(): ReformeRepository
    {
        return $this->repository;
    }

    /**
     * Create a reforme with attachments.
     */
    public function createReforme(array $reformeData, ?array $files = null): Reforme
    {
        // Create reforme
        $reforme = $this->repository->create($reformeData);

        // Handle files/attachments
        if ($files && count($files) > 0) {
            foreach ($files as $file) {
                $filePath = $this->fileUploadService->uploadFile($file, 'reformes/attachments');
                $fileInfo = $this->fileUploadService->getFileInfo($file);
                $this->attachmentRepository->create([
                    'reforme_id' => $reforme->getId(),
                    'file_path' => $filePath,
                    'file_name' => $fileInfo['name'],
                    'file_type' => $fileInfo['type'],
                    'file_size' => $fileInfo['size'],
                ]);
            }
        }

        // Create initial status historique
        $this->statusHistoriqueRepository->create([
            'reforme_id' => $reforme->getId(),
            'status' => $reforme->getStatus(),
            'description' => __('Initial status'),
        ]);

        return $reforme->fresh(['vehicule', 'attachments', 'statusHistoriques']);
    }

    /**
     * Update a reforme.
     */
    public function updateReforme(Reforme $reforme, array $data): Reforme
    {
        $this->repository->update($reforme, $data);
        return $reforme->fresh(['vehicule', 'attachments', 'statusHistoriques']);
    }

    /**
     * Update reforme status with description and files.
     */
    public function updateStatus(Reforme $reforme, string $status, ?string $description = null, ?array $files = null): ReformeStatusHistorique
    {
        // Update reforme status
        $this->repository->update($reforme, [
            'status' => $status,
        ]);

        // Create status historique
        $statusHistorique = $this->statusHistoriqueRepository->create([
            'reforme_id' => $reforme->getId(),
            'status' => $status,
            'description' => $description,
        ]);

        // Handle files/attachments for status
        if ($files && count($files) > 0) {
            foreach ($files as $file) {
                $filePath = $this->fileUploadService->uploadFile($file, 'reformes/status-attachments');
                $fileInfo = $this->fileUploadService->getFileInfo($file);
                $this->statusAttachmentRepository->create([
                    'reforme_status_historique_id' => $statusHistorique->getId(),
                    'file_path' => $filePath,
                    'file_name' => $fileInfo['name'],
                    'file_type' => $fileInfo['type'],
                    'file_size' => $fileInfo['size'],
                ]);
            }
        }

        return $statusHistorique->fresh('attachments');
    }

    /**
     * Add attachments to reforme.
     */
    public function addAttachments(Reforme $reforme, array $files): void
    {
        foreach ($files as $file) {
            $filePath = $this->fileUploadService->uploadFile($file, 'reformes/attachments');
            $fileInfo = $this->fileUploadService->getFileInfo($file);
            $this->attachmentRepository->create([
                ReformeAttachment::REFORME_ID_COLUMN => $reforme->getId(),
                ReformeAttachment::FILE_PATH_COLUMN => $filePath,
                ReformeAttachment::FILE_NAME_COLUMN => $fileInfo['name'],
                ReformeAttachment::FILE_TYPE_COLUMN => $fileInfo['type'],
                ReformeAttachment::FILE_SIZE_COLUMN => $fileInfo['size'],
            ]);
        }
    }

    /**
     * Delete an attachment.
     */
    public function deleteAttachment(int $attachmentId): bool
    {
        $attachment = $this->attachmentRepository->findById($attachmentId);
        if ($attachment) {
            $this->fileUploadService->deleteFile($attachment->getFilePath());
            return $this->attachmentRepository->delete($attachmentId);
        }
        return false;
    }

    /**
     * Delete a status attachment.
     */
    public function deleteStatusAttachment(int $attachmentId): bool
    {
        $attachment = $this->statusAttachmentRepository->findById($attachmentId);
        if ($attachment) {
            $this->fileUploadService->deleteFile($attachment->getFilePath());
            return $this->statusAttachmentRepository->delete($attachmentId);
        }
        return false;
    }

    /**
     * Delete reforme (soft delete).
     */
    public function deleteReforme(Reforme $reforme): bool
    {
        // Delete all attachments
        $attachments = $this->attachmentRepository->getByReformeId($reforme->getId());
        foreach ($attachments as $attachment) {
            $this->fileUploadService->deleteFile($attachment->getFilePath());
        }

        // Delete all status attachments
        $statusHistoriques = $this->statusHistoriqueRepository->getByReformeId($reforme->getId());
        foreach ($statusHistoriques as $statusHistorique) {
            $statusAttachments = $this->statusAttachmentRepository->getByReformeStatusHistoriqueId($statusHistorique->getId());
            foreach ($statusAttachments as $statusAttachment) {
                $this->fileUploadService->deleteFile($statusAttachment->getFilePath());
            }
        }

        return $this->repository->delete($reforme);
    }
}

