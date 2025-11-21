<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    public const TABLE = 'trips';
    public const ID_COLUMN = 'id';
    public const DRIVER_ID_COLUMN = 'driver_id';
    public const VEHICULE_ID_COLUMN = 'vehicule_id';
    public const PERMANENT_COLUMN = 'permanent';
    public const START_COLUMN = 'start';
    public const END_COLUMN = 'end';
    public const DONE_AT_COLUMN = 'done_at';
    public const CREATED_AT_COLUMN = 'created_at';
    public const UPDATED_AT_COLUMN = 'updated_at';

    protected $table = self::TABLE;

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

    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }

    public function vehicule()
    {
        return $this->belongsTo(Vehicule::class, 'vehicule_id');
    }
}
