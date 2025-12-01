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
        $setting = $this->repository->getFirst();
        
        if($setting->getLogo()) {
            return asset($setting->getLogo());
        }
        
        return null;
    }

    /**
     * Get the commune name based on current locale.
     */
    public function getCommuneName(?string $locale = null): string
    {
        $setting = $this->repository->getFirst();
        
        return $setting ? $setting->getCommuneNameByLocale($locale) : '';
    }

    /**
     * Get the commune name in French.
     */
    public function getCommuneNameFr(): string
    {
        $setting = $this->repository->getFirst();
        
        return $setting ? ($setting->getCommuneNameFr() ?? '') : '';
    }

    /**
     * Get the commune name in Arabic.
     */
    public function getCommuneNameAr(): string
    {
        $setting = $this->repository->getFirst();
        
        return $setting ? ($setting->getCommuneNameAr() ?? '') : '';
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

