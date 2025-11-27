<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Driver extends Model
{
    use HasFactory, SoftDeletes;

    public const TABLE = 'drivers';
    public const ID_COLUMN = 'id';
    public const IMAGE_COLUMN = 'image';
    public const FIRST_NAME_AR_COLUMN = 'first_name_ar';
    public const FIRST_NAME_FR_COLUMN = 'first_name_fr';
    public const LAST_NAME_AR_COLUMN = 'last_name_ar';
    public const LAST_NAME_FR_COLUMN = 'last_name_fr';
    public const ROLE_AR_COLUMN = 'role_ar';
    public const ROLE_FR_COLUMN = 'role_fr';
    public const CIN_COLUMN = 'cin';
    public const PHONE_COLUMN = 'phone';
    public const CREATED_AT_COLUMN = 'created_at';
    public const UPDATED_AT_COLUMN = 'updated_at';

    protected $table = self::TABLE;

    protected $fillable = [
        self::IMAGE_COLUMN,
        self::FIRST_NAME_AR_COLUMN,
        self::FIRST_NAME_FR_COLUMN,
        self::LAST_NAME_AR_COLUMN,
        self::LAST_NAME_FR_COLUMN,
        self::ROLE_AR_COLUMN,
        self::ROLE_FR_COLUMN,
        self::CIN_COLUMN,
        self::PHONE_COLUMN,
    ];

    public function getId(): int
    {
        return $this->getAttribute(self::ID_COLUMN);
    }

    public function getImage(): ?string
    {
        return $this->getAttribute(self::IMAGE_COLUMN);
    }

    public function getFirstNameAr(): ?string
    {
        return $this->getAttribute(self::FIRST_NAME_AR_COLUMN);
    }

    public function getFirstNameFr(): ?string
    {
        return $this->getAttribute(self::FIRST_NAME_FR_COLUMN);
    }

    public function getLastNameAr(): ?string
    {
        return $this->getAttribute(self::LAST_NAME_AR_COLUMN);
    }

    public function getLastNameFr(): ?string
    {
        return $this->getAttribute(self::LAST_NAME_FR_COLUMN);
    }

    public function getRoleAr(): ?string
    {
        return $this->getAttribute(self::ROLE_AR_COLUMN);
    }

    public function getRoleFr(): ?string
    {
        return $this->getAttribute(self::ROLE_FR_COLUMN);
    }

    public function getCin(): ?string
    {
        return $this->getAttribute(self::CIN_COLUMN);
    }

    public function getPhone(): ?string
    {
        return $this->getAttribute(self::PHONE_COLUMN);
    }

    public function permis()
    {
        return $this->belongsToMany(CategoriePermi::class, 'driver_has_permis', 'driver_id', 'permi_id');
    }

    public function missionOrders()
    {
        return $this->hasMany(MissionOrder::class, 'driver_id');
    }
}
