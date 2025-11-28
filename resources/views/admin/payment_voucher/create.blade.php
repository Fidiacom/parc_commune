<x-admin.app>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="mb-1 font-size-18">
                            <i class="mdi mdi-receipt mr-2 text-primary"></i>{{ __('Nouveau bon de paiement') }}
                        </h4>
                        <p class="text-muted mb-0">{{ __('Remplissez les informations ci-dessous pour créer un nouveau bon de paiement') }}</p>
                    </div>
                    <a href="{{ route('admin.payment_voucher.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left mr-2"></i>{{ __('Retour') }}
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-10 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.payment_voucher.store') }}" method="POST" enctype="multipart/form-data" id="voucherForm">
                            @csrf

                            @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <h5 class="alert-heading"><i class="fas fa-exclamation-triangle"></i> {{ __('Erreurs de validation') }}</h5>
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            @endif

                            <!-- Category Selection -->
                            <div class="form-group">
                                <label class="font-weight-semibold">{{ __('Catégorie') }} <span class="text-danger">*</span></label>
                                <select name="category" id="category" class="form-control @error('category') is-invalid @enderror" required onchange="handleCategoryChange()">
                                    <option value="">{{ __('Sélectionner une catégorie') }}</option>
                                    @foreach($categories as $key => $label)
                                    <option value="{{ $key }}" {{ old('category', $category) === $key ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Vehicle Selection -->
                            <div class="form-group">
                                <label class="font-weight-semibold">{{ __('Véhicule concerné') }} <span class="text-danger">*</span></label>
                                <select name="vehicule_id" id="vehicule_id" class="form-control @error('vehicule_id') is-invalid @enderror" required onchange="handleVehiculeChange()">
                                    <option value="">{{ __('Sélectionner un véhicule') }}</option>
                                    @foreach($vehicules as $v)
                                    <option value="{{ $v->getId() }}" {{ old('vehicule_id') == $v->getId() ? 'selected' : '' }}>
                                        {{ $v->getBrand() }} - {{ $v->getModel() }} - {{ $v->getMatricule() }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('vehicule_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Vehicle KM -->
                            <div class="form-group">
                                <label class="font-weight-semibold">{{ __('KM du véhicule') }} <span class="text-danger">*</span></label>
                                <input type="text" name="vehicle_km" id="vehicle_km" class="form-control @error('vehicle_km') is-invalid @enderror" 
                                       value="{{ old('vehicle_km') }}" required placeholder="{{ __('Entrer le kilométrage') }}">
                                @error('vehicle_km')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Vehicle Hours -->
                            <div class="form-group">
                                <label class="font-weight-semibold">{{ __('Heures du véhicule') }}</label>
                                <input type="text" name="vehicle_hours" class="form-control @error('vehicle_hours') is-invalid @enderror" 
                                       value="{{ old('vehicle_hours') }}" placeholder="{{ __('Entrer les heures (pour véhicules avec compteur d\'heures)') }}">
                                @error('vehicle_hours')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Invoice Number -->
                            <div class="form-group">
                                <label class="font-weight-semibold">{{ __('Numéro de facture') }}</label>
                                <input type="text" name="invoice_number" class="form-control @error('invoice_number') is-invalid @enderror" 
                                       value="{{ old('invoice_number') }}" placeholder="{{ __('Numéro de facture') }}">
                                @error('invoice_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Invoice Date -->
                            <div class="form-group">
                                <label class="font-weight-semibold">{{ __('Date de facture') }} <span class="text-danger">*</span></label>
                                <input type="date" name="invoice_date" class="form-control @error('invoice_date') is-invalid @enderror" 
                                       value="{{ old('invoice_date', date('Y-m-d')) }}" required>
                                @error('invoice_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Amount -->
                            <div class="form-group">
                                <label class="font-weight-semibold">{{ __('Montant') }} <span class="text-danger">*</span></label>
                                <input type="text" name="amount" class="form-control @error('amount') is-invalid @enderror" 
                                       value="{{ old('amount') }}" required placeholder="{{ __('Montant en DH') }}">
                                @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Fuel Liters (for carburant) -->
                            <div class="form-group" id="fuel_liters_group" style="display: none;">
                                <label class="font-weight-semibold">{{ __('Litres de carburant') }} <span class="text-danger">*</span></label>
                                <input type="text" name="fuel_liters" id="fuel_liters" class="form-control @error('fuel_liters') is-invalid @enderror" 
                                       value="{{ old('fuel_liters') }}" placeholder="{{ __('Quantité en litres') }}">
                                @error('fuel_liters')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tire Selection (for rechange_pneu) -->
                            <div class="form-group" id="tire_group" style="display: none;">
                                <label class="font-weight-semibold">{{ __('Pneu à changer') }} <span class="text-danger">*</span></label>
                                <select name="tire_id" id="tire_id" class="form-control @error('tire_id') is-invalid @enderror">
                                    <option value="">{{ __('Sélectionner un pneu') }}</option>
                                    @if($selectedVehicule && $tires)
                                        @foreach($tires as $tire)
                                        <option value="{{ $tire->getId() }}" {{ old('tire_id') == $tire->getId() ? 'selected' : '' }}>
                                            {{ $tire->getTirePosition() }} (Seuil: {{ number_format($tire->getThresholdKm(), 0, ',', ' ') }} KM)
                                        </option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('tire_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Maintenance Type (for entretien) -->
                            <!-- <div class="form-group" id="maintenance_group" style="display: none;">
                                <label class="font-weight-semibold">{{ __('Type d\'entretien') }}</label>
                                
                                @if(count($vidanges) > 0)
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="maintenance_type[]" value="vidange" id="maintenance_vidange" onchange="toggleMaintenanceFields()">
                                    <label class="form-check-label" for="maintenance_vidange">
                                        {{ __('Vidange') }}
                                    </label>
                                </div>
                                <div class="form-group ml-4" id="vidange_group" style="display: none;">
                                    <select name="vidange_id" id="vidange_id" class="form-control">
                                        <option value="">{{ __('Sélectionner') }}</option>
                                        @foreach($vidanges as $vidange)
                                        <option value="{{ $vidange->getId() }}">{{ __('Vidange') }} (Seuil: {{ number_format($vidange->getThresholdKm(), 0, ',', ' ') }} KM)</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif

                                @if(count($timingChaines) > 0)
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="maintenance_type[]" value="timing_chaine" id="maintenance_timing" onchange="toggleMaintenanceFields()">
                                    <label class="form-check-label" for="maintenance_timing">
                                        {{ __('Chaîne de distribution') }}
                                    </label>
                                </div>
                                <div class="form-group ml-4" id="timing_chaine_group" style="display: none;">
                                    <select name="timing_chaine_id" id="timing_chaine_id" class="form-control">
                                        <option value="">{{ __('Sélectionner') }}</option>
                                        @foreach($timingChaines as $timingChaine)
                                        <option value="{{ $timingChaine->getId() }}">{{ __('Chaîne de distribution') }} (Seuil: {{ number_format($timingChaine->getThresholdKm(), 0, ',', ' ') }} KM)</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                            </div> -->

                            <!-- Supplier -->
                            <div class="form-group">
                                <label class="font-weight-semibold">{{ __('Fournisseur') }}</label>
                                <input type="text" name="supplier" class="form-control @error('supplier') is-invalid @enderror" 
                                       value="{{ old('supplier') }}" placeholder="{{ __('Nom du fournisseur') }}">
                                @error('supplier')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Insurance Expiration Date (only for insurance category) -->
                            <div class="form-group" id="insurance_expiration_group" style="display: none;">
                                <label class="font-weight-semibold">{{ __('Date d\'expiration de l\'assurance') }} <span class="text-danger">*</span></label>
                                <input type="date" name="insurance_expiration_date" id="insurance_expiration_date" class="form-control @error('insurance_expiration_date') is-invalid @enderror" 
                                       value="{{ old('insurance_expiration_date', $nextInsuranceExpirationDate ?? '') }}">
                                @error('insurance_expiration_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Technical Visit Expiration Date (only for visite_technique category) -->
                            <div class="form-group" id="technical_visit_expiration_group" style="display: none;">
                                <label class="font-weight-semibold">{{ __('Date d\'expiration visite technique') }} <span class="text-danger">*</span></label>
                                <input type="date" name="technical_visit_expiration_date" id="technical_visit_expiration_date" class="form-control @error('technical_visit_expiration_date') is-invalid @enderror" 
                                       value="{{ old('technical_visit_expiration_date', $nextTechnicalVisitExpirationDate ?? '') }}">
                                @error('technical_visit_expiration_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Vidange Threshold Input (only for vidange category) -->
                            <div class="form-group" id="vidange_category_group" style="display: none;">
                                <label class="font-weight-semibold">{{ __('Seuil de vidange (KM)') }} <span class="text-danger">*</span></label>
                                <input type="number" name="vidange_threshold_km" id="vidange_threshold_km" 
                                       class="form-control @error('vidange_threshold_km') is-invalid @enderror" 
                                       value="{{ old('vidange_threshold_km') }}" 
                                       placeholder="{{ __('Ex: 5000, 7000, 10000, 15000') }}"
                                       min="1" step="1"
                                       onchange="calculateNextVidangeKm()" 
                                       onkeyup="calculateNextVidangeKm()">
                                <small class="form-text text-muted">{{ __('Entrez le seuil de vidange en KM (ex: 5000, 7000, 10000, 15000). Le KM du véhicule sera calculé automatiquement (KM actuel + seuil)') }}</small>
                                @error('vidange_threshold_km')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Additional Info -->
                            <div class="form-group">
                                <label class="font-weight-semibold">{{ __('Informations supplémentaires') }}</label>
                                <textarea name="additional_info" class="form-control @error('additional_info') is-invalid @enderror" 
                                          rows="3" placeholder="{{ __('Informations complémentaires') }}">{{ old('additional_info') }}</textarea>
                                @error('additional_info')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Document Upload -->
                            <div class="form-group">
                                <label class="font-weight-semibold">{{ __('Document (Bon ou Facture)') }}</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="document" id="document" accept="image/*,application/pdf">
                                    <label class="custom-file-label" for="document">
                                        <i class="fas fa-cloud-upload-alt mr-2"></i>{{ __('Choisir un fichier (Image ou PDF, max 50MB)') }}
                                    </label>
                                </div>
                                <small class="form-text text-muted">{{ __('Vous pouvez scanner ou télécharger le bon ou la facture') }}</small>
                                @error('document')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-0">
                                <button type="submit" class="btn btn-primary waves-effect waves-light">
                                    <i class="fas fa-save mr-2"></i>{{ __('Enregistrer') }}
                                </button>
                                <a href="{{ route('admin.payment_voucher.index') }}" class="btn btn-secondary waves-effect waves-light ml-2">
                                    {{ __('Annuler') }}
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function handleCategoryChange() {
            const category = document.getElementById('category').value;
            const fuelGroup = document.getElementById('fuel_liters_group');
            const tireGroup = document.getElementById('tire_group');
            const maintenanceGroup = document.getElementById('maintenance_group');
            const insuranceGroup = document.getElementById('insurance_expiration_group');
            const technicalVisitGroup = document.getElementById('technical_visit_expiration_group');
            const vidangeCategoryGroup = document.getElementById('vidange_category_group');
            
            // Safely get form groups with null checks
            const vehicleKmElement = document.getElementById('vehicle_km');
            const vehicleHoursElement = document.getElementById('vehicle_hours');
            const additionalInfoElement = document.getElementById('additional_info');
            const amountElement = document.getElementById('amount');
            
            const vehicleKmGroup = vehicleKmElement ? vehicleKmElement.closest('.form-group') : null;
            const vehicleHoursGroup = vehicleHoursElement ? vehicleHoursElement.closest('.form-group') : null;
            const additionalInfoGroup = additionalInfoElement ? additionalInfoElement.closest('.form-group') : null;
            const amountGroup = amountElement ? amountElement.closest('.form-group') : null;

            // Hide all category-specific groups
            if (fuelGroup) fuelGroup.style.display = 'none';
            if (tireGroup) tireGroup.style.display = 'none';
            if (maintenanceGroup) maintenanceGroup.style.display = 'none';
            if (insuranceGroup) insuranceGroup.style.display = 'none';
            if (technicalVisitGroup) technicalVisitGroup.style.display = 'none';
            if (vidangeCategoryGroup) vidangeCategoryGroup.style.display = 'none';

            // Show relevant group based on category
            if (category === 'carburant') {
                if (fuelGroup) fuelGroup.style.display = 'block';
                const fuelLitersElement = document.getElementById('fuel_liters');
                if (fuelLitersElement) fuelLitersElement.required = true;
            } else {
                const fuelLitersElement = document.getElementById('fuel_liters');
                if (fuelLitersElement) fuelLitersElement.required = false;
            }

            if (category === 'rechange_pneu') {
                if (tireGroup) tireGroup.style.display = 'block';
                const tireIdElement = document.getElementById('tire_id');
                if (tireIdElement) tireIdElement.required = true;
                // Reload page with vehicule selection if needed
                const vehiculeId = document.getElementById('vehicule_id').value;
                if (vehiculeId) {
                    handleVehiculeChange();
                }
            } else {
                const tireIdElement = document.getElementById('tire_id');
                if (tireIdElement) tireIdElement.required = false;
            }

            if (category === 'entretien') {
                if (maintenanceGroup) maintenanceGroup.style.display = 'block';
            }

            // Show insurance expiration date only for insurance category
            if (category === 'insurance') {
                if (insuranceGroup) insuranceGroup.style.display = 'block';
                const insuranceDateElement = document.getElementById('insurance_expiration_date');
                if (insuranceDateElement) insuranceDateElement.required = true;
                // Load next insurance expiration date when vehicle is selected
                const vehiculeId = document.getElementById('vehicule_id').value;
                if (vehiculeId) {
                    loadNextInsuranceExpirationDate(vehiculeId);
                }
            } else {
                const insuranceDateElement = document.getElementById('insurance_expiration_date');
                if (insuranceDateElement) insuranceDateElement.required = false;
            }

            // Show technical visit expiration date only for visite_technique category
            if (category === 'visite_technique') {
                if (technicalVisitGroup) technicalVisitGroup.style.display = 'block';
                const technicalVisitDateElement = document.getElementById('technical_visit_expiration_date');
                if (technicalVisitDateElement) technicalVisitDateElement.required = true;
                // Load next technical visit expiration date when vehicle is selected
                const vehiculeId = document.getElementById('vehicule_id').value;
                if (vehiculeId) {
                    loadNextTechnicalVisitExpirationDate(vehiculeId);
                }
            } else {
                const technicalVisitDateElement = document.getElementById('technical_visit_expiration_date');
                if (technicalVisitDateElement) technicalVisitDateElement.required = false;
            }

            // Show vidange threshold input only for vidange category
            if (category === 'vidange') {
                if (vidangeCategoryGroup) vidangeCategoryGroup.style.display = 'block';
                const vidangeThresholdElement = document.getElementById('vidange_threshold_km');
                if (vidangeThresholdElement) vidangeThresholdElement.required = true;
            } else {
                if (vidangeCategoryGroup) vidangeCategoryGroup.style.display = 'none';
                const vidangeThresholdElement = document.getElementById('vidange_threshold_km');
                if (vidangeThresholdElement) vidangeThresholdElement.required = false;
            }

            // For "other" category, ensure km, hours, description, and amount are visible
            if (category === 'other') {
                if (vehicleKmGroup) vehicleKmGroup.style.display = 'block';
                if (vehicleHoursGroup) vehicleHoursGroup.style.display = 'block';
                if (additionalInfoGroup) additionalInfoGroup.style.display = 'block';
                if (amountGroup) amountGroup.style.display = 'block';
            }
        }

        function loadNextInsuranceExpirationDate(vehiculeId) {
            if (!vehiculeId) return;
            
            // Use AJAX to fetch the next insurance expiration date
            fetch("{{ route('admin.payment_voucher.get_insurance_expiration', '') }}/" + vehiculeId, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.expiration_date) {
                    const insuranceDateElement = document.getElementById('insurance_expiration_date');
                    if (insuranceDateElement) insuranceDateElement.value = data.expiration_date;
                }
            })
            .catch(error => {
                console.error('Error loading insurance expiration date:', error);
            });
        }

        function loadNextTechnicalVisitExpirationDate(vehiculeId) {
            if (!vehiculeId) return;
            
            // Use AJAX to fetch the next technical visit expiration date
            fetch("{{ route('admin.payment_voucher.get_technical_visit_expiration', '') }}/" + vehiculeId, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.expiration_date) {
                    const technicalVisitDateElement = document.getElementById('technical_visit_expiration_date');
                    if (technicalVisitDateElement) technicalVisitDateElement.value = data.expiration_date;
                }
            })
            .catch(error => {
                console.error('Error loading technical visit expiration date:', error);
            });
        }

        function handleVehiculeChange() {
            const vehiculeId = document.getElementById('vehicule_id').value;
            const category = document.getElementById('category').value;
            
            // Only reload for categories that need vehicle-specific data loaded from server
            if (category === 'rechange_pneu' && vehiculeId) {
                // Reload page with vehicule selection to load tires
                window.location.href = "{{ route('admin.payment_voucher.create.category', 'rechange_pneu') }}?vehicule_id=" + vehiculeId;
            } else if (category === 'entretien' && vehiculeId) {
                // Reload page with vehicule selection to load maintenance options
                window.location.href = "{{ route('admin.payment_voucher.create.category', 'entretien') }}?vehicule_id=" + vehiculeId;
            } else if (category === 'vidange' && vehiculeId) {
                // No need to reload, just enable the threshold input
                // The calculation will happen when user enters the threshold
            } else if (category === 'insurance' && vehiculeId) {
                // Use AJAX to load next insurance expiration date without reloading
                loadNextInsuranceExpirationDate(vehiculeId);
            } else if (category === 'visite_technique' && vehiculeId) {
                // Use AJAX to load next technical visit expiration date without reloading
                loadNextTechnicalVisitExpirationDate(vehiculeId);
            }
        }

        function calculateNextVidangeKm() {
            const vehiculeId = document.getElementById('vehicule_id').value;
            const thresholdKm = document.getElementById('vidange_threshold_km').value;
            
            if (!vehiculeId || !thresholdKm || thresholdKm <= 0) {
                return;
            }
            
            // Use AJAX to get current vehicle KM
            const baseUrl = "{{ url('/admin/payment-voucher/get-vehicle-km') }}";
            fetch(baseUrl + '/' + vehiculeId, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.total_km !== undefined) {
                    const currentKm = parseInt(data.total_km) || 0;
                    const nextKm = currentKm + parseInt(thresholdKm);
                    
                    const vehicleKmElement = document.getElementById('vehicle_km');
                    if (vehicleKmElement) {
                        vehicleKmElement.value = nextKm;
                    }
                } else {
                    console.error(data.message || 'Erreur lors de la récupération du KM');
                }
            })
            .catch(error => {
                console.error('Error calculating next vidange KM:', error);
            });
        }

        function toggleMaintenanceFields() {
            const vidangeCheck = document.getElementById('maintenance_vidange');
            const timingCheck = document.getElementById('maintenance_timing');
            const vidangeGroup = document.getElementById('vidange_group');
            const timingGroup = document.getElementById('timing_chaine_group');

            if (vidangeCheck && vidangeCheck.checked) {
                if (vidangeGroup) vidangeGroup.style.display = 'block';
            } else {
                if (vidangeGroup) vidangeGroup.style.display = 'none';
                const vidangeIdElement = document.getElementById('vidange_id');
                if (vidangeIdElement) vidangeIdElement.value = '';
            }

            if (timingCheck && timingCheck.checked) {
                if (timingGroup) timingGroup.style.display = 'block';
            } else {
                if (timingGroup) timingGroup.style.display = 'none';
                const timingChaineIdElement = document.getElementById('timing_chaine_id');
                if (timingChaineIdElement) timingChaineIdElement.value = '';
            }
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            handleCategoryChange();
            // Only toggle maintenance fields if maintenance group exists
            const maintenanceGroup = document.getElementById('maintenance_group');
            if (maintenanceGroup && maintenanceGroup.style.display !== 'none') {
                toggleMaintenanceFields();
            }

            // Show insurance field if category is already insurance
            const category = document.getElementById('category').value;
            if (category === 'insurance') {
                const insuranceGroup = document.getElementById('insurance_expiration_group');
                if (insuranceGroup) {
                    insuranceGroup.style.display = 'block';
                    const insuranceDateElement = document.getElementById('insurance_expiration_date');
                    if (insuranceDateElement) insuranceDateElement.required = true;
                    // Load insurance expiration date if vehicle is already selected
                    const vehiculeId = document.getElementById('vehicule_id').value;
                    if (vehiculeId) {
                        loadNextInsuranceExpirationDate(vehiculeId);
                    }
                }
            }

            // Show technical visit field if category is already visite_technique
            if (category === 'visite_technique') {
                const technicalVisitGroup = document.getElementById('technical_visit_expiration_group');
                if (technicalVisitGroup) {
                    technicalVisitGroup.style.display = 'block';
                    const technicalVisitDateElement = document.getElementById('technical_visit_expiration_date');
                    if (technicalVisitDateElement) technicalVisitDateElement.required = true;
                    // Load technical visit expiration date if vehicle is already selected
                    const vehiculeId = document.getElementById('vehicule_id').value;
                    if (vehiculeId) {
                        loadNextTechnicalVisitExpirationDate(vehiculeId);
                    }
                }
            }

            // Show vidange field if category is already vidange
            if (category === 'vidange') {
                if (vidangeCategoryGroup) {
                    vidangeCategoryGroup.style.display = 'block';
                    const vidangeIdElement = document.getElementById('vidange_id_category');
                    if (vidangeIdElement) vidangeIdElement.required = true;
                }
            }

            // File input label update
            var documentInput = document.getElementById('document');
            if (documentInput) {
                var chooseFileText = '{{ __("Choisir un fichier") }}';
                documentInput.addEventListener('change', function(e) {
                    var fileName = (e.target.files && e.target.files[0] && e.target.files[0].name) ? e.target.files[0].name : chooseFileText;
                    if (e.target.nextElementSibling) {
                        e.target.nextElementSibling.textContent = fileName;
                    }
                });
            }
        });
    </script>
</x-admin.app>

