<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimingChaineHistorique extends Model
{
    use HasFactory;

    public const TABLE = 'timing_chaine_historiques';
    public const ID_COLUMN = 'id';
    public const CHAINE_ID_COLUMN = 'chaine_id';
    public const CURRENT_KM_COLUMN = 'current_km';
    public const NEXT_KM_FOR_CHANGE_COLUMN = 'next_km_for_change';
    public const CREATED_AT_COLUMN = 'created_at';
    public const UPDATED_AT_COLUMN = 'updated_at';

    protected $table = self::TABLE;

    public function getId(): int
    {
        return $this->getAttribute(self::ID_COLUMN);
    }

    public function getChaineId(): int
    {
        return $this->getAttribute(self::CHAINE_ID_COLUMN);
    }

    public function getCurrentKm(): int
    {
        return $this->getAttribute(self::CURRENT_KM_COLUMN);
    }

    public function getNextKmForChange(): int
    {
        return $this->getAttribute(self::NEXT_KM_FOR_CHANGE_COLUMN);
    }

    public function timing_chaine()
    {
        return $this->belongsTo(TimingChaine::class, 'chaine_id');
    }
}
