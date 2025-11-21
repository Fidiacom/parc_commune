<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverHasPermi extends Model
{
    use HasFactory;

    public const TABLE = 'driver_has_permis';
    public const ID_COLUMN = 'id';
    public const DRIVER_ID_COLUMN = 'driver_id';
    public const PERMI_ID_COLUMN = 'permi_id';
    public const CREATED_AT_COLUMN = 'created_at';
    public const UPDATED_AT_COLUMN = 'updated_at';

    protected $table = self::TABLE;

    public function getId(): int
    {
        return $this->getAttribute(self::ID_COLUMN);
    }

    public function getDriverId(): int
    {
        return $this->getAttribute(self::DRIVER_ID_COLUMN);
    }

    public function getPermiId(): int
    {
        return $this->getAttribute(self::PERMI_ID_COLUMN);
    }
}
