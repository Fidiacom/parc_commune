<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehiculeAttachment extends Model
{
    use HasFactory;

    public const TABLE = 'vehicule_attachments';
    public const ID_COLUMN = 'id';
    public const VEHICULE_ID_COLUMN = 'vehicule_id';
    public const FILE_PATH_COLUMN = 'file_path';
    public const FILE_NAME_COLUMN = 'file_name';
    public const FILE_TYPE_COLUMN = 'file_type';
    public const FILE_SIZE_COLUMN = 'file_size';
    public const CREATED_AT_COLUMN = 'created_at';
    public const UPDATED_AT_COLUMN = 'updated_at';

    protected $table = self::TABLE;

    protected $fillable = [
        self::VEHICULE_ID_COLUMN,
        self::FILE_PATH_COLUMN,
        self::FILE_NAME_COLUMN,
        self::FILE_TYPE_COLUMN,
        self::FILE_SIZE_COLUMN,
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

    public function getFileName(): ?string
    {
        return $this->getAttribute(self::FILE_NAME_COLUMN);
    }

    public function getFileType(): ?string
    {
        return $this->getAttribute(self::FILE_TYPE_COLUMN);
    }

    public function getFileSize(): ?int
    {
        return $this->getAttribute(self::FILE_SIZE_COLUMN);
    }

    public function vehicule()
    {
        return $this->belongsTo(Vehicule::class, self::VEHICULE_ID_COLUMN);
    }
}
