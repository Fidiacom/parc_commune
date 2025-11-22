<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    public const TABLE = 'attachments';
    public const ID_COLUMN = 'id';
    public const FILE_PATH_COLUMN = 'file_path';
    public const ATTACHABLE_ID_COLUMN = 'attachable_id';
    public const ATTACHABLE_TYPE_COLUMN = 'attachable_type';
    public const CREATED_AT_COLUMN = 'created_at';
    public const UPDATED_AT_COLUMN = 'updated_at';

    protected $table = self::TABLE;

    public function getId(): int
    {
        return $this->getAttribute(self::ID_COLUMN);
    }

    public function getFilePath(): string
    {
        return $this->getAttribute(self::FILE_PATH_COLUMN);
    }

    public function getAttachableId(): int
    {
        return $this->getAttribute(self::ATTACHABLE_ID_COLUMN);
    }

    public function getAttachableType(): string
    {
        return $this->getAttribute(self::ATTACHABLE_TYPE_COLUMN);
    }

    public function attachable()
    {
        return $this->morphTo();
    }
}
