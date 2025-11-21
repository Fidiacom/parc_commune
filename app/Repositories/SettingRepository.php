<?php

namespace App\Repositories;

use App\Models\Setting;

class SettingRepository
{
    /**
     * Get the first setting record or create a new one.
     */
    public function getFirstOrCreate(): Setting
    {
        return Setting::firstOrCreate([], [
            'logo' => null,
            'commune_name' => '',
            'commune_name_fr' => null,
            'commune_name_ar' => null,
        ]);
    }

    /**
     * Get the first setting record.
     */
    public function getFirst(): ?Setting
    {
        return Setting::first();
    }

    /**
     * Update setting.
     */
    public function update(Setting $setting, array $data): bool
    {
        return $setting->update($data);
    }
}

