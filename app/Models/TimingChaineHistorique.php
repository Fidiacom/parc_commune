<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimingChaineHistorique extends Model
{
    use HasFactory;


    public function timing_chaine()
    {
        return $this->hasOne(TimingChaine::class);
    }
}
