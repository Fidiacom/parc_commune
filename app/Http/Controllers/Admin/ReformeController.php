<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ReformeService;
use App\Services\VehiculeService;
use App\Models\Reforme;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Log;

class ReformeController extends Controller
{
    protected ReformeService $reformeService;
    protected VehiculeService $vehiculeService;

    public function __construct(ReformeService $reformeService, VehiculeService $vehiculeService)
    {
        $this->reformeService = $reformeService;
        $this->vehiculeService = $vehiculeService;
    }

    public function index()
    {
        $reformes = $this->reformeService->getAllReformes();
        return view('admin.reforme.index', ['reformes' => $reformes]);
    }

    public function create()
    {
        $vehicules = $this->vehiculeService->getAllVehicules();
        return view('admin.reforme.create', ['vehicules' => $vehicules]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'vehicule_id' => 'required|exists:vehicules,id',
            'description' => 'required|string',
            'files.*' => 'nullable|file|max:51200', // 50MB max
        ], [
            'vehicule_id.required' => __('The vehicle field is required.'),
            'vehicule_id.exists' => __('The selected vehicle does not exist.'),
            'description.required' => __('The description field is required.'),
            'files.*.file' => __('Uploaded files must be valid files.'),
            'files.*.max' => __('Each file must not exceed 50MB.'),
        ]);

        try {
            $this->reformeService->createReforme($request);
            Alert::success(__('Succès'), __('Réforme créée avec succès'));
            return redirect(route('admin.reforme'));
        } catch (\Throwable $th) {
            Alert::error(__('Erreur'), __('Échec de la création de la réforme: ') . $th->getMessage());
            Log::error('Reforme creation error: ' . $th->getMessage(), ['exception' => $th]);
            return back()->withInput();
        }
    }

    public function show($id)
    {
        try {
            $reforme = $this->reformeService->getReformeById($id, ['vehicule', 'attachments', 'statusHistoriques.attachments']);
        } catch (\Throwable $th) {
            Alert::error(__('Erreur'), __('Réforme introuvable'));
            return redirect(route('admin.reforme'));
        }

        if (!$reforme) {
            Alert::error(__('Erreur'), __('Réforme introuvable'));
            return redirect(route('admin.reforme'));
        }

        return view('admin.reforme.show', ['reforme' => $reforme]);
    }

    public function edit($id)
    {
        try {
            $reforme = $this->reformeService->getReformeById($id, ['vehicule', 'attachments', 'statusHistoriques.attachments']);
        } catch (\Throwable $th) {
            Alert::error(__('Erreur'), __('Réforme introuvable'));
            return redirect(route('admin.reforme'));
        }

        if (!$reforme) {
            Alert::error(__('Erreur'), __('Réforme introuvable'));
            return redirect(route('admin.reforme'));
        }

        $vehicules = $this->vehiculeService->getAllVehicules();
        return view('admin.reforme.edit', [
            'reforme' => $reforme,
            'vehicules' => $vehicules,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'description' => 'required|string',
            'files.*' => 'nullable|file|max:51200', // 50MB max
        ], [
            'description.required' => __('The description field is required.'),
            'files.*.file' => __('Uploaded files must be valid files.'),
            'files.*.max' => __('Each file must not exceed 50MB.'),
        ]);

        try {
            $reforme = $this->reformeService->getReformeById($id);
        } catch (\Throwable $th) {
            Alert::error(__('Erreur'), __('Réforme introuvable'));
            return back();
        }

        if (!$reforme) {
            Alert::error(__('Erreur'), __('Réforme introuvable'));
            return back();
        }

        try {
            $this->reformeService->updateReforme($reforme, $request);
            Alert::success(__('Succès'), __('Réforme mise à jour avec succès'));
            return redirect()->route('admin.reforme.show', $reforme->getId());
        } catch (\Throwable $th) {
            Log::error('Reforme update error: ' . $th->getMessage());
            Alert::error(__('Erreur'), __('Échec de la mise à jour de la réforme: ') . $th->getMessage());
            return back();
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:in_progress,confirmed,rejected,selled',
            'description' => 'nullable|string',
            'files.*' => 'nullable|file|max:51200', // 50MB max
        ], [
            'status.required' => __('The status field is required.'),
            'status.in' => __('The selected status is invalid.'),
            'files.*.file' => __('Uploaded files must be valid files.'),
            'files.*.max' => __('Each file must not exceed 50MB.'),
        ]);

        try {
            $reforme = $this->reformeService->getReformeById($id);
        } catch (\Throwable $th) {
            Alert::error(__('Erreur'), __('Réforme introuvable'));
            return back();
        }

        if (!$reforme) {
            Alert::error(__('Erreur'), __('Réforme introuvable'));
            return back();
        }

        try {
            $this->reformeService->updateStatus($reforme, $request);
            Alert::success(__('Succès'), __('Statut mis à jour avec succès'));
            return redirect()->route('admin.reforme.show', $reforme->getId());
        } catch (\Throwable $th) {
            Log::error('Reforme status update error: ' . $th->getMessage());
            Alert::error(__('Erreur'), __('Échec de la mise à jour du statut: ') . $th->getMessage());
            return back();
        }
    }

    public function addAttachments(Request $request)
    {
        $validated = $request->validate([
            'reforme_id' => 'required',
            'files.*' => 'required|file|max:51200', // 50MB max
        ]);

        try {
            $reforme = $this->reformeService->getReformeById($request->reforme_id);
        } catch (\Throwable $th) {
            Alert::error(__('Erreur'), __('ID de réforme invalide'));
            return back();
        }

        if (!$reforme) {
            Alert::error(__('Erreur'), __('Réforme introuvable'));
            return back();
        }

        try {
            $this->reformeService->addAttachments($reforme, $request->file('files'));
            Alert::success(__('Succès'), __('Fichiers téléchargés avec succès'));
        } catch (\Throwable $th) {
            Alert::error(__('Erreur'), __('Échec du téléchargement des fichiers'));
        }

        return back();
    }

    public function deleteAttachment($id)
    {
        try {
            $this->reformeService->deleteAttachment($id);
            Alert::success(__('Succès'), __('Fichier supprimé avec succès'));
        } catch (\Throwable $th) {
            Alert::error(__('Erreur'), __('Échec de la suppression du fichier'));
        }

        return back();
    }

    public function deleteStatusAttachment($id)
    {
        try {
            $this->reformeService->deleteStatusAttachment($id);
            Alert::success(__('Succès'), __('Fichier supprimé avec succès'));
        } catch (\Throwable $th) {
            Alert::error(__('Erreur'), __('Échec de la suppression du fichier'));
        }

        return back();
    }

    public function destroy($id)
    {
        try {
            $reforme = $this->reformeService->getReformeById($id);
        } catch (\Throwable $th) {
            Alert::error(__('Erreur'), __('ID de réforme invalide'));
            return back();
        }

        if (!$reforme) {
            Alert::error(__('Erreur'), __('Réforme introuvable'));
            return back();
        }

        try {
            $this->reformeService->deleteReforme($reforme);
            Alert::success(__('Succès'), __('Réforme supprimée avec succès'));
        } catch (\Throwable $th) {
            Alert::error(__('Erreur'), __('Échec de la suppression de la réforme'));
        }

        return redirect(route('admin.reforme'));
    }
}

