<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MissionOrder extends Model
{
    use HasFactory;

    public const TABLE = 'mission_orders';
    public const ID_COLUMN = 'id';
    public const DRIVER_ID_COLUMN = 'driver_id';
    public const VEHICULE_ID_COLUMN = 'vehicule_id';
    public const PERMANENT_COLUMN = 'permanent';
    public const START_COLUMN = 'start';
    public const END_COLUMN = 'end';
    public const DONE_AT_COLUMN = 'done_at';
    public const MISSION_FR_COLUMN = 'mission_fr';
    public const MISSION_AR_COLUMN = 'mission_ar';
    public const REGISTRATION_DATETIME_COLUMN = 'registration_datetime';
    public const PLACE_TOGO_FR_COLUMN = 'place_togo_fr';
    public const PLACE_TOGO_AR_COLUMN = 'place_togo_ar';
    public const CREATED_AT_COLUMN = 'created_at';
    public const UPDATED_AT_COLUMN = 'updated_at';

    protected $table = self::TABLE;

    protected $fillable = [
        self::DRIVER_ID_COLUMN,
        self::VEHICULE_ID_COLUMN,
        self::PERMANENT_COLUMN,
        self::START_COLUMN,
        self::END_COLUMN,
        self::DONE_AT_COLUMN,
        self::MISSION_FR_COLUMN,
        self::MISSION_AR_COLUMN,
        self::REGISTRATION_DATETIME_COLUMN,
        self::PLACE_TOGO_FR_COLUMN,
        self::PLACE_TOGO_AR_COLUMN,
    ];

    public function getId(): int
    {
        return $this->getAttribute(self::ID_COLUMN);
    }

    public function getDriverId(): ?int
    {
        return $this->getAttribute(self::DRIVER_ID_COLUMN);
    }

    public function getVehiculeId(): ?int
    {
        return $this->getAttribute(self::VEHICULE_ID_COLUMN);
    }

    public function getPermanent(): bool
    {
        return $this->getAttribute(self::PERMANENT_COLUMN);
    }

    public function getStart(): string
    {
        return $this->getAttribute(self::START_COLUMN);
    }

    public function getEnd(): ?string
    {
        return $this->getAttribute(self::END_COLUMN);
    }

    public function getDoneAt(): ?string
    {
        return $this->getAttribute(self::DONE_AT_COLUMN);
    }

    public function getMissionFr(): ?string
    {
        return $this->getAttribute(self::MISSION_FR_COLUMN);
    }

    public function getMissionAr(): ?string
    {
        return $this->getAttribute(self::MISSION_AR_COLUMN);
    }

    public function getRegistrationDatetime(): ?string
    {
        return $this->getAttribute(self::REGISTRATION_DATETIME_COLUMN);
    }

    public function getPlaceTogoFr(): ?string
    {
        return $this->getAttribute(self::PLACE_TOGO_FR_COLUMN);
    }

    public function getPlaceTogoAr(): ?string
    {
        return $this->getAttribute(self::PLACE_TOGO_AR_COLUMN);
    }

    public function isPermanent(): bool
    {
        return $this->getAttribute(self::PERMANENT_COLUMN) == 1;
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }

    public function getDriver(): ?Driver
    {
        return $this->driver;
    }

    public function vehicule()
    {
        return $this->belongsTo(Vehicule::class, 'vehicule_id');
    }

    public function getVehicule(): ?Vehicule
    {
        return $this->vehicule;
    }

    public function getCreatedAt(): string
    {
        return $this->getAttribute(self::CREATED_AT_COLUMN);
    }
}

