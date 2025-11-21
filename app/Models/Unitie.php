<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unitie extends Model
{
    use HasFactory;

    public const TABLE = 'unities';
    public const ID_COLUMN = 'id';
    public const NAME_COLUMN = 'name';
    public const CREATED_AT_COLUMN = 'created_at';
    public const UPDATED_AT_COLUMN = 'updated_at';

    protected $table = self::TABLE;

    public function getId(): int
    {
        return $this->getAttribute(self::ID_COLUMN);
    }

    public function getName(): string
    {
        return $this->getAttribute(self::NAME_COLUMN);
    }

    public function stock()
    {
        return $this->hasOne(Stock::class, 'unitie_id');
    }
}
