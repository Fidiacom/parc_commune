<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\PaymentVoucherService;
use App\Services\VehiculeService;
use App\Models\Vehicule;
use App\Models\pneu;
use App\Models\Vidange;
use App\Models\TimingChaine;
use App\Models\PaymentVoucher;
use RealRashid\SweetAlert\Facades\Alert;

class PaymentVoucherController extends Controller
{
    protected PaymentVoucherService $paymentVoucherService;
    protected VehiculeService $vehiculeService;

    public function __construct(
        PaymentVoucherService $paymentVoucherService,
        VehiculeService $vehiculeService
    ) {
        $this->paymentVoucherService = $paymentVoucherService;
        $this->vehiculeService = $vehiculeService;
    }

    /**
     * Display a listing of payment vouchers by category.
     */
    public function index(Request $request, $category = null)
    {
        $dateFrom = $request->query('date_from');
        $dateTo = $request->query('date_to');
        $sortDirection = $request->query('sort', 'desc');

        $categories = [
            'carburant' => __('Bon pour Carburant'),
            'entretien' => __('Entretien'),
            'vidange' => __('Vidange'),
            'lavage' => __('Lavage'),
            'lubrifiant' => __('Lubrifiant'),
            'reparation' => __('Reparation'),
            'achat_pieces_recharges' => __('Achat pieces de recharges'),
            'rechange_pneu' => __('Rechange pneu'),
            'frais_immatriculation' => __('Frais d\'immatriculation'),
            'visite_technique' => __('Visite technique'),
            'insurance' => __('Assurance'),
            'other' => __('Autre'),
        ];

        // If the provided category is invalid, ignore it
        if (!$category || !isset($categories[$category])) {
            $category = null;
        }

        $vouchers = $this->paymentVoucherService->getPaymentVouchersByFilters(
            $category,
            $dateFrom,
            $dateTo,
            $sortDirection
        );

        return view('admin.payment_voucher.index', [
            'vouchers' => $vouchers,
            'categories' => $categories,
            'currentCategory' => $category,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
            'sortDirection' => $sortDirection,
        ]);
    }

    /**
     * Show the form for creating a new payment voucher.
     */
    public function create($category = null)
    {
        $vehicules = $this->vehiculeService->getAllVehicules();
        $categories = [
            'carburant' => __('Bon pour Carburant'),
            'entretien' => __('Entretien'),
            'vidange' => __('Vidange'),
            'lavage' => __('Lavage'),
            'lubrifiant' => __('Lubrifiant'),
            'reparation' => __('Reparation'),
            'achat_pieces_recharges' => __('Achat pieces de recharges'),
            'rechange_pneu' => __('Rechange pneu'),
            'frais_immatriculation' => __('Frais d\'immatriculation'),
            'visite_technique' => __('Visite technique'),
            'insurance' => __('Assurance'),
            'other' => __('Autre'),
        ];

        $selectedVehicule = null;
        $tires = [];
        $vidanges = [];
        $timingChaines = [];
        $nextInsuranceExpirationDate = null;

        if ($category === 'rechange_pneu' && request()->has('vehicule_id')) {
            try {
                $vehiculeId = request()->vehicule_id;
                $selectedVehicule = Vehicule::with('pneu')->find($vehiculeId);
                if ($selectedVehicule) {
                    $tires = $selectedVehicule->pneu;
                }
            } catch (\Throwable $th) {
                // Invalid vehicule ID
            }
        }

        if ($category === 'entretien' && request()->has('vehicule_id')) {
            try {
                $vehiculeId = request()->vehicule_id;
                $selectedVehicule = Vehicule::with(['vidange', 'timing_chaine'])->find($vehiculeId);
                if ($selectedVehicule) {
                    if ($selectedVehicule->vidange) {
                        $vidanges[] = $selectedVehicule->vidange;
                    }
                    if ($selectedVehicule->timing_chaine) {
                        $timingChaines[] = $selectedVehicule->timing_chaine;
                    }
                }
            } catch (\Throwable $th) {
                // Invalid vehicule ID
            }
        }

        // Handle vidange category - no need to load vidanges since user will enter threshold manually
        if ($category === 'vidange' && request()->has('vehicule_id')) {
            try {
                $vehiculeId = request()->vehicule_id;
                $selectedVehicule = Vehicule::find($vehiculeId);
            } catch (\Throwable $th) {
                // Invalid vehicule ID
            }
        }

        $nextInsuranceExpirationDate = null;
        $nextTechnicalVisitExpirationDate = null;

        // Get next insurance expiration date for insurance category
        if ($category === 'insurance' && request()->has('vehicule_id')) {
            try {
                $vehiculeId = request()->vehicule_id;
                $selectedVehicule = Vehicule::find($vehiculeId);
                if ($selectedVehicule) {
                    // Get the latest insurance expiration date from payment vouchers for this vehicle
                    $latestInsuranceVoucher = PaymentVoucher::where('vehicule_id', $vehiculeId)
                        ->where('category', 'insurance')
                        ->whereNotNull('insurance_expiration_date')
                        ->orderBy('insurance_expiration_date', 'desc')
                        ->first();
                    
                    if ($latestInsuranceVoucher && $latestInsuranceVoucher->getInsuranceExpirationDate()) {
                        $nextInsuranceExpirationDate = $latestInsuranceVoucher->getInsuranceExpirationDate();
                    } else {
                        // Use vehicle's current insurance expiration date
                        $nextInsuranceExpirationDate = $selectedVehicule->getInssuranceExpiration();
                    }
                }
            } catch (\Throwable $th) {
                // Invalid vehicule ID
            }
        }

        // Get next technical visit expiration date for visite_technique category
        if ($category === 'visite_technique' && request()->has('vehicule_id')) {
            try {
                $vehiculeId = request()->vehicule_id;
                $selectedVehicule = Vehicule::find($vehiculeId);
                if ($selectedVehicule) {
                    // Get the latest technical visit expiration date from payment vouchers for this vehicle
                    $latestTechnicalVisitVoucher = PaymentVoucher::where('vehicule_id', $vehiculeId)
                        ->where('category', 'visite_technique')
                        ->whereNotNull('technical_visit_expiration_date')
                        ->orderBy('technical_visit_expiration_date', 'desc')
                        ->first();
                    
                    if ($latestTechnicalVisitVoucher && $latestTechnicalVisitVoucher->getTechnicalVisitExpirationDate()) {
                        $nextTechnicalVisitExpirationDate = $latestTechnicalVisitVoucher->getTechnicalVisitExpirationDate();
                    } else {
                        // Use vehicle's current technical visit expiration date
                        $nextTechnicalVisitExpirationDate = $selectedVehicule->getTechnicalvisiteExpiration();
                    }
                }
            } catch (\Throwable $th) {
                // Invalid vehicule ID
            }
        }

        return view('admin.payment_voucher.create', [
            'vehicules' => $vehicules,
            'categories' => $categories,
            'category' => $category,
            'selectedVehicule' => $selectedVehicule,
            'tires' => $tires,
            'vidanges' => $vidanges,
            'timingChaines' => $timingChaines,
            'nextInsuranceExpirationDate' => $nextInsuranceExpirationDate,
            'nextTechnicalVisitExpirationDate' => $nextTechnicalVisitExpirationDate,
        ]);
    }

    /**
     * Store a newly created payment voucher.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'invoice_number' => 'nullable|string|max:255',
            'invoice_date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'vehicule_id' => 'required|exists:vehicules,id',
            'vehicle_km' => 'required|integer|min:0',
            'supplier' => 'nullable|string|max:255',
            'additional_info' => 'nullable|string',
            'category' => 'required|in:carburant,entretien,vidange,lavage,lubrifiant,reparation,achat_pieces_recharges,rechange_pneu,frais_immatriculation,visite_technique,insurance,other',
            'document' => 'nullable|file|max:51200', // 50MB max
            'voucher_files.*' => 'nullable|file|max:51200',
            'invoice_files.*' => 'nullable|file|max:51200',
            'vignette_files.*' => 'nullable|file|max:51200',
            'other_files.*' => 'nullable|file|max:51200',
            'fuel_liters' => 'nullable|required_if:category,carburant|numeric|min:0',
            'tire_id' => 'nullable|required_if:category,rechange_pneu|exists:pneus,id',
            'vidange_id' => 'nullable|exists:vidanges,id',
            'vidange_threshold_km' => 'nullable|required_if:category,vidange|integer|min:1',
            'timing_chaine_id' => 'nullable|exists:timing_chaines,id',
            'insurance_expiration_date' => 'nullable|required_if:category,insurance|date',
            'technical_visit_expiration_date' => 'nullable|required_if:category,visite_technique|date',
        ], [
            'invoice_date.required' => __('La date de facture est requise'),
            'amount.required' => __('Le montant est requis'),
            'vehicule_id.required' => __('Le véhicule est requis'),
            'vehicle_km.required' => __('Le kilométrage du véhicule est requis'),
            'category.required' => __('La catégorie est requise'),
            'fuel_liters.required_if' => __('Les litres de carburant sont requis pour les bons de carburant'),
            'tire_id.required_if' => __('Le pneu est requis pour les changements de pneu'),
        ]);

        try {
            $voucher = $this->paymentVoucherService->createPaymentVoucher($request);
            
            // Handle file uploads during creation
            if ($request->hasFile('voucher_files')) {
                $this->paymentVoucherService->addAttachments($voucher, $request->file('voucher_files'), 'voucher');
            }
            if ($request->hasFile('invoice_files')) {
                $this->paymentVoucherService->addAttachments($voucher, $request->file('invoice_files'), 'invoice');
            }
            if ($request->hasFile('vignette_files')) {
                $this->paymentVoucherService->addAttachments($voucher, $request->file('vignette_files'), 'vignette');
            }
            if ($request->hasFile('other_files')) {
                $this->paymentVoucherService->addAttachments($voucher, $request->file('other_files'), 'other');
            }
            
            Alert::success(__('Succès'), __('Bon de paiement créé avec succès'));
            return redirect()->route('admin.payment_voucher.show', $voucher->getId());
        } catch (\Exception $e) {
            Alert::error(__('Erreur'), __('Échec de la création du bon de paiement: ') . $e->getMessage());
        }

        $category = $request->category;
        return redirect()->route('admin.payment_voucher.index', ['category' => $category]);
    }

    /**
     * Display the specified payment voucher.
     */
    public function show($id)
    {
        try {
            $voucher = $this->paymentVoucherService->getPaymentVoucherById($id);

            if (!$voucher) {
                Alert::error(__('Erreur'), __('Bon de paiement introuvable'));
                return redirect()->route('admin.payment_voucher.index');
            }
        } catch (\Throwable $th) {
            Alert::error(__('Erreur'), __('ID de bon de paiement invalide'));
            return redirect()->route('admin.payment_voucher.index');
        }

        // Load attachments
        $voucher->load('attachments');

        return view('admin.payment_voucher.show', [
            'voucher' => $voucher,
        ]);
    }

    /**
     * Show the form for editing the specified payment voucher.
     */
    public function edit($id)
    {
        try {
            $voucher = $this->paymentVoucherService->getPaymentVoucherById($id);

            if (!$voucher) {
                Alert::error(__('Erreur'), __('Bon de paiement introuvable'));
                return redirect()->route('admin.payment_voucher.index');
            }
        } catch (\Throwable $th) {
            Alert::error(__('Erreur'), __('ID de bon de paiement invalide'));
            return redirect()->route('admin.payment_voucher.index');
        }

        // Load attachments
        $voucher->load('attachments');

        $vehicules = $this->vehiculeService->getAllVehicules();
        $categories = [
            'carburant' => __('Bon pour Carburant'),
            'entretien' => __('Entretien'),
            'vidange' => __('Vidange'),
            'lavage' => __('Lavage'),
            'lubrifiant' => __('Lubrifiant'),
            'reparation' => __('Reparation'),
            'achat_pieces_recharges' => __('Achat pieces de recharges'),
            'rechange_pneu' => __('Rechange pneu'),
            'frais_immatriculation' => __('Frais d\'immatriculation'),
            'visite_technique' => __('Visite technique'),
            'insurance' => __('Assurance'),
            'other' => __('Autre'),
        ];

        $selectedVehicule = Vehicule::with(['pneu', 'vidange', 'timing_chaine'])->find($voucher->getVehiculeId());
        $tires = $selectedVehicule ? $selectedVehicule->pneu : [];
        $vidanges = $selectedVehicule && $selectedVehicule->vidange ? [$selectedVehicule->vidange] : [];
        $timingChaines = $selectedVehicule && $selectedVehicule->timing_chaine ? [$selectedVehicule->timing_chaine] : [];

        return view('admin.payment_voucher.edit', [
            'voucher' => $voucher,
            'vehicules' => $vehicules,
            'categories' => $categories,
            'selectedVehicule' => $selectedVehicule,
            'tires' => $tires,
            'vidanges' => $vidanges,
            'timingChaines' => $timingChaines,
        ]);
    }

    /**
     * Update the specified payment voucher.
     */
    public function update(Request $request, $id)
    {
        try {
            $voucher = $this->paymentVoucherService->getPaymentVoucherById($id);

            if (!$voucher) {
                Alert::error(__('Erreur'), __('Bon de paiement introuvable'));
                return redirect()->route('admin.payment_voucher.index');
            }
        } catch (\Throwable $th) {
            Alert::error(__('Erreur'), __('ID de bon de paiement invalide'));
            return redirect()->route('admin.payment_voucher.index');
        }

        $validated = $request->validate([
            'invoice_number' => 'nullable|string|max:255',
            'invoice_date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'vehicule_id' => 'required|exists:vehicules,id',
            'vehicle_km' => 'required|integer|min:0',
            'supplier' => 'nullable|string|max:255',
            'additional_info' => 'nullable|string',
            'category' => 'required|in:carburant,entretien,vidange,lavage,lubrifiant,reparation,achat_pieces_recharges,rechange_pneu,frais_immatriculation,visite_technique,insurance,other',
            'document' => 'nullable|file|max:51200', // 50MB max
            'voucher_files.*' => 'nullable|file|max:51200',
            'invoice_files.*' => 'nullable|file|max:51200',
            'vignette_files.*' => 'nullable|file|max:51200',
            'other_files.*' => 'nullable|file|max:51200',
            'fuel_liters' => 'nullable|required_if:category,carburant|numeric|min:0',
            'tire_id' => 'nullable|required_if:category,rechange_pneu|exists:pneus,id',
            'vidange_id' => 'nullable|exists:vidanges,id',
            'vidange_threshold_km' => 'nullable|required_if:category,vidange|integer|min:1',
            'timing_chaine_id' => 'nullable|exists:timing_chaines,id',
            'insurance_expiration_date' => 'nullable|required_if:category,insurance|date',
            'technical_visit_expiration_date' => 'nullable|required_if:category,visite_technique|date',
        ], [
            'invoice_date.required' => __('La date de facture est requise'),
            'amount.required' => __('Le montant est requis'),
            'vehicule_id.required' => __('Le véhicule est requis'),
            'vehicle_km.required' => __('Le kilométrage du véhicule est requis'),
            'category.required' => __('La catégorie est requise'),
            'fuel_liters.required_if' => __('Les litres de carburant sont requis pour les bons de carburant'),
            'tire_id.required_if' => __('Le pneu est requis pour les changements de pneu'),
        ]);

        try {
            $this->paymentVoucherService->updatePaymentVoucher($voucher, $request);
            
            // Handle file uploads during update
            if ($request->hasFile('voucher_files')) {
                $this->paymentVoucherService->addAttachments($voucher, $request->file('voucher_files'), 'voucher');
            }
            if ($request->hasFile('invoice_files')) {
                $this->paymentVoucherService->addAttachments($voucher, $request->file('invoice_files'), 'invoice');
            }
            if ($request->hasFile('vignette_files')) {
                $this->paymentVoucherService->addAttachments($voucher, $request->file('vignette_files'), 'vignette');
            }
            if ($request->hasFile('other_files')) {
                $this->paymentVoucherService->addAttachments($voucher, $request->file('other_files'), 'other');
            }
            
            Alert::success(__('Succès'), __('Bon de paiement mis à jour avec succès'));
        } catch (\Exception $e) {
            Alert::error(__('Erreur'), __('Échec de la mise à jour du bon de paiement: ') . $e->getMessage());
        }

        return redirect()->route('admin.payment_voucher.show', ['id' => $voucher->getId()]);
    }

    /**
     * Remove the specified payment voucher.
     */
    public function destroy($id)
    {
        try {
            $voucher = $this->paymentVoucherService->getPaymentVoucherById($id);

            if (!$voucher) {
                Alert::error(__('Erreur'), __('Bon de paiement introuvable'));
                return redirect()->route('admin.payment_voucher.index');
            }

            $this->paymentVoucherService->deletePaymentVoucher($voucher);
            Alert::success(__('Succès'), __('Bon de paiement supprimé avec succès'));
        } catch (\Throwable $th) {
            Alert::error(__('Erreur'), __('Échec de la suppression du bon de paiement'));
        }

        return redirect()->route('admin.payment_voucher.index');
    }

    /**
     * Get next insurance expiration date for a vehicle (AJAX).
     */
    public function getInsuranceExpiration($vehiculeId)
    {
        try {
            $vehicule = Vehicule::find($vehiculeId);
            
            if (!$vehicule) {
                return response()->json([
                    'success' => false,
                    'message' => __('Véhicule introuvable')
                ], 404);
            }

            // Get the latest insurance expiration date from payment vouchers for this vehicle
            $latestInsuranceVoucher = PaymentVoucher::where('vehicule_id', $vehiculeId)
                ->where('category', 'insurance')
                ->whereNotNull('insurance_expiration_date')
                ->orderBy('insurance_expiration_date', 'desc')
                ->first();
            
            $nextInsuranceExpirationDate = null;
            
            if ($latestInsuranceVoucher && $latestInsuranceVoucher->getInsuranceExpirationDate()) {
                $nextInsuranceExpirationDate = $latestInsuranceVoucher->getInsuranceExpirationDate();
            } else {
                // Use vehicle's current insurance expiration date
                $nextInsuranceExpirationDate = $vehicule->getInssuranceExpiration();
            }

            return response()->json([
                'success' => true,
                'expiration_date' => $nextInsuranceExpirationDate
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => __('Erreur lors de la récupération de la date d\'expiration')
            ], 500);
        }
    }

    /**
     * Get next technical visit expiration date for a vehicle (AJAX).
     */
    public function getTechnicalVisitExpiration($vehiculeId)
    {
        try {
            $vehicule = Vehicule::find($vehiculeId);
            
            if (!$vehicule) {
                return response()->json([
                    'success' => false,
                    'message' => __('Véhicule introuvable')
                ], 404);
            }

            // Get the latest technical visit expiration date from payment vouchers for this vehicle
            $latestTechnicalVisitVoucher = PaymentVoucher::where('vehicule_id', $vehiculeId)
                ->where('category', 'visite_technique')
                ->whereNotNull('technical_visit_expiration_date')
                ->orderBy('technical_visit_expiration_date', 'desc')
                ->first();
            
            $nextTechnicalVisitExpirationDate = null;
            
            if ($latestTechnicalVisitVoucher && $latestTechnicalVisitVoucher->getTechnicalVisitExpirationDate()) {
                $nextTechnicalVisitExpirationDate = $latestTechnicalVisitVoucher->getTechnicalVisitExpirationDate();
            } else {
                // Use vehicle's current technical visit expiration date
                $nextTechnicalVisitExpirationDate = $vehicule->getTechnicalvisiteExpiration();
            }

            return response()->json([
                'success' => true,
                'expiration_date' => $nextTechnicalVisitExpirationDate
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => __('Erreur lors de la récupération de la date d\'expiration')
            ], 500);
        }
    }

    /**
     * Get vehicle current KM for vidange calculation (AJAX).
     */
    public function getVehicleKm($vehiculeId)
    {
        try {
            $vehicule = Vehicule::find($vehiculeId);
            
            if (!$vehicule) {
                return response()->json([
                    'success' => false,
                    'message' => __('Véhicule introuvable')
                ], 404);
            }

            // Get vehicle's current KM
            $currentKm = $vehicule->getTotalKm();

            return response()->json([
                'success' => true,
                'total_km' => $currentKm,
                'total_hours' => $vehicule->getTotalHours()
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => __('Erreur lors de la récupération du kilométrage du véhicule')
            ], 500);
        }
    }

    /**
     * Get vehicle tires (AJAX).
     */
    public function getVehicleTires($vehiculeId)
    {
        try {
            $vehicule = Vehicule::with('pneu')->find($vehiculeId);
            
            if (!$vehicule) {
                return response()->json([
                    'success' => false,
                    'message' => __('Véhicule introuvable')
                ], 404);
            }

            $tires = $vehicule->pneu->map(function($tire) {
                return [
                    'id' => $tire->getId(),
                    'position' => $tire->getTirePosition(),
                    'threshold_km' => $tire->getThresholdKm(),
                ];
            });

            return response()->json([
                'success' => true,
                'tires' => $tires
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => __('Erreur lors de la récupération des pneus')
            ], 500);
        }
    }

    /**
     * Add attachments to payment voucher.
     */
    public function addAttachments(Request $request)
    {
        $validated = $request->validate([
            'payment_voucher_id' => 'required|exists:payment_vouchers,id',
            'document_type' => 'required|in:voucher,invoice,vignette,other',
            'files.*' => 'required|file|max:51200', // 50MB max
        ]);

        try {
            $voucher = $this->paymentVoucherService->getPaymentVoucherById($request->payment_voucher_id);
            
            if (!$voucher) {
                Alert::error(__('Erreur'), __('Bon de paiement introuvable'));
                return back();
            }

            $this->paymentVoucherService->addAttachments(
                $voucher,
                $request->file('files'),
                $request->document_type
            );
            
            Alert::success(__('Succès'), __('Fichiers téléchargés avec succès'));
        } catch (\Throwable $th) {
            Alert::error(__('Erreur'), __('Échec du téléchargement des fichiers: ') . $th->getMessage());
        }

        return back();
    }

    /**
     * Delete an attachment.
     */
    public function deleteAttachment($id)
    {
        try {
            $this->paymentVoucherService->deleteAttachment($id);
            Alert::success(__('Succès'), __('Fichier supprimé avec succès'));
        } catch (\Throwable $th) {
            Alert::error(__('Erreur'), __('Échec de la suppression du fichier'));
        }
        
        return back();
    }
}
