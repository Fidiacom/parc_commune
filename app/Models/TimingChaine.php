<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimingChaine extends Model
{
    use HasFactory;



    public function vehicule()
    {
        return $this->belongTo(Vehicule::class);
    }


    public function timingchaine_historique()
    {
        return $this->HasMany(TimingChaineHistorique::class, 'chaine_id');
    }
}
