<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pneu extends Model
{
    use HasFactory;

    public function vehicule()
    {
        return $this->belongTo(Vehicule::class);
    }


    public function pneu_historique()
    {
        return $this->HasMany(PneuHistorique::class, 'pneu_id');
    }
}
