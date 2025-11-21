<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriePermi extends Model
{
    use HasFactory;

    public const TABLE = 'categorie_permis';
    public const ID_COLUMN = 'id';
    public const LABEL_COLUMN = 'label';
    public const CREATED_AT_COLUMN = 'created_at';
    public const UPDATED_AT_COLUMN = 'updated_at';

    protected $table = self::TABLE;

    public function getId(): int
    {
        return $this->getAttribute(self::ID_COLUMN);
    }

    public function getLabel(): string
    {
        return $this->getAttribute(self::LABEL_COLUMN);
    }

    public function driver()
    {
        return $this->belongsToMany(Driver::class, 'driver_has_permis', 'permi_id', 'driver_id');
    }
}
