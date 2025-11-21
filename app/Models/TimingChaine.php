<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimingChaine extends Model
{
    use HasFactory;

    public const TABLE = 'timing_chaines';
    public const ID_COLUMN = 'id';
    public const CAR_ID_COLUMN = 'car_id';
    public const THRESHOLD_KM_COLUMN = 'threshold_km';
    public const CREATED_AT_COLUMN = 'created_at';
    public const UPDATED_AT_COLUMN = 'updated_at';

    protected $table = self::TABLE;

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

    public function vehicule()
    {
        return $this->belongsTo(Vehicule::class, 'car_id');
    }

    public function timingchaine_historique()
    {
        return $this->hasMany(TimingChaineHistorique::class, 'chaine_id');
    }
}
