<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vidange extends Model
{
    use HasFactory;


    public function vehicule()
    {
        return $this->belongTo(Vehicule::class);
    }


    public function vidange_historique()
    {
        return $this->HasMany(VidangeHistorique::class);
    }
}
