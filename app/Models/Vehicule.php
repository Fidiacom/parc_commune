<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicule extends Model
{
    use HasFactory, SoftDeletes;

    public const TABLE = 'vehicules';
    public const ID_COLUMN = 'id';
    public const BRAND_COLUMN = 'brand';
    public const IMAGE_COLUMN = 'image';
    public const MODEL_COLUMN = 'model';
    public const MATRICULE_COLUMN = 'matricule';
    public const NUM_CHASSIS_COLUMN = 'num_chassis';
    public const CIRCULATION_DATE_COLUMN = 'circulation_date';
    public const TOTAL_KM_COLUMN = 'total_km';
    public const TOTAL_HOURS_COLUMN = 'total_hours';
    public const HORSES_COLUMN = 'horses';
    public const NUMBER_OF_TIRES_COLUMN = 'number_of_tires';
    public const TIRE_SIZE_COLUMN = 'tire_size';
    public const FUEL_TYPE_COLUMN = 'fuel_type';
    public const MIN_FUEL_CONSUMPTION_100KM_COLUMN = 'min_fuel_consumption_100km';
    public const MAX_FUEL_CONSUMPTION_100KM_COLUMN = 'max_fuel_consumption_100km';
    public const AIRBAG_COLUMN = 'airbag';
    public const ABS_COLUMN = 'abs';
    public const INSSURANCE_EXPIRATION_COLUMN = 'inssurance_expiration';
    public const TECHNICALVISITE_EXPIRATION_COLUMN = 'technicalvisite_expiration';
    public const PERMIS_ID_COLUMN = 'permis_id';
    public const CREATED_AT_COLUMN = 'created_at';
    public const UPDATED_AT_COLUMN = 'updated_at';

    protected $table = self::TABLE;

    protected $fillable = [
        self::BRAND_COLUMN,
        self::IMAGE_COLUMN,
        self::MODEL_COLUMN,
        self::MATRICULE_COLUMN,
        self::NUM_CHASSIS_COLUMN,
        self::CIRCULATION_DATE_COLUMN,
        self::TOTAL_KM_COLUMN,
        self::TOTAL_HOURS_COLUMN,
        self::HORSES_COLUMN,
        self::NUMBER_OF_TIRES_COLUMN,
        self::TIRE_SIZE_COLUMN,
        self::FUEL_TYPE_COLUMN,
        self::MIN_FUEL_CONSUMPTION_100KM_COLUMN,
        self::MAX_FUEL_CONSUMPTION_100KM_COLUMN,
        self::AIRBAG_COLUMN,
        self::ABS_COLUMN,
        self::INSSURANCE_EXPIRATION_COLUMN,
        self::TECHNICALVISITE_EXPIRATION_COLUMN,
        self::PERMIS_ID_COLUMN,
    ];

    public function getId(): int
    {
        return $this->getAttribute(self::ID_COLUMN);
    }

    public function getBrand(): string
    {
        return $this->getAttribute(self::BRAND_COLUMN);
    }

    public function getImage(): ?string
    {
        return $this->getAttribute(self::IMAGE_COLUMN);
    }

    public function getModel(): string
    {
        return $this->getAttribute(self::MODEL_COLUMN);
    }

    public function getMatricule(): string
    {
        return $this->getAttribute(self::MATRICULE_COLUMN);
    }

    public function getNumChassis(): ?string
    {
        return $this->getAttribute(self::NUM_CHASSIS_COLUMN);
    }

    public function getCirculationDate(): ?string
    {
        return $this->getAttribute(self::CIRCULATION_DATE_COLUMN);
    }

    public function getTotalKm(): int
    {
        return $this->getAttribute(self::TOTAL_KM_COLUMN);
    }

    public function getTotalHours(): ?int
    {
        return $this->getAttribute(self::TOTAL_HOURS_COLUMN);
    }

    public function getHorses(): int
    {
        return $this->getAttribute(self::HORSES_COLUMN);
    }

    public function getNumberOfTires(): int
    {
        return $this->getAttribute(self::NUMBER_OF_TIRES_COLUMN);
    }

    public function getTireSize(): ?string
    {
        return $this->getAttribute(self::TIRE_SIZE_COLUMN);
    }

    public function getFuelType(): string
    {
        return $this->getAttribute(self::FUEL_TYPE_COLUMN);
    }

    public function getMinFuelConsumption100km(): ?float
    {
        return $this->getAttribute(self::MIN_FUEL_CONSUMPTION_100KM_COLUMN);
    }

    public function getMaxFuelConsumption100km(): ?float
    {
        return $this->getAttribute(self::MAX_FUEL_CONSUMPTION_100KM_COLUMN);
    }

    public function getAirbag(): bool
    {
        return $this->getAttribute(self::AIRBAG_COLUMN);
    }

    public function getAbs(): bool
    {
        return $this->getAttribute(self::ABS_COLUMN);
    }

    public function getInssuranceExpiration(): string
    {
        return $this->getAttribute(self::INSSURANCE_EXPIRATION_COLUMN);
    }

    public function getTechnicalvisiteExpiration(): ?string
    {
        return $this->getAttribute(self::TECHNICALVISITE_EXPIRATION_COLUMN);
    }

    public function getPermisId(): ?int
    {
        return $this->getAttribute(self::PERMIS_ID_COLUMN);
    }

    public function vidange()
    {
        return $this->hasOne(Vidange::class, 'car_id');
    }

    public function timing_chaine()
    {
        return $this->hasOne(TimingChaine::class, 'car_id');
    }

    public function pneu()
    {
        return $this->hasMany(pneu::class, 'car_id');
    }

    public function trips()
    {
        return $this->hasMany(Trip::class, 'vehicule_id');
    }

    public function images()
    {
        return $this->hasMany(VehiculeImage::class, 'vehicule_id');
    }

    public function attachments()
    {
        return $this->hasMany(VehiculeAttachment::class, 'vehicule_id');
    }

    public function getThresholdVidange(): int
    {
        return $this->vidange->getThresholdKm();
    }

    public function getThresholdTimingChaine(): int
    {
        return $this->timing_chaine->getThresholdKm();
    }
}
