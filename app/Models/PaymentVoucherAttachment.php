<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentVoucherAttachment extends Model
{
    use HasFactory;

    public const TABLE = 'payment_voucher_attachments';
    public const ID_COLUMN = 'id';
    public const PAYMENT_VOUCHER_ID_COLUMN = 'payment_voucher_id';
    public const DOCUMENT_TYPE_COLUMN = 'document_type';
    public const FILE_PATH_COLUMN = 'file_path';
    public const FILE_NAME_COLUMN = 'file_name';
    public const FILE_TYPE_COLUMN = 'file_type';
    public const FILE_SIZE_COLUMN = 'file_size';
    public const CREATED_AT_COLUMN = 'created_at';
    public const UPDATED_AT_COLUMN = 'updated_at';

    // Document types
    public const TYPE_VOUCHER = 'voucher';
    public const TYPE_INVOICE = 'invoice';
    public const TYPE_VIGNETTE = 'vignette';
    public const TYPE_OTHER = 'other';

    protected $table = self::TABLE;

    protected $fillable = [
        self::PAYMENT_VOUCHER_ID_COLUMN,
        self::DOCUMENT_TYPE_COLUMN,
        self::FILE_PATH_COLUMN,
        self::FILE_NAME_COLUMN,
        self::FILE_TYPE_COLUMN,
        self::FILE_SIZE_COLUMN,
    ];

    public function getId(): int
    {
        return $this->getAttribute(self::ID_COLUMN);
    }

    public function getPaymentVoucherId(): int
    {
        return $this->getAttribute(self::PAYMENT_VOUCHER_ID_COLUMN);
    }

    public function getDocumentType(): string
    {
        return $this->getAttribute(self::DOCUMENT_TYPE_COLUMN);
    }

    public function getFilePath(): string
    {
        return $this->getAttribute(self::FILE_PATH_COLUMN);
    }

    public function getFileName(): ?string
    {
        return $this->getAttribute(self::FILE_NAME_COLUMN);
    }

    public function getFileType(): ?string
    {
        return $this->getAttribute(self::FILE_TYPE_COLUMN);
    }

    public function getFileSize(): ?int
    {
        return $this->getAttribute(self::FILE_SIZE_COLUMN);
    }

    public function paymentVoucher()
    {
        return $this->belongsTo(PaymentVoucher::class, self::PAYMENT_VOUCHER_ID_COLUMN);
    }

    /**
     * Get document type label in French.
     */
    public function getDocumentTypeLabel(): string
    {
        return match($this->getDocumentType()) {
            self::TYPE_VOUCHER => __('Bon'),
            self::TYPE_INVOICE => __('Facture'),
            self::TYPE_VIGNETTE => __('Vignette'),
            self::TYPE_OTHER => __('Autre'),
            default => __('Inconnu'),
        };
    }
}

