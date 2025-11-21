<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    public const TABLE = 'drivers';
    public const ID_COLUMN = 'id';
    public const IMAGE_COLUMN = 'image';
    public const FULL_NAME_COLUMN = 'full_name';
    public const CIN_COLUMN = 'cin';
    public const PHONE_COLUMN = 'phone';
    public const CREATED_AT_COLUMN = 'created_at';
    public const UPDATED_AT_COLUMN = 'updated_at';

    protected $table = self::TABLE;

    public function getId(): int
    {
        return $this->getAttribute(self::ID_COLUMN);
    }

    public function getImage(): ?string
    {
        return $this->getAttribute(self::IMAGE_COLUMN);
    }

    public function getFullName(): string
    {
        return $this->getAttribute(self::FULL_NAME_COLUMN);
    }

    public function getCin(): string
    {
        return $this->getAttribute(self::CIN_COLUMN);
    }

    public function getPhone(): string
    {
        return $this->getAttribute(self::PHONE_COLUMN);
    }

    public function permis()
    {
        return $this->belongsToMany(CategoriePermi::class, 'driver_has_permis', 'driver_id', 'permi_id');
    }

    public function trips()
    {
        return $this->hasMany(Trip::class, 'driver_id');
    }
}
