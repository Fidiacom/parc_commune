<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MissionCompanion extends Model
{
    use HasFactory;

    public const TABLE = 'mission_companions';
    public const ID_COLUMN = 'id';
    public const FIRST_NAME_FR_COLUMN = 'first_name_fr';
    public const LAST_NAME_FR_COLUMN = 'last_name_fr';
    public const FIRST_NAME_AR_COLUMN = 'first_name_ar';
    public const LAST_NAME_AR_COLUMN = 'last_name_ar';
    public const CIN_COLUMN = 'cin';
    public const CREATED_AT_COLUMN = 'created_at';
    public const UPDATED_AT_COLUMN = 'updated_at';

    protected $table = self::TABLE;

    protected $fillable = [
        self::FIRST_NAME_FR_COLUMN,
        self::LAST_NAME_FR_COLUMN,
        self::FIRST_NAME_AR_COLUMN,
        self::LAST_NAME_AR_COLUMN,
        self::CIN_COLUMN,
    ];

    public function getId(): int
    {
        return $this->getAttribute(self::ID_COLUMN);
    }

    public function getFirstNameFr(): ?string
    {
        return $this->getAttribute(self::FIRST_NAME_FR_COLUMN);
    }

    public function getLastNameFr(): ?string
    {
        return $this->getAttribute(self::LAST_NAME_FR_COLUMN);
    }

    public function getFirstNameAr(): ?string
    {
        return $this->getAttribute(self::FIRST_NAME_AR_COLUMN);
    }

    public function getLastNameAr(): ?string
    {
        return $this->getAttribute(self::LAST_NAME_AR_COLUMN);
    }

    public function getCin(): ?string
    {
        return $this->getAttribute(self::CIN_COLUMN);
    }

    public function getFullNameFr(): string
    {
        return trim(($this->getFirstNameFr() ?? '') . ' ' . ($this->getLastNameFr() ?? ''));
    }

    public function getFullNameAr(): string
    {
        return trim(($this->getFirstNameAr() ?? '') . ' ' . ($this->getLastNameAr() ?? ''));
    }

    public function getDisplayName(): string
    {
        $name = $this->getFullNameFr();
        if ($name !== '') {
            return $name;
        }

        $name = $this->getFullNameAr();
        if ($name !== '') {
            return $name;
        }

        return $this->getCin() ?? '';
    }

    public function missionOrders()
    {
        return $this->belongsToMany(
            MissionOrder::class,
            'mission_order_companion',
            'mission_companion_id',
            'mission_order_id'
        );
    }
}
