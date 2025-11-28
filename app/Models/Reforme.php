<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reforme extends Model
{
    use HasFactory, SoftDeletes;

    public const TABLE = 'reformes';
    public const ID_COLUMN = 'id';
    public const VEHICULE_ID_COLUMN = 'vehicule_id';
    public const DESCRIPTION_COLUMN = 'description';
    public const STATUS_COLUMN = 'status';
    public const CREATED_AT_COLUMN = 'created_at';
    public const UPDATED_AT_COLUMN = 'updated_at';

    public const STATUS_IN_PROGRESS = 'in_progress';
    public const STATUS_CONFIRMED = 'confirmed';
    public const STATUS_REJECTED = 'rejected';
    public const STATUS_SELLED = 'selled';

    protected $table = self::TABLE;

    protected $fillable = [
        self::VEHICULE_ID_COLUMN,
        self::DESCRIPTION_COLUMN,
        self::STATUS_COLUMN,
    ];

    protected $casts = [
        self::STATUS_COLUMN => 'string',
    ];

    public function getId(): int
    {
        return $this->getAttribute(self::ID_COLUMN);
    }

    public function getVehiculeId(): int
    {
        return $this->getAttribute(self::VEHICULE_ID_COLUMN);
    }

    public function getDescription(): string
    {
        return $this->getAttribute(self::DESCRIPTION_COLUMN);
    }

    public function getStatus(): string
    {
        return $this->getAttribute(self::STATUS_COLUMN);
    }

    public function vehicule()
    {
        return $this->belongsTo(Vehicule::class, self::VEHICULE_ID_COLUMN);
    }

    public function getVehicule(): ?Vehicule
    {
        return $this->vehicule;
    }

    public function statusHistoriques()
    {
        return $this->hasMany(ReformeStatusHistorique::class, 'reforme_id');
    }

    public function attachments()
    {
        return $this->hasMany(ReformeAttachment::class, 'reforme_id');
    }
}


