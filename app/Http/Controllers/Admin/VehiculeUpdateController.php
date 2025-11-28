<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\VehiculeService;
use App\Models\Vehicule;
use RealRashid\SweetAlert\Facades\Alert;

class VehiculeUpdateController extends Controller
{
    protected VehiculeService $vehiculeService;

    public function __construct(VehiculeService $vehiculeService)
    {
        $this->vehiculeService = $vehiculeService;
    }

    /**
     * Display the vehicle update page.
     */
    public function index()
    {
        $vehicules = $this->vehiculeService->getAllVehicules();
        
        return view('admin.vehicule.update_km_hours', [
            'vehicules' => $vehicules,
        ]);
    }

    /**
     * Update vehicle KM and Hours.
     */
    public function update(Request $request, $id)
    {
        try {
            $vehicule = $this->vehiculeService->getVehiculeById($id);

            if (!$vehicule) {
                Alert::error(__('Erreur'), __('Véhicule introuvable'));
                return redirect()->route('admin.vehicule.update.index');
            }
        } catch (\Throwable $th) {
            Alert::error(__('Erreur'), __('ID de véhicule invalide'));
            return redirect()->route('admin.vehicule.update.index');
        }

        $validated = $request->validate([
            'total_km' => 'required|integer|min:0',
            'total_hours' => 'nullable|integer|min:0',
        ], [
            'total_km.required' => __('Le kilométrage est requis'),
            'total_km.integer' => __('Le kilométrage doit être un nombre entier'),
            'total_km.min' => __('Le kilométrage doit être supérieur ou égal à 0'),
            'total_hours.integer' => __('Les heures doivent être un nombre entier'),
            'total_hours.min' => __('Les heures doivent être supérieures ou égales à 0'),
        ]);

        try {
            $updateData = [
                Vehicule::TOTAL_KM_COLUMN => intval(str_replace(['.', ','], '', $request->total_km)),
            ];

            if ($request->has('total_hours') && $request->total_hours) {
                $updateData[Vehicule::TOTAL_HOURS_COLUMN] = intval(str_replace(['.', ','], '', $request->total_hours));
            } else {
                $updateData[Vehicule::TOTAL_HOURS_COLUMN] = $vehicule->getTotalHours();
            }

            // Use repository directly for simple update
            $repository = new \App\Repositories\VehiculeRepository();
            $repository->update($vehicule, $updateData);
            
            Alert::success(__('Succès'), __('Kilométrage et heures mis à jour avec succès'));
        } catch (\Exception $e) {
            Alert::error(__('Erreur'), __('Échec de la mise à jour: ') . $e->getMessage());
        }

        return redirect()->route('admin.vehicule.update.index');
    }
}
