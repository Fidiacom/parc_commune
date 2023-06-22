<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriePermi extends Model
{
    use HasFactory;


    public function driver()
    {
        return $this->belongsToMany('App\Models\Driver', 'driver_has_permis', 'permi_id', 'driver_id');
    }
}
