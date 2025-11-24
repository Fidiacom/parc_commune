<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehiculeImage extends Model
{
    use HasFactory;

    public const TABLE = 'vehicule_images';
    public const ID_COLUMN = 'id';
    public const VEHICULE_ID_COLUMN = 'vehicule_id';
    public const FILE_PATH_COLUMN = 'file_path';
    public const IS_MAIN_COLUMN = 'is_main';
    public const CREATED_AT_COLUMN = 'created_at';
    public const UPDATED_AT_COLUMN = 'updated_at';

    protected $table = self::TABLE;

    protected $fillable = [
        self::VEHICULE_ID_COLUMN,
        self::FILE_PATH_COLUMN,
        self::IS_MAIN_COLUMN,
    ];

    public function getId(): int
    {
        return $this->getAttribute(self::ID_COLUMN);
    }

    public function getVehiculeId(): int
    {
        return $this->getAttribute(self::VEHICULE_ID_COLUMN);
    }

    public function getFilePath(): string
    {
        return $this->getAttribute(self::FILE_PATH_COLUMN);
    }

    public function getIsMain(): bool
    {
        return $this->getAttribute(self::IS_MAIN_COLUMN);
    }

    public function vehicule()
    {
        return $this->belongsTo(Vehicule::class, self::VEHICULE_ID_COLUMN);
    }
}
