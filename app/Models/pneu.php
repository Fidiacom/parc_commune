<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pneu extends Model
{
    use HasFactory;

    public const TABLE = 'pneus';
    public const ID_COLUMN = 'id';
    public const CAR_ID_COLUMN = 'car_id';
    public const THRESHOLD_KM_COLUMN = 'threshold_km';
    public const TIRE_POSITION_COLUMN = 'tire_position';
    public const CREATED_AT_COLUMN = 'created_at';
    public const UPDATED_AT_COLUMN = 'updated_at';

    protected $table = self::TABLE;

    protected $fillable = [
        self::CAR_ID_COLUMN,
        self::THRESHOLD_KM_COLUMN,
        self::TIRE_POSITION_COLUMN,
    ];

    public function getId(): int
    {
        return $this->getAttribute(self::ID_COLUMN);
    }

    public function getCarId(): int
    {
        return $this->getAttribute(self::CAR_ID_COLUMN);
    }

    public function getThresholdKm(): int
    {
        return $this->getAttribute(self::THRESHOLD_KM_COLUMN);
    }

    public function getTirePosition(): string
    {
        return $this->getAttribute(self::TIRE_POSITION_COLUMN);
    }

    public function vehicule()
    {
        return $this->belongsTo(Vehicule::class, 'car_id');
    }

    public function pneu_historique()
    {
        return $this->hasMany(PneuHistorique::class, 'pneu_id');
    }
}
