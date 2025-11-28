<?php

namespace App\Repositories;

use App\Models\PaymentVoucher;

class PaymentVoucherRepository
{
    /**
     * Get all payment vouchers.
     */
    public function getAll()
    {
        return PaymentVoucher::with(['vehicule', 'tire', 'vidange', 'timingChaine'])
            ->latest()
            ->get();
    }

    /**
     * Get payment vouchers by category.
     */
    public function getByCategory(string $category)
    {
        return PaymentVoucher::with(['vehicule', 'tire', 'vidange', 'timingChaine'])
            ->where(PaymentVoucher::CATEGORY_COLUMN, $category)
            ->latest()
            ->get();
    }

    /**
     * Get payment vouchers by vehicule.
     */
    public function getByVehicule(int $vehiculeId)
    {
        return PaymentVoucher::with(['vehicule', 'tire', 'vidange', 'timingChaine'])
            ->where(PaymentVoucher::VEHICULE_ID_COLUMN, $vehiculeId)
            ->latest()
            ->get();
    }

    /**
     * Find payment voucher by ID.
     */
    public function findById(int $id): ?PaymentVoucher
    {
        return PaymentVoucher::with(['vehicule', 'tire', 'vidange', 'timingChaine'])->find($id);
    }

    /**
     * Find payment voucher by voucher number.
     */
    public function findByVoucherNumber(string $voucherNumber): ?PaymentVoucher
    {
        return PaymentVoucher::where(PaymentVoucher::VOUCHER_NUMBER_COLUMN, $voucherNumber)->first();
    }

    /**
     * Create a new payment voucher.
     */
    public function create(array $data): PaymentVoucher
    {
        return PaymentVoucher::create($data);
    }

    /**
     * Update a payment voucher.
     */
    public function update(PaymentVoucher $paymentVoucher, array $data): bool
    {
        return $paymentVoucher->update($data);
    }

    /**
     * Delete a payment voucher.
     */
    public function delete(PaymentVoucher $paymentVoucher): bool
    {
        return $paymentVoucher->delete();
    }

    /**
     * Generate next voucher number.
     */
    public function generateNextVoucherNumber(): string
    {
        $lastVoucher = PaymentVoucher::orderBy('id', 'desc')->first();
        
        if ($lastVoucher) {
            $lastNumber = intval(substr($lastVoucher->getVoucherNumber(), 4));
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }
        
        return 'BON-' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);
    }
}

