<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unitie extends Model
{
    use HasFactory;


    public function stock()
    {
        return $this->HasOne(Stock::class);
    }
}
