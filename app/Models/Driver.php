<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;


    public function permis()
    {
        return $this->belongsToMany('App\Models\CategoriePermi', 'driver_has_permis', 'driver_id', 'permi_id');
    }

    public function trips()
    {
        $this->hasMany('App\Models\Trip');
    }
}
