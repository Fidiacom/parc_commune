<?php

namespace App\Http\Controllers\ServiceTechnique;

use App\Http\Controllers\Controller;
use App\Services\SettingService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SettingController extends Controller
{
    protected SettingService $settingService;

    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
    }

    /**
     * Display the settings form.
     */
    public function index(): View
    {
        $setting = $this->settingService->getSettings();
        
        return view('service-technique.setting.index', [
            'setting' => $setting,
        ]);
    }

    /**
     * Update the settings.
     */
    public function update(Request $request): RedirectResponse
    {
        dd($request->all());
        $validated = $request->validate([
            'commune_name_fr' => 'required|string|max:255',
            'commune_name_ar' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $this->settingService->updateSettings(
            $validated,
            $request->file('logo')
        );

        return redirect()->route('serviceTechnique.setting')
            ->with('success', __('Settings updated successfully.'));
    }
}
