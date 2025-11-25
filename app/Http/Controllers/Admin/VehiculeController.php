<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\VehiculeService;
use App\Models\CategoriePermi;
use App\Models\pneu;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class VehiculeController extends Controller
{
    protected VehiculeService $vehiculeService;

    public function __construct(VehiculeService $vehiculeService)
    {
        $this->vehiculeService = $vehiculeService;
    }

    public function index()
    {
        $vehicules = $this->vehiculeService->getAllVehicules();
        return view('admin.vehicule.index', ['vehicules' => $vehicules]);
    }

    public function create()
    {
        $categories = CategoriePermi::all();
        return view('admin.vehicule.create', ['categories' => $categories]);
    }

    public function store(Request $request)
    {
        // Check for PHP upload errors before validation
        $uploadErrors = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $key => $file) {
                if ($file->getError() !== UPLOAD_ERR_OK) {
                    $uploadErrors["images.{$key}"] = $this->getUploadErrorMessage($file->getError());
                }
            }
        }
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $key => $file) {
                if ($file->getError() !== UPLOAD_ERR_OK) {
                    $uploadErrors["files.{$key}"] = $this->getUploadErrorMessage($file->getError());
                }
            }
        }
        
        if (!empty($uploadErrors)) {
            return back()->withErrors($uploadErrors)->withInput();
        }
        
        try {
        $validated = $request->validate([
                'brand' => 'required',
                'model' => 'required',
                'matricule' => 'required',
                'chassis' => 'nullable',
                'km_actuel' => 'required',
                'horses' => 'required',
                'fuel_type' => 'required|not_in:0',
                'category' => 'required|not_in:0',
                'threshold_vidange' => 'required',
                'threshold_timing_chaine' => 'required',
                'inssurance_expiration' => 'required',
                'technical_visit_expiration' => 'nullable|date',
                'numOfTires' => 'required|integer|min:1',
                'circulation_date' => 'nullable|date',
                'images.*' => 'nullable|image|max:51200', // 50MB max (51200 KB)
                'files.*' => 'nullable|file|max:51200', // 50MB max (51200 KB)
                'tire_positions.*' => 'required|string',
                'tire_thresholds.*' => 'required',
                'tire_nextKMs.*' => 'required',
            ], [
                'brand.required' => __('The brand field is required.'),
                'model.required' => __('The model field is required.'),
                'matricule.required' => __('The matricule field is required.'),
                'km_actuel.required' => __('The current kilometers field is required.'),
                'horses.required' => __('The horses field is required.'),
                'fuel_type.required' => __('The fuel type field is required.'),
                'fuel_type.not_in' => __('Please select a valid fuel type.'),
                'category.required' => __('The category field is required.'),
                'category.not_in' => __('Please select a valid category.'),
                'threshold_vidange.required' => __('The oil change threshold field is required.'),
                'threshold_timing_chaine.required' => __('The timing chain threshold field is required.'),
                'inssurance_expiration.required' => __('The insurance expiration date is required.'),
                'numOfTires.required' => __('The number of tires field is required.'),
                'numOfTires.integer' => __('The number of tires must be a number.'),
                'numOfTires.min' => __('The number of tires must be at least 1.'),
                'tire_positions.*.required' => __('All tire positions are required.'),
                'tire_thresholds.*.required' => __('All tire thresholds are required.'),
                'tire_nextKMs.*.required' => __('All tire next KM values are required.'),
                'images.*.image' => __('Uploaded files must be images.'),
                'images.*.max' => __('Each image must not exceed 50MB.'),
                'images.*.uploaded' => __('The image could not be uploaded. This may be due to file size limits, upload errors, or server configuration. Please check your file and try again.'),
                'files.*.max' => __('Each file must not exceed 50MB.'),
                'files.*.uploaded' => __('The file could not be uploaded. This may be due to file size limits, upload errors, or server configuration. Please check your file and try again.'),
            ]);

            // Validate that number of tire entries matches numOfTires
            $numOfTires = intval($request->numOfTires);
            if ($request->has('tire_positions')) {
                $tireCount = count($request->tire_positions);
                if ($tireCount !== $numOfTires) {
                    return back()->withErrors(['tire_positions' => __('The number of tire entries must match the number of tires specified.')])->withInput();
                }
            }

            $this->vehiculeService->createVehicule($request);
            Alert::success(__('Véhicule enregistré avec succès'), __('Le véhicule et les pneus ont été enregistrés'));
            return redirect(route('admin.vehicule'));
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Check for PHP upload errors and provide better error messages
            $errors = $e->errors();
            
            // Check for PHP upload errors before validation
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $key => $file) {
                    if ($file->getError() !== UPLOAD_ERR_OK) {
                        $errorMessage = $this->getUploadErrorMessage($file->getError());
                        if (!isset($errors["images.{$key}"])) {
                            $errors["images.{$key}"] = [];
                        }
                        $errors["images.{$key}"][] = $errorMessage;
                    }
                }
            }
            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $key => $file) {
                    if ($file->getError() !== UPLOAD_ERR_OK) {
                        $errorMessage = $this->getUploadErrorMessage($file->getError());
                        if (!isset($errors["files.{$key}"])) {
                            $errors["files.{$key}"] = [];
                        }
                        $errors["files.{$key}"][] = $errorMessage;
                    }
                }
            }
            
            return back()->withErrors($errors)->withInput();
        } catch (\Throwable $th) {
            Alert::error(__('Erreur'), __('Échec de la création du véhicule: ') . $th->getMessage());
            Log::error('Vehicule creation error: ' . $th->getMessage(), ['exception' => $th]);
            return back()->withInput();
        }
    }

    /**
     * Get human-readable error message for PHP upload errors.
     */
    private function getUploadErrorMessage(int $errorCode): string
    {
        switch ($errorCode) {
            case UPLOAD_ERR_INI_SIZE:
                return __('The uploaded file exceeds the upload_max_filesize directive in php.ini. Please check your PHP configuration.');
            case UPLOAD_ERR_FORM_SIZE:
                return __('The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.');
            case UPLOAD_ERR_PARTIAL:
                return __('The uploaded file was only partially uploaded. Please try again.');
            case UPLOAD_ERR_NO_FILE:
                return __('No file was uploaded.');
            case UPLOAD_ERR_NO_TMP_DIR:
                return __('Missing a temporary folder. Please contact the administrator.');
            case UPLOAD_ERR_CANT_WRITE:
                return __('Failed to write file to disk. Please check server permissions.');
            case UPLOAD_ERR_EXTENSION:
                return __('A PHP extension stopped the file upload. Please contact the administrator.');
            default:
                return __('Unknown upload error occurred. Error code: ') . $errorCode;
        }
    }

    public function edit($id)
    {
        try {
            $vehicule = $this->vehiculeService->getVehiculeById($id, ['vidange', 'timing_chaine', 'images', 'attachments', 'pneu']);
        } catch (\Throwable $th) {
            return view('admin.vehicule.404');
        }

        if (!$vehicule) {
            return view('admin.vehicule.404');
        }

        return view('admin.vehicule.edit', ['vehicule' => $vehicule]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'matricule' => 'required|string|max:255',
            'chassis' => 'nullable|string|max:255',
            'km_actuel' => 'required',
            'horses' => 'required',
            'fuel_type' => 'required|not_in:0',
            'inssurance_expiration' => 'required|date',
            'technical_visit_expiration' => 'nullable|date',
            'numOfTires' => 'required|integer|min:1',
            'circulation_date' => 'nullable|date',
            'total_hours' => 'nullable',
            'min_fuel_consumption_100km' => 'nullable|numeric|min:0',
            'max_fuel_consumption_100km' => 'nullable|numeric|min:0',
            'tire_size' => 'nullable|string|max:255',
            'images.*' => 'nullable|image|max:51200', // 50MB max
            'files.*' => 'nullable|file|max:51200', // 50MB max
            'tire_ids.*' => 'nullable|integer',
            'tire_positions.*' => 'nullable|string|max:255',
            'tire_thresholds.*' => 'nullable',
        ]);

        try {
            // Get vehicule by ID (not encrypted)
            $vehicule = $this->vehiculeService->getVehiculeById($id);
        } catch (\Throwable $th) {
            Alert::error(__('Erreur'), __('Véhicule introuvable'));
            return back();
        }

        if (!$vehicule) {
            Alert::error(__('Erreur'), __('Véhicule introuvable'));
            return back();
        }

        try {
            // Handle new files/attachments
            if ($request->hasFile('files')) {
                $this->vehiculeService->addAttachments($vehicule, $request->file('files'));
            }

            // Handle new images
            if ($request->hasFile('images')) {
                $this->vehiculeService->addImages($vehicule, $request->file('images'));
            }

            // Update vehicule and handle tire updates
            $this->vehiculeService->updateVehicule($vehicule, $request);
            
            Alert::success(__('Véhicule enregistré avec succès'), __('mis à jour'));
            return redirect()->route('admin.vehicule.edit', $vehicule->getId());
        } catch (\Throwable $th) {
            Log::error('Vehicule update error: ' . $th->getMessage());
            Alert::error(__('Erreur'), __('Échec de la mise à jour du véhicule: ') . $th->getMessage());
            return back();
        }
    }

    public function dtt_get($vehicule_id)
    {
        try {
            $id = Crypt::decrypt($vehicule_id);
            $vehicule = $this->vehiculeService->getVehiculeById($id, ['vidange.vidange_historique', 'timing_chaine.timingchaine_historique', 'pneu.pneu_historique']);
        } catch (\Throwable $th) {
            throw $th;
        }

        if (!$vehicule) {
            return view('admin.vehicule.404');
        }

        $historiquePneu = pneu::where('pneus.car_id', '=', $vehicule->getId())
                ->rightJoin('pneu_historiques', 'pneus.id', '=', 'pneu_historiques.pneu_id')
                ->latest()
                ->get(['pneus.tire_position', 'pneu_historiques.current_km', 'pneu_historiques.next_km_for_change', 'pneu_historiques.created_at']);

        return view('admin.vehicule.dtt', ['vehicule' => $vehicule, 'historiquePneu' => $historiquePneu]);
    }

    public function addImages(Request $request)
    {
        $validated = $request->validate([
            'vehicule_id' => 'required',
            'images.*' => 'required|image|max:51200', // 50MB max
        ]);

        try {
            $id = Crypt::decrypt($request->vehicule_id);
            $vehicule = $this->vehiculeService->getVehiculeById($id);
        } catch (\Throwable $th) {
            Alert::error(__('Erreur'), __('ID de véhicule invalide'));
            return back();
        }

        if (!$vehicule) {
            Alert::error(__('Erreur'), __('Véhicule introuvable'));
            return back();
        }

        try {
            $this->vehiculeService->addImages($vehicule, $request->file('images'));
            Alert::success(__('Succès'), __('Images téléchargées avec succès'));
        } catch (\Throwable $th) {
            Alert::error(__('Erreur'), __('Échec du téléchargement des images'));
        }

        return back();
    }

    public function deleteImage($id)
    {
        try {
            $imageId = Crypt::decrypt($id);
            $this->vehiculeService->deleteImage($imageId);
            Alert::success(__('Succès'), __('Image supprimée avec succès'));
        } catch (\Throwable $th) {
            Alert::error(__('Erreur'), __("Échec de la suppression de l'image"));
        }

        return back();
    }

    public function setMainImage(Request $request)
    {
        $validated = $request->validate([
            'vehicule_id' => 'required',
            'image_id' => 'required',
        ]);

        try {
            $vehiculeId = Crypt::decrypt($request->vehicule_id);
            $imageId = Crypt::decrypt($request->image_id);
            $this->vehiculeService->setMainImage($vehiculeId, $imageId);
            Alert::success(__('Succès'), __('Image principale mise à jour avec succès'));
        } catch (\Throwable $th) {
            Alert::error(__('Erreur'), __("Échec de la définition de l'image principale"));
        }

        return back();
    }

    public function addAttachments(Request $request)
    {
        $validated = $request->validate([
            'vehicule_id' => 'required',
            'files.*' => 'required|file|max:51200', // 50MB max
        ]);

        try {
            $id = Crypt::decrypt($request->vehicule_id);
            $vehicule = $this->vehiculeService->getVehiculeById($id);
        } catch (\Throwable $th) {
            Alert::error(__('Erreur'), __('ID de véhicule invalide'));
            return back();
        }

        if (!$vehicule) {
            Alert::error(__('Erreur'), __('Véhicule introuvable'));
            return back();
        }

        try {
            $this->vehiculeService->addAttachments($vehicule, $request->file('files'));
        Alert::success(__('Succès'), __('Fichiers téléchargés avec succès'));
        } catch (\Throwable $th) {
            Alert::error(__('Erreur'), __('Échec du téléchargement des fichiers'));
        }

        return back();
    }

    public function deleteAttachment($id)
    {
        try {
            $attachmentId = Crypt::decrypt($id);
            $this->vehiculeService->deleteAttachment($attachmentId);
            Alert::success(__('Succès'), __('Fichier supprimé avec succès'));
        } catch (\Throwable $th) {
            Alert::error(__('Erreur'), __('Échec de la suppression du fichier'));
        }
        
        return back();
    }

    public function destroy($id)
    {
        try {
            $id = Crypt::decrypt($id);
            $vehicule = $this->vehiculeService->getVehiculeById($id);
        } catch (\Throwable $th) {
            Alert::error(__('Erreur'), __('ID de véhicule invalide'));
            return back();
        }

        if (!$vehicule) {
            Alert::error(__('Erreur'), __('Véhicule introuvable'));
            return back();
        }

        try {
            $this->vehiculeService->deleteVehicule($vehicule);
            Alert::success(__('Succès'), __('Véhicule supprimé avec succès'));
        } catch (\Throwable $th) {
            Alert::error(__('Erreur'), __('Échec de la suppression du véhicule'));
        }

        return redirect(route('admin.vehicule'));
    }
}
