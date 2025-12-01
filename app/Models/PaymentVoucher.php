<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentVoucher extends Model
{
    use HasFactory;

    public const TABLE = 'payment_vouchers';
    public const ID_COLUMN = 'id';
    public const VOUCHER_NUMBER_COLUMN = 'voucher_number';
    public const INVOICE_NUMBER_COLUMN = 'invoice_number';
    public const INVOICE_DATE_COLUMN = 'invoice_date';
    public const AMOUNT_COLUMN = 'amount';
    public const DENOMINATIONS_COLUMN = 'denominations';
    public const VEHICULE_ID_COLUMN = 'vehicule_id';
    public const VEHICLE_KM_COLUMN = 'vehicle_km';
    public const VEHICLE_HOURS_COLUMN = 'vehicle_hours';
    public const DOCUMENT_PATH_COLUMN = 'document_path';
    public const ADDITIONAL_INFO_COLUMN = 'additional_info';
    public const SUPPLIER_COLUMN = 'supplier';
    public const INSURANCE_EXPIRATION_DATE_COLUMN = 'insurance_expiration_date';
    public const TECHNICAL_VISIT_EXPIRATION_DATE_COLUMN = 'technical_visit_expiration_date';
    public const CATEGORY_COLUMN = 'category';
    public const FUEL_LITERS_COLUMN = 'fuel_liters';
    public const TIRE_ID_COLUMN = 'tire_id';
    public const VIDANGE_ID_COLUMN = 'vidange_id';
    public const TIMING_CHAINE_ID_COLUMN = 'timing_chaine_id';
    public const CREATED_AT_COLUMN = 'created_at';
    public const UPDATED_AT_COLUMN = 'updated_at';

    protected $table = self::TABLE;

    protected $fillable = [
        self::VOUCHER_NUMBER_COLUMN,
        self::INVOICE_NUMBER_COLUMN,
        self::INVOICE_DATE_COLUMN,
        self::AMOUNT_COLUMN,
        self::DENOMINATIONS_COLUMN,
        self::VEHICULE_ID_COLUMN,
        self::VEHICLE_KM_COLUMN,
        self::VEHICLE_HOURS_COLUMN,
        self::DOCUMENT_PATH_COLUMN,
        self::ADDITIONAL_INFO_COLUMN,
        self::SUPPLIER_COLUMN,
        self::INSURANCE_EXPIRATION_DATE_COLUMN,
        self::TECHNICAL_VISIT_EXPIRATION_DATE_COLUMN,
        self::CATEGORY_COLUMN,
        self::FUEL_LITERS_COLUMN,
        self::TIRE_ID_COLUMN,
        self::VIDANGE_ID_COLUMN,
        self::TIMING_CHAINE_ID_COLUMN,
    ];

    public function getId(): int
    {
        return $this->getAttribute(self::ID_COLUMN);
    }

    public function getVoucherNumber(): string
    {
        return $this->getAttribute(self::VOUCHER_NUMBER_COLUMN);
    }

    public function getInvoiceNumber(): ?string
    {
        return $this->getAttribute(self::INVOICE_NUMBER_COLUMN);
    }

    public function getInvoiceDate(): string
    {
        return $this->getAttribute(self::INVOICE_DATE_COLUMN);
    }

    public function getAmount(): float
    {
        return $this->getAttribute(self::AMOUNT_COLUMN);
    }

    public function getDenominations(): ?array
    {
        $denominations = $this->getAttribute(self::DENOMINATIONS_COLUMN);
        return $denominations ? json_decode($denominations, true) : null;
    }

    public function getVehiculeId(): int
    {
        return $this->getAttribute(self::VEHICULE_ID_COLUMN);
    }

    public function getVehicleKm(): int
    {
        return $this->getAttribute(self::VEHICLE_KM_COLUMN);
    }

    public function getVehicleHours(): ?int
    {
        return $this->getAttribute(self::VEHICLE_HOURS_COLUMN);
    }

    public function getDocumentPath(): ?string
    {
        return $this->getAttribute(self::DOCUMENT_PATH_COLUMN);
    }

    public function getAdditionalInfo(): ?string
    {
        return $this->getAttribute(self::ADDITIONAL_INFO_COLUMN);
    }

    public function getSupplier(): ?string
    {
        return $this->getAttribute(self::SUPPLIER_COLUMN);
    }

    public function getInsuranceExpirationDate(): ?string
    {
        return $this->getAttribute(self::INSURANCE_EXPIRATION_DATE_COLUMN);
    }

    public function getTechnicalVisitExpirationDate(): ?string
    {
        return $this->getAttribute(self::TECHNICAL_VISIT_EXPIRATION_DATE_COLUMN);
    }

    public function getCategory(): string
    {
        return $this->getAttribute(self::CATEGORY_COLUMN);
    }

    public function getFuelLiters(): ?float
    {
        return $this->getAttribute(self::FUEL_LITERS_COLUMN);
    }

    public function getTireId(): ?int
    {
        return $this->getAttribute(self::TIRE_ID_COLUMN);
    }

    public function getVidangeId(): ?int
    {
        return $this->getAttribute(self::VIDANGE_ID_COLUMN);
    }

    public function getTimingChaineId(): ?int
    {
        return $this->getAttribute(self::TIMING_CHAINE_ID_COLUMN);
    }

    public function vehicule()
    {
        return $this->belongsTo(Vehicule::class, self::VEHICULE_ID_COLUMN);
    }

    public function tire()
    {
        return $this->belongsTo(pneu::class, self::TIRE_ID_COLUMN);
    }

    public function vidange()
    {
        return $this->belongsTo(Vidange::class, self::VIDANGE_ID_COLUMN);
    }

    public function timingChaine()
    {
        return $this->belongsTo(TimingChaine::class, self::TIMING_CHAINE_ID_COLUMN);
    }

    public function attachments()
    {
        return $this->hasMany(PaymentVoucherAttachment::class, 'payment_voucher_id');
    }

    public function getAttachments(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->attachments;
    }
}
