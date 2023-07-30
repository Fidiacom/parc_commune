<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicule extends Model
{
    use HasFactory;


    public function vidange()
    {
        return $this->hasOne(Vidange::class, 'car_id');
    }

    public function timing_chaine()
    {
        return $this->hasOne(TimingChaine::class, 'car_id');
    }

    public function pneu()
    {
        return $this->hasMany(pneu::class, 'car_id');
    }

    public function trips()
    {
        $this->hasMany('App\Models\Trip');
    }
}
