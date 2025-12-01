<?php

namespace App\Services;

use App\Managers\SettingManager;
use App\Models\Setting;
use Illuminate\Http\UploadedFile;

class SettingService
{
    protected SettingManager $manager;

    public function __construct(SettingManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Get the current settings.
     */
    public function getSettings(): Setting
    {
        return $this->manager->getSettings();
    }

    /**
     * Update settings.
     */
    public function updateSettings(array $data, ?UploadedFile $logoFile = null): Setting
    {
        $updateData = [];

        if (isset($data['commune_name_fr'])) {
            $updateData['commune_name_fr'] = $data['commune_name_fr'];
        }

        if (isset($data['commune_name_ar'])) {
            $updateData['commune_name_ar'] = $data['commune_name_ar'];
        }

        // Keep backward compatibility with commune_name
        if (isset($data['commune_name'])) {
            $updateData['commune_name'] = $data['commune_name'];
        }

        if (isset($data['main_color'])) {
            $updateData['main_color'] = $data['main_color'];
        }

        if (isset($data['second_color'])) {
            $updateData['second_color'] = $data['second_color'];
        }

        if ($logoFile) {
            $updateData['logo'] = uploadFile($logoFile, 'settings');
        }

        return $this->manager->updateSettings($updateData);
    }

    /**
     * Get the logo URL or return placeholder.
     */
    public function getLogoUrl(): ?string
    {
        return $this->manager->getLogoUrl();
    }

    /**
     * Get the commune name based on current locale.
     */
    public function getCommuneName(?string $locale = null): string
    {
        return $this->manager->getCommuneName($locale);
    }

    /**
     * Get the commune name in French.
     */
    public function getCommuneNameFr(): string
    {
        return $this->manager->getCommuneNameFr();
    }

    /**
     * Get the commune name in Arabic.
     */
    public function getCommuneNameAr(): string
    {
        return $this->manager->getCommuneNameAr();
    }

    /**
     * Get the main color or return default.
     */
    public function getMainColor(?string $default = '#397D3C'): string
    {
        return $this->manager->getMainColor($default);
    }

    /**
     * Get the second color or return default.
     */
    public function getSecondColor(?string $default = null): ?string
    {
        return $this->manager->getSecondColor($default);
    }
}
