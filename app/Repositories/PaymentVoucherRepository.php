<?php

namespace App\Repositories;

use App\Models\PaymentVoucher;

class PaymentVoucherRepository
{
    /**
     * Get all payment vouchers.
     *
     * @param array<string, mixed> $filters
     */
    public function getAll(array $filters = [])
    {
        $query = PaymentVoucher::with(['vehicule', 'tire', 'vidange', 'timingChaine']);

        $this->applyDateFilters($query, $filters);

        return $this->applyDateSorting($query, $filters)->get();
    }
    
    /**
     * Get payment vouchers by category.
     *
     * @param array<string, mixed> $filters
     */
    public function getByCategory(string $category, array $filters = [])
    {
        $query = PaymentVoucher::with(['vehicule', 'tire', 'vidange', 'timingChaine'])
            ->where(PaymentVoucher::CATEGORY_COLUMN, $category);

        $this->applyDateFilters($query, $filters);

        return $this->applyDateSorting($query, $filters)->get();
    }

    /**
     * Get payment vouchers filtered by optional category and invoice date range,
     * sorted by invoice date.
     */
    public function getByFilters(
        ?string $category = null,
        ?string $dateFrom = null,
        ?string $dateTo = null,
        string $sortDirection = 'desc'
    ) {
        $query = PaymentVoucher::with(['vehicule', 'tire', 'vidange', 'timingChaine']);

        if ($category !== null) {
            $query->where(PaymentVoucher::CATEGORY_COLUMN, $category);
        }

        if ($dateFrom) {
            $query->whereDate(PaymentVoucher::INVOICE_DATE_COLUMN, '>=', $dateFrom);
        }

        if ($dateTo) {
            $query->whereDate(PaymentVoucher::INVOICE_DATE_COLUMN, '<=', $dateTo);
        }

        $direction = strtolower($sortDirection) === 'asc' ? 'asc' : 'desc';

        $query->orderBy(PaymentVoucher::INVOICE_DATE_COLUMN, $direction);

        return $query->get();
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
        $nextNumber = $lastVoucher
            ? intval(substr($lastVoucher->getVoucherNumber(), 4)) + 1
            : 1;

        // Ensure uniqueness even under concurrency or manual inserts
        do {
            $candidate = 'BON-' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);
            $exists = PaymentVoucher::where(PaymentVoucher::VOUCHER_NUMBER_COLUMN, $candidate)->exists();
            if (!$exists) {
                return $candidate;
            }
            $nextNumber++;
        } while (true);
    }

    /**
     * Apply date range filters to the query.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array<string, mixed> $filters
     */
    protected function applyDateFilters($query, array $filters): void
    {
        if (!empty($filters['from_date'])) {
            $query->whereDate(PaymentVoucher::INVOICE_DATE_COLUMN, '>=', $filters['from_date']);
        }

        if (!empty($filters['to_date'])) {
            $query->whereDate(PaymentVoucher::INVOICE_DATE_COLUMN, '<=', $filters['to_date']);
        }
    }

    /**
     * Apply date sorting to the query.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array<string, mixed> $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function applyDateSorting($query, array $filters)
    {
        $direction = 'desc';

        if (!empty($filters['sort_date']) && in_array(strtolower($filters['sort_date']), ['asc', 'desc'], true)) {
            $direction = strtolower($filters['sort_date']);
        }

        return $query->orderBy(PaymentVoucher::INVOICE_DATE_COLUMN, $direction);
    }
}

