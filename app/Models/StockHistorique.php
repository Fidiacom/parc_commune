<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockHistorique extends Model
{
    use HasFactory;

    public const TABLE = 'stock_historiques';
    public const ID_COLUMN = 'id';
    public const STOCK_ID_COLUMN = 'stock_id';
    public const TYPE_COLUMN = 'type';
    public const QUANTITE_COLUMN = 'quantite';
    public const VEHICULE_ID_COLUMN = 'vehicule_id';
    public const DOCUMENT_COLUMN = 'document';
    public const SUPPLIERNAME_COLUMN = 'suppliername';
    public const CREATED_AT_COLUMN = 'created_at';
    public const UPDATED_AT_COLUMN = 'updated_at';

    protected $table = self::TABLE;

    public function getId(): int
    {
        return $this->getAttribute(self::ID_COLUMN);
    }

    public function getStockId(): int
    {
        return $this->getAttribute(self::STOCK_ID_COLUMN);
    }

    public function getType(): string
    {
        return $this->getAttribute(self::TYPE_COLUMN);
    }

    public function getQuantite(): int
    {
        return $this->getAttribute(self::QUANTITE_COLUMN);
    }

    public function getVehiculeId(): ?int
    {
        return $this->getAttribute(self::VEHICULE_ID_COLUMN);
    }

    public function getDocument(): ?string
    {
        return $this->getAttribute(self::DOCUMENT_COLUMN);
    }

    public function getSuppliername(): ?string
    {
        return $this->getAttribute(self::SUPPLIERNAME_COLUMN);
    }

    public function stock()
    {
        return $this->belongsTo(Stock::class, 'stock_id');
    }
}
