<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VidangeHistorique extends Model
{
    use HasFactory;

    public const TABLE = 'vidange_historiques';
    public const ID_COLUMN = 'id';
    public const VIDANGE_ID_COLUMN = 'vidange_id';
    public const CURRENT_KM_COLUMN = 'current_km';
    public const NEXT_KM_FOR_DRAIN_COLUMN = 'next_km_for_drain';
    public const CREATED_AT_COLUMN = 'created_at';
    public const UPDATED_AT_COLUMN = 'updated_at';

    protected $table = self::TABLE;

    public function getId(): int
    {
        return $this->getAttribute(self::ID_COLUMN);
    }

    public function getVidangeId(): int
    {
        return $this->getAttribute(self::VIDANGE_ID_COLUMN);
    }

    public function getCurrentKm(): int
    {
        return $this->getAttribute(self::CURRENT_KM_COLUMN);
    }

    public function getNextKmForDrain(): int
    {
        return $this->getAttribute(self::NEXT_KM_FOR_DRAIN_COLUMN);
    }

    public function vidange()
    {
        return $this->belongsTo(Vidange::class, 'vidange_id');
    }
}
