<?php

namespace App\Support;

use App\Models\Setting;

/**
 * Values printed in the official header of every PDF.
 * They come from config/settings.php (.env), except the commune name,
 * which uses the "Paramètres" page value first and falls back to .env.
 */
class PdfHeader
{
    private const LINE_KEYS = ['royaume', 'ministere', 'wilaya', 'region', 'province', 'pachalik', 'commune'];

    /**
     * Header lines for one language ("fr" or "ar"). Empty lines are skipped.
     */
    public static function lines(string $locale): array
    {
        $locale = self::normalize($locale);
        $lines = [];

        foreach (self::LINE_KEYS as $key) {
            $value = $key === 'commune'
                ? self::communeName($locale)
                : (string) config("settings.{$key}_{$locale}");

            if (trim($value) !== '') {
                $lines[] = $locale === 'fr' ? mb_strtoupper($value) : $value;
            }
        }

        return $lines;
    }

    /**
     * Header lines as FR/AR pairs, for bilingual documents.
     * A pair is kept when at least one side has a value.
     */
    public static function bilingualLines(): array
    {
        $pairs = [];

        foreach (self::LINE_KEYS as $key) {
            $fr = $key === 'commune' ? self::communeName('fr') : (string) config("settings.{$key}_fr");
            $ar = $key === 'commune' ? self::communeName('ar') : (string) config("settings.{$key}_ar");

            if (trim($fr) !== '' || trim($ar) !== '') {
                $pairs[] = ['fr' => mb_strtoupper($fr), 'ar' => $ar];
            }
        }

        return $pairs;
    }

    /**
     * Commune name: "Paramètres" page value first, then .env.
     */
    public static function communeName(string $locale): string
    {
        $locale = self::normalize($locale);
        $setting = Setting::query()->first();

        $fromDb = $setting
            ? ($locale === 'ar' ? $setting->getCommuneNameAr() : $setting->getCommuneNameFr())
            : null;

        if ($fromDb !== null && trim($fromDb) !== '') {
            return $fromDb;
        }

        return (string) config("settings.commune_{$locale}");
    }

    public static function city(string $locale): string
    {
        return (string) config('settings.city_' . self::normalize($locale));
    }

    public static function cityShort(): string
    {
        return (string) config('settings.city_short_fr');
    }

    /**
     * Absolute file path of the logo (mPDF reads it from disk), or null.
     */
    public static function logoPath(): ?string
    {
        $logo = trim((string) config('settings.logo'));

        if ($logo === '') {
            return null;
        }

        $path = public_path(ltrim($logo, '/'));

        return is_file($path) ? $path : null;
    }

    public static function normalize(?string $locale): string
    {
        return $locale === 'ar' ? 'ar' : 'fr';
    }
}
