<?php

namespace App\View\Components\Admin;

use App\Services\SettingService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class App extends Component
{
    public string $logoUrl;
    public string $mainColor;
    public ?string $secondColor;
    public string $mainColorRgb;
    public ?string $secondColorRgb;

    /**
     * Create a new component instance.
     */
    public function __construct(SettingService $settingService)
    {
        $this->logoUrl = $settingService->getLogoUrl();
        $this->mainColor = $settingService->getMainColor();
        $this->secondColor = $settingService->getSecondColor();
        $this->mainColorRgb = $this->hexToRgb($this->mainColor);
        $this->secondColorRgb = $this->secondColor ? $this->hexToRgb($this->secondColor) : null;
    }

    /**
     * Convert hex color to RGB string.
     */
    private function hexToRgb(string $hex): string
    {
        $hex = ltrim($hex, '#');
        if (strlen($hex) === 3) {
            $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
        }
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
        return "$r, $g, $b";
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('layouts.admin.app');
    }
}
