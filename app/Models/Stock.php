<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    public const TABLE = 'stocks';
    public const ID_COLUMN = 'id';
    public const NAME_COLUMN = 'name';
    public const MIN_STOCK_ALERT_COLUMN = 'min_stock_alert';
    public const STOCK_ACTUEL_COLUMN = 'stock_actuel';
    public const UNITIE_ID_COLUMN = 'unitie_id';
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

    public function getMinStockAlert(): string
    {
        return $this->getAttribute(self::MIN_STOCK_ALERT_COLUMN);
    }

    public function getStockActuel(): string
    {
        return $this->getAttribute(self::STOCK_ACTUEL_COLUMN);
    }

    public function getUnitieId(): ?int
    {
        return $this->getAttribute(self::UNITIE_ID_COLUMN);
    }

    public function unitie()
    {
        return $this->belongsTo(Unitie::class, 'unitie_id');
    }
}
