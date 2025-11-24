<?php

namespace App\Managers;

use App\Models\Vehicule;
use App\Models\VehiculeImage;
use App\Models\VehiculeAttachment;
use App\Models\Vidange;
use App\Models\VidangeHistorique;
use App\Models\pneu;
use App\Models\PneuHistorique;
use App\Models\TimingChaine;
use App\Models\TimingChaineHistorique;
use App\Repositories\VehiculeRepository;
use App\Repositories\VehiculeImageRepository;
use App\Repositories\VehiculeAttachmentRepository;
use App\Services\FileUploadService;
use Illuminate\Http\UploadedFile;

class VehiculeManager
{
    protected VehiculeRepository $repository;
    protected VehiculeImageRepository $imageRepository;
    protected VehiculeAttachmentRepository $attachmentRepository;
    protected FileUploadService $fileUploadService;

    public function __construct(
        VehiculeRepository $repository,
        VehiculeImageRepository $imageRepository,
        VehiculeAttachmentRepository $attachmentRepository,
        FileUploadService $fileUploadService
    ) {
        $this->repository = $repository;
        $this->imageRepository = $imageRepository;
        $this->attachmentRepository = $attachmentRepository;
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * Get the repository instance.
     */
    public function getRepository(): VehiculeRepository
    {
        return $this->repository;
    }

    /**
     * Create a vehicule with all related data.
     */
    public function createVehicule(array $vehiculeData, ?array $images = null, ?array $files = null, ?array $tireData = null): Vehicule
    {
        // Create vehicule
        $vehicule = $this->repository->create($vehiculeData);

        // Handle images
        if ($images && count($images) > 0) {
            $isFirst = true;
            foreach ($images as $image) {
                $filePath = $this->fileUploadService->uploadFile($image, 'vehicules/images');
                $this->imageRepository->create([
                    VehiculeImage::VEHICULE_ID_COLUMN => $vehicule->getId(),
                    VehiculeImage::FILE_PATH_COLUMN => $filePath,
                    VehiculeImage::IS_MAIN_COLUMN => $isFirst,
                ]);
                $isFirst = false;
            }
        }

        // Handle files/attachments
        if ($files && count($files) > 0) {
            foreach ($files as $file) {
                $filePath = $this->fileUploadService->uploadFile($file, 'vehicules/attachments');
                $fileInfo = $this->fileUploadService->getFileInfo($file);
                $this->attachmentRepository->create([
                    VehiculeAttachment::VEHICULE_ID_COLUMN => $vehicule->getId(),
                    VehiculeAttachment::FILE_PATH_COLUMN => $filePath,
                    VehiculeAttachment::FILE_NAME_COLUMN => $fileInfo['name'],
                    VehiculeAttachment::FILE_TYPE_COLUMN => $fileInfo['type'],
                    VehiculeAttachment::FILE_SIZE_COLUMN => $fileInfo['size'],
                ]);
            }
        }

        // Handle vidange
        if (isset($vehiculeData['threshold_vidange']) && isset($vehiculeData['km_actuel'])) {
            $vidange = new Vidange;
            $vidange->car_id = $vehicule->getId();
            $vidange->threshold_km = intval(str_replace('.', '', $vehiculeData['threshold_vidange']));
            $vidange->save();

            $vidangeHistorique = new VidangeHistorique;
            $vidangeHistorique->vidange_id = $vidange->id;
            $vidangeHistorique->current_km = intval(str_replace('.', '', $vehiculeData['km_actuel']));
            $vidangeHistorique->next_km_for_drain = intval(str_replace('.', '', $vehiculeData['km_actuel'])) + intval(str_replace('.', '', $vehiculeData['threshold_vidange']));
            $vidangeHistorique->save();
        }

        // Handle timing chaine
        if (isset($vehiculeData['threshold_timing_chaine']) && isset($vehiculeData['km_actuel'])) {
            $timingChaine = new TimingChaine;
            $timingChaine->car_id = $vehicule->getId();
            $timingChaine->threshold_km = intval(str_replace('.', '', $vehiculeData['threshold_timing_chaine']));
            $timingChaine->save();

            $timingChaineHistorique = new TimingChaineHistorique;
            $timingChaineHistorique->chaine_id = $timingChaine->id;
            $timingChaineHistorique->current_km = intval(str_replace('.', '', $vehiculeData['km_actuel']));
            $timingChaineHistorique->next_km_for_change = intval(str_replace('.', '', $vehiculeData['km_actuel'])) + intval(str_replace('.', '', $vehiculeData['threshold_timing_chaine']));
            $timingChaineHistorique->save();
        }

        // Handle tires
        if ($tireData && isset($tireData['positions']) && is_array($tireData['positions'])) {
            $numOfTires = count($tireData['positions']);
            for ($num = 0; $num < $numOfTires; $num++) {
                if (isset($tireData['positions'][$num]) && isset($tireData['thresholds'][$num]) && isset($tireData['nextKMs'][$num])) {
                    $pneu = new pneu;
                    $pneu->car_id = $vehicule->getId();
                    $pneu->threshold_km = intval(str_replace('.', '', $tireData['thresholds'][$num]));
                    $pneu->tire_position = $tireData['positions'][$num];
                    $pneu->save();

                    $historique = new PneuHistorique;
                    $historique->pneu_id = $pneu->id;
                    $historique->current_km = intval(str_replace('.', '', $vehiculeData['km_actuel']));
                    $historique->next_km_for_change = intval(str_replace('.', '', $tireData['nextKMs'][$num]));
                    $historique->save();
                }
            }
        }

        return $vehicule->fresh();
    }

    /**
     * Update a vehicule.
     */
    public function updateVehicule(Vehicule $vehicule, array $data): Vehicule
    {
        $this->repository->update($vehicule, $data);
        return $vehicule->fresh();
    }

    /**
     * Update tires for a vehicule.
     */
    public function updateTires(Vehicule $vehicule, array $tireData): void
    {
        if (!isset($tireData['tire_ids']) || !is_array($tireData['tire_ids'])) {
            return;
        }

        $tireIds = $tireData['tire_ids'];
        $positions = $tireData['positions'] ?? [];
        $thresholds = $tireData['thresholds'] ?? [];

        foreach ($tireIds as $index => $tireId) {
            if (isset($positions[$index]) && isset($thresholds[$index])) {
                $pneu = pneu::find($tireId);
                if ($pneu && $pneu->getCarId() == $vehicule->getId()) {
                    $pneu->tire_position = $positions[$index];
                    $pneu->threshold_km = intval(str_replace('.', '', $thresholds[$index]));
                    $pneu->save();
                }
            }
        }
    }

    /**
     * Add images to vehicule.
     */
    public function addImages(Vehicule $vehicule, array $images): void
    {
        foreach ($images as $image) {
            $filePath = $this->fileUploadService->uploadFile($image, 'vehicules/images');
            $this->imageRepository->create([
                VehiculeImage::VEHICULE_ID_COLUMN => $vehicule->getId(),
                VehiculeImage::FILE_PATH_COLUMN => $filePath,
                VehiculeImage::IS_MAIN_COLUMN => false,
            ]);
        }
    }

    /**
     * Add attachments to vehicule.
     */
    public function addAttachments(Vehicule $vehicule, array $files): void
    {
        foreach ($files as $file) {
            $filePath = $this->fileUploadService->uploadFile($file, 'vehicules/attachments');
            $fileInfo = $this->fileUploadService->getFileInfo($file);
            $this->attachmentRepository->create([
                VehiculeAttachment::VEHICULE_ID_COLUMN => $vehicule->getId(),
                VehiculeAttachment::FILE_PATH_COLUMN => $filePath,
                VehiculeAttachment::FILE_NAME_COLUMN => $fileInfo['name'],
                VehiculeAttachment::FILE_TYPE_COLUMN => $fileInfo['type'],
                VehiculeAttachment::FILE_SIZE_COLUMN => $fileInfo['size'],
            ]);
        }
    }

    /**
     * Delete an image.
     */
    public function deleteImage(int $imageId): bool
    {
        $image = $this->imageRepository->findById($imageId);
        if ($image) {
            $this->fileUploadService->deleteFile($image->getFilePath());
            return $this->imageRepository->delete($imageId);
        }
        return false;
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
     * Set main image.
     */
    public function setMainImage(int $vehiculeId, int $imageId): bool
    {
        return $this->imageRepository->setMainImage($vehiculeId, $imageId);
    }

    /**
     * Delete vehicule (soft delete).
     */
    public function deleteVehicule(Vehicule $vehicule): bool
    {
        // Delete all images
        $images = $this->imageRepository->getByVehiculeId($vehicule->getId());
        foreach ($images as $image) {
            $this->fileUploadService->deleteFile($image->getFilePath());
        }

        // Delete all attachments
        $attachments = $this->attachmentRepository->getByVehiculeId($vehicule->getId());
        foreach ($attachments as $attachment) {
            $this->fileUploadService->deleteFile($attachment->getFilePath());
        }

        return $this->repository->delete($vehicule);
    }
}

