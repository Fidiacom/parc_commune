<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenence extends Model
{
    use HasFactory;

    public const TABLE = 'maintenences';
    public const ID_COLUMN = 'id';
    public const STOCK_ID_COLUMN = 'stock_id';
    public const VEHICULE_ID_COLUMN = 'vehicule_id';
    public const QTE_SORTIE_COLUMN = 'qte_sortie';
    public const DESCRIPTION_COLUMN = 'description';
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

    public function getVehiculeId(): int
    {
        return $this->getAttribute(self::VEHICULE_ID_COLUMN);
    }

    public function getQteSortie(): string
    {
        return $this->getAttribute(self::QTE_SORTIE_COLUMN);
    }

    public function getDescription(): ?string
    {
        return $this->getAttribute(self::DESCRIPTION_COLUMN);
    }
}
