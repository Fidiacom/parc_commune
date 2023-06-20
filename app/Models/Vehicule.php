<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicule extends Model
{
    use HasFactory;


    public function vidange()
    {
        return $this->hasMany(Vidange::class, 'car_id');
    }

    public function timing_chaine()
    {
        return $this->hasMany(TimingChaine::class, 'car_id');
    }

    
}
