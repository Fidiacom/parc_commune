<?php

namespace App\Managers;

use App\Models\PaymentVoucher;
use App\Models\Vehicule;
use App\Models\pneu;
use App\Models\PneuHistorique;
use App\Models\Vidange;
use App\Models\VidangeHistorique;
use App\Models\TimingChaine;
use App\Models\TimingChaineHistorique;
use App\Models\PaymentVoucherAttachment;
use App\Repositories\PaymentVoucherRepository;
use App\Repositories\PaymentVoucherAttachmentRepository;
use App\Services\FileUploadService;
use Illuminate\Http\UploadedFile;

class PaymentVoucherManager
{
    protected PaymentVoucherRepository $repository;
    protected FileUploadService $fileUploadService;
    protected PaymentVoucherAttachmentRepository $attachmentRepository;

    public function __construct(
        PaymentVoucherRepository $repository,
        FileUploadService $fileUploadService,
        PaymentVoucherAttachmentRepository $attachmentRepository
    ) {
        $this->repository = $repository;
        $this->fileUploadService = $fileUploadService;
        $this->attachmentRepository = $attachmentRepository;
    }

    /**
     * Get the repository instance.
     */
    public function getRepository(): PaymentVoucherRepository
    {
        return $this->repository;
    }

    /**
     * Create a payment voucher with special handling for different categories.
     */
    public function createPaymentVoucher(array $data, ?UploadedFile $document = null): PaymentVoucher
    {
        // Generate voucher number if not provided
        if (!isset($data[PaymentVoucher::VOUCHER_NUMBER_COLUMN])) {
            $data[PaymentVoucher::VOUCHER_NUMBER_COLUMN] = $this->repository->generateNextVoucherNumber();
        }

        // Handle document upload
        if ($document) {
            $data[PaymentVoucher::DOCUMENT_PATH_COLUMN] = $this->fileUploadService->uploadFile(
                $document,
                'payment_vouchers/documents'
            );
        }

        // Create the voucher
        $voucher = $this->repository->create($data);

        // Handle special cases based on category
        $this->handleCategorySpecificLogic($voucher, $data);

        return $voucher->fresh(['vehicule', 'tire', 'vidange', 'timingChaine']);
    }

    /**
     * Update a payment voucher.
     */
    public function updatePaymentVoucher(PaymentVoucher $voucher, array $data, ?UploadedFile $document = null): PaymentVoucher
    {
        // Handle document upload if new document is provided
        if ($document) {
            // Delete old document if exists
            if ($voucher->getDocumentPath()) {
                $this->fileUploadService->deleteFile($voucher->getDocumentPath());
            }
            $data[PaymentVoucher::DOCUMENT_PATH_COLUMN] = $this->fileUploadService->uploadFile(
                $document,
                'payment_vouchers/documents'
            );
        }

        // Update the voucher
        $this->repository->update($voucher, $data);

        // Handle special cases based on category
        $this->handleCategorySpecificLogic($voucher->fresh(), $data);

        return $voucher->fresh(['vehicule', 'tire', 'vidange', 'timingChaine']);
    }

    /**
     * Handle category-specific logic.
     */
    protected function handleCategorySpecificLogic(PaymentVoucher $voucher, array $data): void
    {
        $category = $voucher->getCategory();
        $vehicule = Vehicule::find($voucher->getVehiculeId());

        if (!$vehicule) {
            return;
        }

        switch ($category) {
            case 'rechange_pneu':
                $this->handleTireChange($voucher, $vehicule, $data);
                break;

            case 'entretien':
                $this->handleMaintenance($voucher, $vehicule, $data);
                break;

            case 'vidange':
                $this->handleVidange($voucher, $vehicule, $data);
                break;

            case 'carburant':
                $this->handleFuel($voucher, $vehicule, $data);
                break;
        }
    }

    /**
     * Handle tire change logic.
     */
    protected function handleTireChange(PaymentVoucher $voucher, Vehicule $vehicule, array $data): void
    {
        if (!isset($data[PaymentVoucher::TIRE_ID_COLUMN]) || !$data[PaymentVoucher::TIRE_ID_COLUMN]) {
            return;
        }

        $tireId = $data[PaymentVoucher::TIRE_ID_COLUMN];
        $tire = pneu::find($tireId);

        if (!$tire || $tire->getCarId() !== $vehicule->getId()) {
            return;
        }

        // Update vehicle KM and Hours
        $vehicleKm = $voucher->getVehicleKm();
        $updateData = [Vehicule::TOTAL_KM_COLUMN => $vehicleKm];
        if ($voucher->getVehicleHours() !== null) {
            $updateData[Vehicule::TOTAL_HOURS_COLUMN] = $voucher->getVehicleHours();
        }
        $vehicule->update($updateData);

        // Create tire history entry
        $historique = new PneuHistorique();
        $historique->pneu_id = $tireId;
        $historique->current_km = $vehicleKm;
        $historique->next_km_for_change = $vehicleKm + $tire->getThresholdKm();
        $historique->save();
    }

    /**
     * Handle maintenance logic (Vidange or Timing Chaine).
     */
    protected function handleMaintenance(PaymentVoucher $voucher, Vehicule $vehicule, array $data): void
    {
        $vehicleKm = $voucher->getVehicleKm();

        // Update vehicle KM and Hours
        $updateData = [Vehicule::TOTAL_KM_COLUMN => $vehicleKm];
        if ($voucher->getVehicleHours() !== null) {
            $updateData[Vehicule::TOTAL_HOURS_COLUMN] = $voucher->getVehicleHours();
        }
        $vehicule->update($updateData);

        // Handle Vidange if specified
        if (isset($data[PaymentVoucher::VIDANGE_ID_COLUMN]) && $data[PaymentVoucher::VIDANGE_ID_COLUMN]) {
            $vidangeId = $data[PaymentVoucher::VIDANGE_ID_COLUMN];
            $vidange = Vidange::find($vidangeId);

            if ($vidange && $vidange->getCarId() === $vehicule->getId()) {
                $historique = new VidangeHistorique();
                $historique->vidange_id = $vidangeId;
                $historique->current_km = $vehicleKm;
                $historique->next_km_for_drain = $vehicleKm + $vidange->getThresholdKm();
                $historique->save();
            }
        }

        // Handle Timing Chaine if specified
        if (isset($data[PaymentVoucher::TIMING_CHAINE_ID_COLUMN]) && $data[PaymentVoucher::TIMING_CHAINE_ID_COLUMN]) {
            $timingChaineId = $data[PaymentVoucher::TIMING_CHAINE_ID_COLUMN];
            $timingChaine = TimingChaine::find($timingChaineId);

            if ($timingChaine && $timingChaine->getCarId() === $vehicule->getId()) {
                $historique = new TimingChaineHistorique();
                $historique->chaine_id = $timingChaineId;
                $historique->current_km = $vehicleKm;
                $historique->next_km_for_change = $vehicleKm + $timingChaine->getThresholdKm();
                $historique->save();
            }
        }
    }

    /**
     * Handle vidange logic.
     */
    protected function handleVidange(PaymentVoucher $voucher, Vehicule $vehicule, array $data): void
    {
        $vehicleKm = $voucher->getVehicleKm();

        // Update vehicle KM and Hours
        $updateData = [Vehicule::TOTAL_KM_COLUMN => $vehicleKm];
        if ($voucher->getVehicleHours() !== null) {
            $updateData[Vehicule::TOTAL_HOURS_COLUMN] = $voucher->getVehicleHours();
        }
        $vehicule->update($updateData);

        // If vidange_id is set, create a vidange history record
        if (isset($data[PaymentVoucher::VIDANGE_ID_COLUMN]) && $data[PaymentVoucher::VIDANGE_ID_COLUMN]) {
            $vidangeId = $data[PaymentVoucher::VIDANGE_ID_COLUMN];
            $vidange = Vidange::find($vidangeId);

            if ($vidange && $vidange->getCarId() === $vehicule->getId()) {
                $historique = new VidangeHistorique();
                $historique->vidange_id = $vidangeId;
                $historique->current_km = $vehicleKm;
                $historique->next_km_for_drain = $vehicleKm + $vidange->getThresholdKm();
                $historique->save();
            }
        } elseif ($vehicule->vidange) {
            // If no vidange_id but vehicle has a vidange, use it
            $vidange = $vehicule->vidange;
            $historique = new VidangeHistorique();
            $historique->vidange_id = $vidange->getId();
            $historique->current_km = $vehicleKm;
            $historique->next_km_for_drain = $vehicleKm + $vidange->getThresholdKm();
            $historique->save();
        }
    }

    /**
     * Handle fuel logic - track consumption.
     */
    protected function handleFuel(PaymentVoucher $voucher, Vehicule $vehicule, array $data): void
    {
        $vehicleKm = $voucher->getVehicleKm();

        // Update vehicle KM and Hours
        $updateData = [Vehicule::TOTAL_KM_COLUMN => $vehicleKm];
        if ($voucher->getVehicleHours() !== null) {
            $updateData[Vehicule::TOTAL_HOURS_COLUMN] = $voucher->getVehicleHours();
        }
        $vehicule->update($updateData);

        // Fuel consumption calculation can be done in a separate service or here
        // For now, we just store the data. Consumption can be calculated when needed
        // by comparing with previous fuel entries.
    }

    /**
     * Delete a payment voucher.
     */
    public function deletePaymentVoucher(PaymentVoucher $voucher): bool
    {
        // Delete document if exists
        if ($voucher->getDocumentPath()) {
            $this->fileUploadService->deleteFile($voucher->getDocumentPath());
        }

        // Delete all attachments
        $attachments = $this->attachmentRepository->getByPaymentVoucherId($voucher->getId());
        foreach ($attachments as $attachment) {
            $this->deleteAttachment($attachment->getId());
        }

        return $this->repository->delete($voucher);
    }

    /**
     * Add attachments to payment voucher.
     */
    public function addAttachments(PaymentVoucher $voucher, array $files, string $documentType): void
    {
        foreach ($files as $file) {
            $filePath = $this->fileUploadService->uploadFile($file, 'payment_vouchers/attachments');
            $fileInfo = $this->fileUploadService->getFileInfo($file);
            $this->attachmentRepository->create([
                PaymentVoucherAttachment::PAYMENT_VOUCHER_ID_COLUMN => $voucher->getId(),
                PaymentVoucherAttachment::DOCUMENT_TYPE_COLUMN => $documentType,
                PaymentVoucherAttachment::FILE_PATH_COLUMN => $filePath,
                PaymentVoucherAttachment::FILE_NAME_COLUMN => $fileInfo['name'],
                PaymentVoucherAttachment::FILE_TYPE_COLUMN => $fileInfo['type'],
                PaymentVoucherAttachment::FILE_SIZE_COLUMN => $fileInfo['size'],
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
            // Delete file from storage
            $filePath = $attachment->getFilePath();
            if ($filePath) {
                $this->fileUploadService->deleteFile($filePath);
            }
            return $this->attachmentRepository->delete($attachmentId);
        }
        return false;
    }
}

