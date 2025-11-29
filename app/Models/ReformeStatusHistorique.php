<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReformeStatusHistorique extends Model
{
    use HasFactory;

    public const TABLE = 'reforme_status_historiques';
    public const ID_COLUMN = 'id';
    public const REFORME_ID_COLUMN = 'reforme_id';
    public const STATUS_COLUMN = 'status';
    public const DESCRIPTION_COLUMN = 'description';
    public const CREATED_AT_COLUMN = 'created_at';
    public const UPDATED_AT_COLUMN = 'updated_at';

    protected $table = self::TABLE;

    protected $fillable = [
        self::REFORME_ID_COLUMN,
        self::STATUS_COLUMN,
        self::DESCRIPTION_COLUMN,
    ];

    public function getId(): int
    {
        return $this->getAttribute(self::ID_COLUMN);
    }

    public function getReformeId(): int
    {
        return $this->getAttribute(self::REFORME_ID_COLUMN);
    }

    public function getStatus(): string
    {
        return $this->getAttribute(self::STATUS_COLUMN);
    }

    public function getDescription(): ?string
    {
        return $this->getAttribute(self::DESCRIPTION_COLUMN);
    }

    public function reforme()
    {
        return $this->belongsTo(Reforme::class, self::REFORME_ID_COLUMN);
    }

    public function getReforme(): ?Reforme
    {
        return $this->reforme;
    }

    public function attachments()
    {
        return $this->hasMany(ReformeStatusAttachment::class, 'reforme_status_historique_id');
    }
}




