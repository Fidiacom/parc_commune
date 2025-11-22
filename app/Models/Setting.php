<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    public const TABLE = 'setting';
    public const ID_COLUMN = 'id';
    public const LOGO_COLUMN = 'logo';
    public const COMMUNE_NAME_COLUMN = 'commune_name';
    public const COMMUNE_NAME_FR_COLUMN = 'commune_name_fr';
    public const COMMUNE_NAME_AR_COLUMN = 'commune_name_ar';
    public const MAIN_COLOR_COLUMN = 'main_color';
    public const SECOND_COLOR_COLUMN = 'second_color';
    public const CREATED_AT_COLUMN = 'created_at';
    public const UPDATED_AT_COLUMN = 'updated_at';

    protected $table = self::TABLE;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'logo',
        'commune_name',
        'commune_name_fr',
        'commune_name_ar',
        'main_color',
        'second_color',
    ];

    /**
     * Get the ID.
     */
    public function getId(): int
    {
        return $this->getAttribute(self::ID_COLUMN);
    }

    /**
     * Get the logo.
     */
    public function getLogo(): ?string
    {
        return $this->getAttribute(self::LOGO_COLUMN);
    }

    /**
     * Get the commune name.
     */
    public function getCommuneName(): ?string
    {
        return $this->getAttribute(self::COMMUNE_NAME_COLUMN);
    }

    /**
     * Get the commune name in French.
     */
    public function getCommuneNameFr(): ?string
    {
        return $this->getAttribute(self::COMMUNE_NAME_FR_COLUMN);
    }

    /**
     * Get the commune name in Arabic.
     */
    public function getCommuneNameAr(): ?string
    {
        return $this->getAttribute(self::COMMUNE_NAME_AR_COLUMN);
    }

    /**
     * Get the commune name based on current locale.
     */
    public function getCommuneNameByLocale(?string $locale = null): ?string
    {
        $locale = $locale ?? app()->getLocale();
        
        return match($locale) {
            'ar' => $this->getCommuneNameAr() ?: $this->getCommuneNameFr() ?: $this->getCommuneName(),
            'fr' => $this->getCommuneNameFr() ?: $this->getCommuneNameAr() ?: $this->getCommuneName(),
            default => $this->getCommuneNameFr() ?: $this->getCommuneNameAr() ?: $this->getCommuneName(),
        };
    }

    /**
     * Get the main color.
     */
    public function getMainColor(): ?string
    {
        return $this->getAttribute(self::MAIN_COLOR_COLUMN);
    }

    /**
     * Get the second color.
     */
    public function getSecondColor(): ?string
    {
        return $this->getAttribute(self::SECOND_COLOR_COLUMN);
    }
}

