<?php

namespace App\Repositories;

use App\Models\PaymentVoucherAttachment;

class PaymentVoucherAttachmentRepository
{
    /**
     * Create a new payment voucher attachment.
     */
    public function create(array $data): PaymentVoucherAttachment
    {
        return PaymentVoucherAttachment::create($data);
    }

    /**
     * Get all attachments for a payment voucher.
     */
    public function getByPaymentVoucherId(int $paymentVoucherId)
    {
        return PaymentVoucherAttachment::where(PaymentVoucherAttachment::PAYMENT_VOUCHER_ID_COLUMN, $paymentVoucherId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get attachments by type for a payment voucher.
     */
    public function getByPaymentVoucherIdAndType(int $paymentVoucherId, string $documentType)
    {
        return PaymentVoucherAttachment::where(PaymentVoucherAttachment::PAYMENT_VOUCHER_ID_COLUMN, $paymentVoucherId)
            ->where(PaymentVoucherAttachment::DOCUMENT_TYPE_COLUMN, $documentType)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Delete a payment voucher attachment.
     */
    public function delete(int $attachmentId): bool
    {
        $attachment = PaymentVoucherAttachment::find($attachmentId);
        if ($attachment) {
            return $attachment->delete();
        }
        return false;
    }

    /**
     * Find attachment by ID.
     */
    public function findById(int $attachmentId): ?PaymentVoucherAttachment
    {
        return PaymentVoucherAttachment::find($attachmentId);
    }
}

