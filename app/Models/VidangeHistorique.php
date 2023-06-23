<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VidangeHistorique extends Model
{
    use HasFactory;


    public function vidange()
    {
        $this->hasOne(Vidange::class);
    }
}
