<?php

namespace App\Services;

use App\Managers\PaymentVoucherManager;
use App\Models\PaymentVoucher;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class PaymentVoucherService
{
    protected PaymentVoucherManager $manager;

    public function __construct(PaymentVoucherManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Get all payment vouchers.
     */
    public function getAllPaymentVouchers(array $filters = [])
    {
        $repository = $this->manager->getRepository();
        return $repository->getAll($filters);
    }

    /**
     * Get payment vouchers by category.
     */
    public function getPaymentVouchersByCategory(string $category, array $filters = [])
    {
        $repository = $this->manager->getRepository();
        return $repository->getByCategory($category, $filters);
    }

    /**
     * Get payment vouchers by optional category and date range filters.
     */
    public function getPaymentVouchersByFilters(
        ?string $category = null,
        ?string $dateFrom = null,
        ?string $dateTo = null,
        ?string $sortDirection = null
    ) {
        $repository = $this->manager->getRepository();

        return $repository->getByFilters(
            $category,
            $dateFrom,
            $dateTo,
            $sortDirection ?? 'desc'
        );
    }

    /**
     * Get payment voucher by ID.
     */
    public function getPaymentVoucherById(int $id): ?PaymentVoucher
    {
        $repository = $this->manager->getRepository();
        return $repository->findById($id);
    }

    /**
     * Create a payment voucher from request.
     */
    public function createPaymentVoucher(Request $request): PaymentVoucher
    {
        $data = [
            PaymentVoucher::VOUCHER_DATE_COLUMN => $request->voucher_date ?? $request->invoice_date,
            PaymentVoucher::INVOICE_NUMBER_COLUMN => $request->invoice_number,
            PaymentVoucher::INVOICE_DATE_COLUMN => $request->invoice_date,
            PaymentVoucher::AMOUNT_COLUMN => $this->normalizeInteger($request->amount),
            PaymentVoucher::VEHICULE_ID_COLUMN => $request->vehicule_id,
            PaymentVoucher::VEHICLE_KM_COLUMN => intval(str_replace(['.', ','], '', $request->vehicle_km)),
            PaymentVoucher::ADDITIONAL_INFO_COLUMN => $request->additional_info,
            PaymentVoucher::SUPPLIER_COLUMN => $request->supplier,
            PaymentVoucher::CATEGORY_COLUMN => $request->category,
        ];

        if ($request->filled('voucher_number')) {
            $data[PaymentVoucher::VOUCHER_NUMBER_COLUMN] = $request->voucher_number;
        }

        // Handle denominations
        if ($request->has('denominations') && is_array($request->denominations)) {
            $denominations = [];
            foreach ($request->denominations as $denom => $quantity) {
                $quantity = intval($quantity);
                if ($quantity > 0) {
                    $denominations[intval($denom)] = $quantity;
                }
            }
            $data[PaymentVoucher::DENOMINATIONS_COLUMN] = !empty($denominations) ? json_encode($denominations) : null;
        } else {
            $data[PaymentVoucher::DENOMINATIONS_COLUMN] = null;
        }

        // Handle vehicle hours
        if ($request->has('vehicle_hours') && $request->vehicle_hours) {
            $data[PaymentVoucher::VEHICLE_HOURS_COLUMN] = intval(str_replace(['.', ','], '', $request->vehicle_hours));
        }

        // Handle insurance expiration date
        if ($request->has('insurance_expiration_date') && $request->insurance_expiration_date) {
            $data[PaymentVoucher::INSURANCE_EXPIRATION_DATE_COLUMN] = $request->insurance_expiration_date;
        } else {
            $data[PaymentVoucher::INSURANCE_EXPIRATION_DATE_COLUMN] = null;
        }

        // Handle technical visit expiration date
        if ($request->has('technical_visit_expiration_date') && $request->technical_visit_expiration_date) {
            $data[PaymentVoucher::TECHNICAL_VISIT_EXPIRATION_DATE_COLUMN] = $request->technical_visit_expiration_date;
        } else {
            $data[PaymentVoucher::TECHNICAL_VISIT_EXPIRATION_DATE_COLUMN] = null;
        }

        // Handle technical visit expiration date
        if ($request->has('technical_visit_expiration_date') && $request->technical_visit_expiration_date) {
            $data[PaymentVoucher::TECHNICAL_VISIT_EXPIRATION_DATE_COLUMN] = $request->technical_visit_expiration_date;
        }

        // Handle category-specific fields
        if ($request->category === 'carburant' && $request->has('price_per_liter')) {
            $pricePerLiter = floatval($request->price_per_liter);
            $data[PaymentVoucher::FUEL_LITERS_COLUMN] = round($request->amount / $pricePerLiter, 2);
        }

        if ($request->category === 'rechange_pneu') {
            // Handle multiple tire IDs - store first one for backward compatibility
            if ($request->has('tire_ids') && is_array($request->tire_ids) && count($request->tire_ids) > 0) {
                $data[PaymentVoucher::TIRE_ID_COLUMN] = $request->tire_ids[0];
                // Store all tire data for processing in manager
                $data['tire_ids'] = $request->tire_ids;
                $data['tire_thresholds'] = $request->tire_thresholds ?? [];
            } elseif ($request->has('tire_id')) {
                // Backward compatibility with single tire_id
                $data[PaymentVoucher::TIRE_ID_COLUMN] = $request->tire_id;
            }
        }

        if ($request->category === 'entretien') {
            if ($request->has('vidange_id') && $request->vidange_id) {
                $data[PaymentVoucher::VIDANGE_ID_COLUMN] = $request->vidange_id;
            }
            if ($request->has('timing_chaine_id') && $request->timing_chaine_id) {
                $data[PaymentVoucher::TIMING_CHAINE_ID_COLUMN] = $request->timing_chaine_id;
            }
        }

        // Handle vidange category - find or use vidange based on threshold
        if ($request->category === 'vidange' && $request->has('vidange_threshold_km')) {
            $thresholdKm = intval(str_replace(['.', ','], '', $request->vidange_threshold_km));
            if ($thresholdKm > 0) {
                // Try to find existing vidange with this threshold for the vehicle
                $vehicule = \App\Models\Vehicule::find($request->vehicule_id);
                if ($vehicule && $vehicule->vidange) {
                    // Use the vehicle's vidange if it exists
                    $data[PaymentVoucher::VIDANGE_ID_COLUMN] = $vehicule->vidange->getId();
                }
                // Store threshold in additional_info if not already set
                if (empty($data[PaymentVoucher::ADDITIONAL_INFO_COLUMN])) {
                    $data[PaymentVoucher::ADDITIONAL_INFO_COLUMN] = __('Seuil de vidange: ') . number_format($thresholdKm, 0, ',', ' ') . ' KM';
                } else {
                    $data[PaymentVoucher::ADDITIONAL_INFO_COLUMN] .= ' | ' . __('Seuil de vidange: ') . number_format($thresholdKm, 0, ',', ' ') . ' KM';
                }
            }
        }

        // Handle vidange category - find or use vidange based on threshold
        if ($request->category === 'vidange' && $request->has('vidange_threshold_km')) {
            $thresholdKm = intval(str_replace(['.', ','], '', $request->vidange_threshold_km));
            if ($thresholdKm > 0) {
                // Try to find existing vidange with this threshold for the vehicle
                $vehicule = \App\Models\Vehicule::find($request->vehicule_id);
                if ($vehicule && $vehicule->vidange) {
                    // Use the vehicle's vidange if it exists
                    $data[PaymentVoucher::VIDANGE_ID_COLUMN] = $vehicule->vidange->getId();
                }
                // Store threshold in additional_info if not already set
                if (empty($data[PaymentVoucher::ADDITIONAL_INFO_COLUMN])) {
                    $data[PaymentVoucher::ADDITIONAL_INFO_COLUMN] = __('Seuil de vidange: ') . number_format($thresholdKm, 0, ',', ' ') . ' KM';
                } else {
                    $data[PaymentVoucher::ADDITIONAL_INFO_COLUMN] .= ' | ' . __('Seuil de vidange: ') . number_format($thresholdKm, 0, ',', ' ') . ' KM';
                }
            }
        }

        $document = $request->hasFile('document') ? $request->file('document') : null;

        return $this->manager->createPaymentVoucher($data, $document);
    }

    /**
     * Update a payment voucher from request.
     */
    public function updatePaymentVoucher(PaymentVoucher $voucher, Request $request): PaymentVoucher
    {
        $data = [
            PaymentVoucher::VOUCHER_DATE_COLUMN => $request->voucher_date ?? $request->invoice_date,
            PaymentVoucher::INVOICE_NUMBER_COLUMN => $request->invoice_number,
            PaymentVoucher::INVOICE_DATE_COLUMN => $request->invoice_date,
            PaymentVoucher::AMOUNT_COLUMN => $this->normalizeInteger($request->amount),
            PaymentVoucher::VEHICULE_ID_COLUMN => $request->vehicule_id,
            PaymentVoucher::VEHICLE_KM_COLUMN => intval(str_replace(['.', ','], '', $request->vehicle_km)),
            PaymentVoucher::ADDITIONAL_INFO_COLUMN => $request->additional_info,
            PaymentVoucher::SUPPLIER_COLUMN => $request->supplier,
            PaymentVoucher::CATEGORY_COLUMN => $request->category,
        ];

        if ($request->filled('voucher_number')) {
            $data[PaymentVoucher::VOUCHER_NUMBER_COLUMN] = $request->voucher_number;
        }

        // Handle denominations
        if ($request->has('denominations') && is_array($request->denominations)) {
            $denominations = [];
            foreach ($request->denominations as $denom => $quantity) {
                $quantity = intval($quantity);
                if ($quantity > 0) {
                    $denominations[intval($denom)] = $quantity;
                }
            }
            $data[PaymentVoucher::DENOMINATIONS_COLUMN] = !empty($denominations) ? json_encode($denominations) : null;
        } else {
            $data[PaymentVoucher::DENOMINATIONS_COLUMN] = null;
        }

        // Handle vehicle hours
        if ($request->has('vehicle_hours') && $request->vehicle_hours) {
            $data[PaymentVoucher::VEHICLE_HOURS_COLUMN] = intval(str_replace(['.', ','], '', $request->vehicle_hours));
        } else {
            $data[PaymentVoucher::VEHICLE_HOURS_COLUMN] = null;
        }

        // Handle insurance expiration date
        if ($request->has('insurance_expiration_date') && $request->insurance_expiration_date) {
            $data[PaymentVoucher::INSURANCE_EXPIRATION_DATE_COLUMN] = $request->insurance_expiration_date;
        } else {
            $data[PaymentVoucher::INSURANCE_EXPIRATION_DATE_COLUMN] = null;
        }

        // Handle technical visit expiration date
        if ($request->has('technical_visit_expiration_date') && $request->technical_visit_expiration_date) {
            $data[PaymentVoucher::TECHNICAL_VISIT_EXPIRATION_DATE_COLUMN] = $request->technical_visit_expiration_date;
        } else {
            $data[PaymentVoucher::TECHNICAL_VISIT_EXPIRATION_DATE_COLUMN] = null;
        }

        if ($request->category === 'carburant' && $request->has('price_per_liter')) {
            $pricePerLiter = floatval($request->price_per_liter);
            $data[PaymentVoucher::FUEL_LITERS_COLUMN] = round($request->amount / $pricePerLiter, 2);
        }

        if ($request->category === 'rechange_pneu') {
            // Handle multiple tire IDs - store first one for backward compatibility
            if ($request->has('tire_ids') && is_array($request->tire_ids) && count($request->tire_ids) > 0) {
                $data[PaymentVoucher::TIRE_ID_COLUMN] = $request->tire_ids[0];
                // Store all tire data for processing in manager
                $data['tire_ids'] = $request->tire_ids;
                $data['tire_thresholds'] = $request->tire_thresholds ?? [];
            } elseif ($request->has('tire_id')) {
                // Backward compatibility with single tire_id
                $data[PaymentVoucher::TIRE_ID_COLUMN] = $request->tire_id;
            } else {
                $data[PaymentVoucher::TIRE_ID_COLUMN] = null;
            }
        } else {
            $data[PaymentVoucher::TIRE_ID_COLUMN] = null;
        }

        if ($request->category === 'entretien') {
            if ($request->has('vidange_id') && $request->vidange_id) {
                $data[PaymentVoucher::VIDANGE_ID_COLUMN] = $request->vidange_id;
            } else {
                $data[PaymentVoucher::VIDANGE_ID_COLUMN] = null;
            }
            if ($request->has('timing_chaine_id') && $request->timing_chaine_id) {
                $data[PaymentVoucher::TIMING_CHAINE_ID_COLUMN] = $request->timing_chaine_id;
            } else {
                $data[PaymentVoucher::TIMING_CHAINE_ID_COLUMN] = null;
            }
        } elseif ($request->category === 'vidange') {
            // Handle vidange category - find or use vidange based on threshold
            if ($request->has('vidange_threshold_km')) {
                $thresholdKm = intval(str_replace(['.', ','], '', $request->vidange_threshold_km));
                if ($thresholdKm > 0) {
                    // Try to find existing vidange with this threshold for the vehicle
                    $vehicule = \App\Models\Vehicule::find($request->vehicule_id);
                    if ($vehicule && $vehicule->vidange) {
                        // Use the vehicle's vidange if it exists
                        $data[PaymentVoucher::VIDANGE_ID_COLUMN] = $vehicule->vidange->getId();
                    }
                    // Store threshold in additional_info if not already set
                    $thresholdInfo = __('Seuil de vidange: ') . number_format($thresholdKm, 0, ',', ' ') . ' KM';
                    if (empty($data[PaymentVoucher::ADDITIONAL_INFO_COLUMN])) {
                        $data[PaymentVoucher::ADDITIONAL_INFO_COLUMN] = $thresholdInfo;
                    } else {
                        $data[PaymentVoucher::ADDITIONAL_INFO_COLUMN] .= ' | ' . $thresholdInfo;
                    }
                }
            }
            $data[PaymentVoucher::TIMING_CHAINE_ID_COLUMN] = null;
        } else {
            $data[PaymentVoucher::VIDANGE_ID_COLUMN] = null;
            $data[PaymentVoucher::TIMING_CHAINE_ID_COLUMN] = null;
        }

        $document = $request->hasFile('document') ? $request->file('document') : null;

        return $this->manager->updatePaymentVoucher($voucher, $data, $document);
    }

    /**
     * Normalize a decimal string by removing thousand separators and
     * converting the decimal separator to a dot before casting.
     *
     * Handles:
     * - "1,234.56" (US) -> 1234.56
     * - "1.234,56" (EU) -> 1234.56
     * - "1234,56" -> 1234.56
     */
    private function normalizeInteger($value): int
    {
        $number = str_replace(["\xC2\xA0", ' '], '', (string) $value); // remove spaces/non‑breaking spaces

        $hasComma = str_contains($number, ',');
        $hasDot = str_contains($number, '.');

        if ($hasComma && $hasDot) {
            // Assume dot is thousands separator and comma is decimal separator
            $number = str_replace('.', '', $number);
            $number = str_replace(',', '.', $number);
        } elseif ($hasComma && !$hasDot) {
            // Only comma present, treat it as decimal separator
            $number = str_replace(',', '.', $number);
        } else {
            // Only dot or plain number: strip stray commas if any
            $number = str_replace(',', '', $number);
        }

        return (int) round(floatval($number));
    }

    /**
     * Delete a payment voucher.
     */
    public function deletePaymentVoucher(PaymentVoucher $voucher): bool
    {
        return $this->manager->deletePaymentVoucher($voucher);
    }

    /**
     * Add attachments to payment voucher.
     */
    public function addAttachments(PaymentVoucher $voucher, array $files, string $documentType): void
    {
        $this->manager->addAttachments($voucher, $files, $documentType);
    }

    /**
     * Delete an attachment.
     */
    public function deleteAttachment(int $attachmentId): bool
    {
        return $this->manager->deleteAttachment($attachmentId);
    }
}

