<?php

namespace App\Managers;

use App\Models\Setting;
use App\Repositories\SettingRepository;

class SettingManager
{
    protected SettingRepository $repository;

    public function __construct(SettingRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get the current settings.
     */
    public function getSettings(): Setting
    {
        return $this->repository->getFirstOrCreate();
    }

    /**
     * Update settings.
     */
    public function updateSettings(array $data): Setting
    {
        $setting = $this->repository->getFirstOrCreate();
        $this->repository->update($setting, $data);
        
        return $setting->fresh();
    }

    /**
     * Get the logo URL or return placeholder.
     */
    public function getLogoUrl(): ?string
    {
        $setting = $this->repository->getFirstOrCreate();

        if ($setting->getLogo()) {
            return asset($setting->getLogo());
        }
        
        return null;
    }

    /**
     * Get the commune name based on current locale.
     * Falls back to the PDF_COMMUNE_* values from .env when not set.
     */
    public function getCommuneName(?string $locale = null): string
    {
        $locale = $locale ?? app()->getLocale();

        return $locale === 'ar' ? $this->getCommuneNameAr() : $this->getCommuneNameFr();
    }

    /**
     * Get the commune name in French.
     */
    public function getCommuneNameFr(): string
    {
        return \App\Support\PdfHeader::communeName('fr');
    }

    /**
     * Get the commune name in Arabic.
     */
    public function getCommuneNameAr(): string
    {
        return \App\Support\PdfHeader::communeName('ar');
    }

    /**
     * Get the main color or return default.
     */
    public function getMainColor(?string $default = '#397D3C'): string
    {
        $setting = $this->repository->getFirst();
        
        return $setting && $setting->getMainColor() ? $setting->getMainColor() : $default;
    }

    /**
     * Get the second color or return default.
     */
    public function getSecondColor(?string $default = null): ?string
    {
        $setting = $this->repository->getFirst();
        
        return $setting && $setting->getSecondColor() ? $setting->getSecondColor() : $default;
    }
}

