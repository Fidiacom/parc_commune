<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PneuHistorique extends Model
{
    use HasFactory;

    public const TABLE = 'pneu_historiques';
    public const ID_COLUMN = 'id';
    public const PNEU_ID_COLUMN = 'pneu_id';
    public const CURRENT_KM_COLUMN = 'current_km';
    public const NEXT_KM_FOR_CHANGE_COLUMN = 'next_km_for_change';
    public const CREATED_AT_COLUMN = 'created_at';
    public const UPDATED_AT_COLUMN = 'updated_at';

    protected $table = self::TABLE;

    public function getId(): int
    {
        return $this->getAttribute(self::ID_COLUMN);
    }

    public function getPneuId(): int
    {
        return $this->getAttribute(self::PNEU_ID_COLUMN);
    }

    public function getCurrentKm(): int
    {
        return $this->getAttribute(self::CURRENT_KM_COLUMN);
    }

    public function getNextKmForChange(): int
    {
        return $this->getAttribute(self::NEXT_KM_FOR_CHANGE_COLUMN);
    }

    public function pneu()
    {
        return $this->belongsTo(pneu::class, 'pneu_id');
    }
}
