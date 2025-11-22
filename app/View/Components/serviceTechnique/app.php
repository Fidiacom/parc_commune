<?php

namespace App\View\Components\serviceTechnique;

use App\Services\SettingService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class app extends Component
{
    public string $logoUrl;
    public string $communeName;
    public string $mainColor;
    public ?string $secondColor;

    /**
     * Create a new component instance.
     */
    public function __construct(SettingService $settingService)
    {
        $this->logoUrl = $settingService->getLogoUrl();
        $this->communeName = $settingService->getCommuneName();
        $this->mainColor = $settingService->getMainColor();
        $this->secondColor = $settingService->getSecondColor();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('layouts.service-technique.app');
    }
}
