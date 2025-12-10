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
                                <label class="font-weight-semibold">{{ __('KM du bon') }} <span class="text-danger">*</span></label>
                                <input type="text" name="vehicle_km" id="vehicle_km" class="form-control @error('vehicle_km') is-invalid @enderror" 
                                       value="{{ old('vehicle_km') }}" required placeholder="{{ __('Entrer le kilométrage') }}">
                                @error('vehicle_km')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Vehicle Hours -->
                            <div class="form-group">
                                <label class="font-weight-semibold">{{ __('Heures du bon') }}</label>
                                <input type="text" name="vehicle_hours" class="form-control @error('vehicle_hours') is-invalid @enderror" 
                                       value="{{ old('vehicle_hours') }}" placeholder="{{ __('Entrer les heures (pour véhicules avec compteur d\'heures)') }}">
                                @error('vehicle_hours')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Voucher Number -->
                            <div class="form-group">
                                <label class="font-weight-semibold">{{ __('Numéro de bon') }}</label>
                                <input type="text" name="voucher_number" class="form-control @error('voucher_number') is-invalid @enderror" 
                                       value="{{ old('voucher_number') }}" placeholder="{{ __('Laisser vide pour générer automatiquement') }}">
                                @error('voucher_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Voucher Date -->
                            <div class="form-group">
                                <label class="font-weight-semibold">{{ __('Date du bon') }}</label>
                                <input type="date" name="voucher_date" class="form-control @error('voucher_date') is-invalid @enderror" 
                                       value="{{ old('voucher_date') }}">
                                @error('voucher_date')
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
                                <label class="font-weight-semibold">{{ __('Date de facture') }}</label>
                                <input type="date" name="invoice_date" class="form-control @error('invoice_date') is-invalid @enderror" 
                                       value="{{ old('invoice_date') }}">
                                @error('invoice_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Amount -->
                            <div class="form-group">
                                <label class="font-weight-semibold">{{ __('Montant') }} <span class="text-danger">*</span></label>
                                <input type="text" name="amount" id="amount" class="form-control @error('amount') is-invalid @enderror" 
                                       value="{{ old('amount') }}" required placeholder="{{ __('Montant en DH') }}" 
                                       onchange="calculateDenominations(); calculateFuelAmount('amount'); enforceIntegerAmount();" onkeyup="calculateDenominations(); calculateFuelAmount('amount'); enforceIntegerAmount();">
                                @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Denominations -->
                            <div class="card mb-3">
                                <div class="card-header bg-info text-white">
                                    <h5 class="mb-0"><i class="fas fa-money-bill-wave mr-2"></i>{{ __('Dénominations') }}</h5>
                                </div>
                                <div class="card-body">
                                    <p class="text-muted">{{ __('Entrez le nombre de billets pour chaque dénomination') }}</p>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="font-weight-semibold">{{ __('20 DH') }}</label>
                                            <input type="number" name="denominations[20]" id="denomination_20" class="form-control" 
                                                   value="{{ old('denominations.20', 0) }}" min="0" onchange="updateTotal()" onkeyup="updateTotal()">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="font-weight-semibold">{{ __('50 DH') }}</label>
                                            <input type="number" name="denominations[50]" id="denomination_50" class="form-control" 
                                                   value="{{ old('denominations.50', 0) }}" min="0" onchange="updateTotal()" onkeyup="updateTotal()">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="font-weight-semibold">{{ __('100 DH') }}</label>
                                            <input type="number" name="denominations[100]" id="denomination_100" class="form-control" 
                                                   value="{{ old('denominations.100', 0) }}" min="0" onchange="updateTotal()" onkeyup="updateTotal()">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="font-weight-semibold">{{ __('200 DH') }}</label>
                                            <input type="number" name="denominations[200]" id="denomination_200" class="form-control" 
                                                   value="{{ old('denominations.200', 0) }}" min="0" onchange="updateTotal()" onkeyup="updateTotal()">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="font-weight-semibold">{{ __('300 DH') }}</label>
                                            <input type="number" name="denominations[300]" id="denomination_300" class="form-control" 
                                                   value="{{ old('denominations.300', 0) }}" min="0" onchange="updateTotal()" onkeyup="updateTotal()">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="font-weight-semibold">{{ __('400 DH') }}</label>
                                            <input type="number" name="denominations[400]" id="denomination_400" class="form-control" 
                                                   value="{{ old('denominations.400', 0) }}" min="0" onchange="updateTotal()" onkeyup="updateTotal()">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="font-weight-semibold">{{ __('500 DH') }}</label>
                                            <input type="number" name="denominations[500]" id="denomination_500" class="form-control" 
                                                   value="{{ old('denominations.500', 0) }}" min="0" onchange="updateTotal()" onkeyup="updateTotal()">
                                        </div>
                                    </div>
                                    <div class="alert alert-info mt-3">
                                        <strong>{{ __('Total calculé') }}:</strong> <span id="calculated_total">0</span> DH
                                    </div>
                                </div>
                            </div>

                            <!-- Fuel Liters (for carburant) -->
                            <div class="form-group" id="fuel_liters_group" style="display: none;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="font-weight-semibold">{{ __('Litres de carburant') }} <span class="text-danger">*</span></label>
                                        <input type="text" readonly name="fuel_liters" id="fuel_liters" class="form-control @error('fuel_liters') is-invalid @enderror" 
                                               value="{{ old('fuel_liters') }}" placeholder="{{ __('Quantité en litres') }}"
                                                onkeyup="calculateFuelAmount('fuel_liters')">
                                        @error('fuel_liters')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="font-weight-semibold">{{ __('Prix par litre (DH)') }}</label>
                                        <input type="text" name="price_per_liter" id="price_per_liter" class="form-control" 
                                               value="{{ old('price_per_liter') }}" placeholder="{{ __('Prix par litre') }}"
                                               onchange="calculateFuelAmount('price_per_liter')" onkeyup="calculateFuelAmount('price_per_liter')">
                                        <small class="form-text text-muted">{{ __('Le montant total sera calculé automatiquement') }}</small>
                                    </div>
                                </div>
                                <div class="alert alert-info mt-2" id="fuel_calculation_info" style="display: none;">
                                    <strong>{{ __('Résultat') }}:</strong> <span id="calculated_fuel_amount">0</span>
                                </div>
                            </div>

                            <!-- Tire Selection (for rechange_pneu) -->
                            <div class="form-group" id="tire_group" style="display: none;">
                                <label class="font-weight-semibold mb-3">{{ __('Pneus à changer') }} <span class="text-danger">*</span></label>
                                <div id="tires_container">
                                    <p class="text-muted">{{ __('Sélectionnez un véhicule pour voir les pneus disponibles') }}</p>
                                </div>
                                @error('tire_ids')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                @error('tire_ids.*')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                @error('tire_thresholds')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                @error('tire_thresholds.*')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
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
                            <!-- <div class="form-group">
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
                            </div> -->

                            {{-- Documents Section in Main Form --}}
                            <div class="card mt-3 mb-3">
                                <div class="card-header bg-secondary text-white">
                                    <h5 class="mb-0"><i class="fas fa-file-upload mr-2"></i>{{ __('Documents supplémentaires') }}</h5>
                                </div>
                                <div class="card-body">
                                    {{-- Voucher (Bon) Upload --}}
                                    <div class="form-group">
                                        <label class="font-weight-semibold">{{ __('Bon') }} ({{ __('Voucher') }})</label>
                                        <input type="file" class="form-control-file" name="voucher_files[]" id="voucher_files" multiple accept="image/*,.pdf,.doc,.docx">
                                        <small class="form-text text-muted">{{ __('Vous pouvez sélectionner plusieurs fichiers. Taille maximum: 50MB par fichier') }}</small>
                                        @error('voucher_files.*')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Invoice (Facture) Upload --}}
                                    <div class="form-group">
                                        <label class="font-weight-semibold">{{ __('Facture') }} ({{ __('Invoice') }})</label>
                                        <input type="file" class="form-control-file" name="invoice_files[]" id="invoice_files" multiple accept="image/*,.pdf,.doc,.docx">
                                        <small class="form-text text-muted">{{ __('Vous pouvez sélectionner plusieurs fichiers. Taille maximum: 50MB par fichier') }}</small>
                                        @error('invoice_files.*')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Vignette Upload --}}
                                    <div class="form-group">
                                        <label class="font-weight-semibold">{{ __('Vignette') }}</label>
                                        <input type="file" class="form-control-file" name="vignette_files[]" id="vignette_files" multiple accept="image/*,.pdf,.doc,.docx">
                                        <small class="form-text text-muted">{{ __('Vous pouvez sélectionner plusieurs fichiers. Taille maximum: 50MB par fichier') }}</small>
                                        @error('vignette_files.*')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Other Documents Upload --}}
                                    <div class="form-group">
                                        <label class="font-weight-semibold">{{ __('Autres Documents') }} ({{ __('Other Documents') }})</label>
                                        <input type="file" class="form-control-file" name="other_files[]" id="other_files" multiple accept="image/*,.pdf,.doc,.docx">
                                        <small class="form-text text-muted">{{ __('Vous pouvez sélectionner plusieurs fichiers. Taille maximum: 50MB par fichier') }}</small>
                                        @error('other_files.*')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
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
                // Calculate fuel amount if values exist
                setTimeout(calculateFuelAmount, 100);
            } else {
                const fuelLitersElement = document.getElementById('fuel_liters');
                if (fuelLitersElement) fuelLitersElement.required = false;
            }

            if (category === 'rechange_pneu') {
                if (tireGroup) tireGroup.style.display = 'block';
                // Load tires via AJAX if vehicle is already selected
                const vehiculeId = document.getElementById('vehicule_id').value;
                if (vehiculeId) {
                    loadVehicleTires(vehiculeId);
                }
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

        function enforceIntegerAmount() {
            const amountInput = document.getElementById('amount');
            if (!amountInput) return;
            const val = parseFloat(amountInput.value.toString().replace(/[, ]/g, '.')) || 0;
            amountInput.value = Math.round(val);
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

        function loadVehicleTires(vehiculeId) {
            const tiresContainer = document.getElementById('tires_container');
            if (!vehiculeId) {
                if (tiresContainer) {
                    tiresContainer.innerHTML = '<p class="text-muted">{{ __("Sélectionnez un véhicule pour voir les pneus disponibles") }}</p>';
                }
                return;
            }
            
            // Use AJAX to fetch tires for the selected vehicle
            fetch("{{ route('admin.payment_voucher.get_vehicle_tires', '') }}/" + vehiculeId, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (tiresContainer && data.success && data.tires && data.tires.length > 0) {
                    // Clear existing content
                    tiresContainer.innerHTML = '';
                    
                    // Create checkboxes for each tire with threshold input
                    data.tires.forEach((tire, index) => {
                        const tireCard = document.createElement('div');
                        tireCard.className = 'card mb-2';
                        const nouveauSeuilLabel = '{{ __("Nouveau seuil (KM)") }}';
                        const entrerSeuilPlaceholder = '{{ __("Entrer le nouveau seuil") }}';
                        const seuilActuelLabel = '{{ __("Seuil actuel") }}';
                        tireCard.innerHTML = `
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-4">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" 
                                                   class="custom-control-input tire-checkbox" 
                                                   id="tire_checkbox_${tire.id}" 
                                                   name="tire_ids[]" 
                                                   value="${tire.id}"
                                                   data-tire-id="${tire.id}"
                                                   data-default-threshold="${tire.threshold_km}"
                                                   onchange="toggleTireThreshold(${tire.id})">
                                            <label class="custom-control-label" for="tire_checkbox_${tire.id}">
                                                <strong>${tire.position}</strong>
                                                <small class="text-muted d-block">Seuil actuel: ${tire.threshold_km.toLocaleString('fr-FR')} KM</small>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group mb-0 tire-threshold-group" id="tire_threshold_group_${tire.id}" style="display: none;">
                                            <label for="tire_threshold_${tire.id}">${nouveauSeuilLabel} <span class="text-danger">*</span></label>
                                            <input type="number" 
                                                   class="form-control tire-threshold-input" 
                                                   id="tire_threshold_${tire.id}" 
                                                   name="tire_thresholds[${tire.id}]" 
                                                   value="${tire.threshold_km}"
                                                   step="1"
                                                   min="1"
                                                   placeholder="${entrerSeuilPlaceholder}">
                                            <small class="form-text text-muted">${seuilActuelLabel}: ${tire.threshold_km.toLocaleString('fr-FR')} KM</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                        tiresContainer.appendChild(tireCard);
                    });
                } else if (tiresContainer) {
                    tiresContainer.innerHTML = '<div class="alert alert-warning"><i class="fas fa-exclamation-triangle"></i> {{ __("Aucun pneu disponible pour ce véhicule") }}</div>';
                }
            })
            .catch(error => {
                console.error('Error loading vehicle tires:', error);
                if (tiresContainer) {
                    tiresContainer.innerHTML = '<div class="alert alert-danger"><i class="fas fa-times-circle"></i> {{ __("Erreur lors du chargement des pneus") }}</div>';
                }
            });
        }

        function toggleTireThreshold(tireId) {
            const checkbox = document.getElementById('tire_checkbox_' + tireId);
            const thresholdGroup = document.getElementById('tire_threshold_group_' + tireId);
            const thresholdInput = document.getElementById('tire_threshold_' + tireId);
            
            if (checkbox && thresholdGroup && thresholdInput) {
                if (checkbox.checked) {
                    thresholdGroup.style.display = 'block';
                    thresholdInput.required = true;
                    // Set default value if empty
                    if (!thresholdInput.value) {
                        thresholdInput.value = checkbox.getAttribute('data-default-threshold');
                    }
                } else {
                    thresholdGroup.style.display = 'none';
                    thresholdInput.required = false;
                    thresholdInput.value = checkbox.getAttribute('data-default-threshold');
                }
            }
        }

        function handleVehiculeChange() {
            const vehiculeId = document.getElementById('vehicule_id').value;
            const category = document.getElementById('category').value;
            
            // Load tires via AJAX for rechange_pneu category
            if (category === 'rechange_pneu' && vehiculeId) {
                loadVehicleTires(vehiculeId);
            } else if (category === 'rechange_pneu') {
                // Clear tires if no vehicle selected
                const tireSelect = document.getElementById('tire_id');
                if (tireSelect) {
                    tireSelect.innerHTML = '<option value="">{{ __("Sélectionner un pneu") }}</option>';
                }
            } else if (category === 'entretien' && vehiculeId) {
                // For entretien, we can also use AJAX if needed, but it's commented out in the view
                // For now, keep the redirect behavior or implement AJAX similarly
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

            // Calculate fuel amount if category is carburant and values exist
            if (category === 'carburant') {
                setTimeout(calculateFuelAmount, 200);
            }

            // Load tires if category is rechange_pneu and vehicle is already selected
            if (category === 'rechange_pneu') {
                const vehiculeId = document.getElementById('vehicule_id').value;
                if (vehiculeId) {
                    loadVehicleTires(vehiculeId);
                }
            }

            // Validate tire selection on form submit
            const voucherForm = document.getElementById('voucherForm');
            if (voucherForm) {
                voucherForm.addEventListener('submit', function(e) {
                    const category = document.getElementById('category').value;
                    if (category === 'rechange_pneu') {
                        const checkedTires = document.querySelectorAll('.tire-checkbox:checked');
                        if (checkedTires.length === 0) {
                            e.preventDefault();
                            alert('{{ __("Veuillez sélectionner au moins un pneu à changer") }}');
                            return false;
                        }
                        
                        // Validate that all selected tires have thresholds
                        let allValid = true;
                        checkedTires.forEach(checkbox => {
                            const tireId = checkbox.getAttribute('data-tire-id');
                            const thresholdInput = document.getElementById('tire_threshold_' + tireId);
                            if (thresholdInput && (!thresholdInput.value || thresholdInput.value <= 0)) {
                                allValid = false;
                                thresholdInput.classList.add('is-invalid');
                            } else if (thresholdInput) {
                                thresholdInput.classList.remove('is-invalid');
                            }
                        });
                        
                        if (!allValid) {
                            e.preventDefault();
                            alert('{{ __("Veuillez entrer un seuil valide pour tous les pneus sélectionnés") }}');
                            return false;
                        }
                    }
                });
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

            // Initialize denominations calculation
            updateTotal();
        });

        // Calculate total from denominations
        function updateTotal() {
            const denominations = [20, 50, 100, 200, 300, 400, 500];
            let total = 0;
            
            denominations.forEach(denom => {
                const input = document.getElementById('denomination_' + denom);
                if (input) {
                    const quantity = parseInt(input.value) || 0;
                    total += denom * quantity;
                }
            });
            
            const totalElement = document.getElementById('calculated_total');
            if (totalElement) {
                totalElement.textContent = total.toLocaleString('fr-FR');
            }
            
            // Update amount field if it's empty or user wants to sync
            const amountField = document.getElementById('amount');
            if (amountField && !amountField.value) {
                amountField.value = total;
            }
        }

        // Calculate denominations from total amount
        function calculateDenominations() {
            const amountField = document.getElementById('amount');
            if (!amountField) return;
            
            let amount = parseFloat(amountField.value) || 0;
            if (amount <= 0) {
                // Clear all denominations
                [20, 50, 100, 200, 300, 400, 500].forEach(denom => {
                    const input = document.getElementById('denomination_' + denom);
                    if (input) input.value = 0;
                });
                updateTotal();
                return;
            }
            
            // Calculate denominations (greedy algorithm)
            const denominations = [500, 400, 300, 200, 100, 50, 20];
            const result = {};
            let remaining = amount;
            
            denominations.forEach(denom => {
                const count = Math.floor(remaining / denom);
                result[denom] = count;
                remaining = remaining % denom;
            });
            
            // Update input fields
            Object.keys(result).forEach(denom => {
                const input = document.getElementById('denomination_' + denom);
                if (input) {
                    input.value = result[denom];
                }
            });
            
            updateTotal();
        }

        // Track which field triggered the calculation
        let lastEditedField = null;

        // Calculate fuel amount or liters based on what's entered
        function calculateFuelAmount(triggeredBy = null) {
            const fuelLitersInput = document.getElementById('fuel_liters');
            const pricePerLiterInput = document.getElementById('price_per_liter');
            const amountInput = document.getElementById('amount');
            const calculationInfo = document.getElementById('fuel_calculation_info');
            const calculatedAmountSpan = document.getElementById('calculated_fuel_amount');
            
            if (!fuelLitersInput || !pricePerLiterInput || !amountInput) {
                return;
            }
            
            // Track which field was last edited
            if (triggeredBy) {
                lastEditedField = triggeredBy;
            }
            
            // Get values and clean them (remove spaces, commas)
            let fuelLiters = fuelLitersInput.value.toString().replace(/[\s,]/g, '').replace(',', '.');
            let pricePerLiter = pricePerLiterInput.value.toString().replace(/[\s,]/g, '').replace(',', '.');
            let amount = amountInput.value.toString().replace(/[\s,]/g, '').replace(',', '.');
            
            // Convert to numbers
            fuelLiters = parseFloat(fuelLiters) || 0;
            pricePerLiter = parseFloat(pricePerLiter) || 0;
            amount = parseFloat(amount) || 0;
            // Always enforce integer amount
            amount = Math.round(amount);
            amountInput.value = amount || '';
            
            // Need price per liter for any calculation
            if (pricePerLiter <= 0) {
                if (calculationInfo) {
                    calculationInfo.style.display = 'none';
                }
                return;
            }
            
            // Case 1: If Amount and Price per Liter are entered, calculate Liters
            // (Only if amount was just edited, or liters is empty)
            if (lastEditedField === 'amount' && amount > 0 && pricePerLiter > 0) {
                const calculatedLiters = amount / pricePerLiter;
                fuelLitersInput.value = calculatedLiters.toFixed(2);
                
                // Show calculation info
                if (calculationInfo) {
                    calculationInfo.style.display = 'block';
                }
                if (calculatedAmountSpan) {
                    calculatedAmountSpan.textContent = calculatedLiters.toFixed(2) + ' {{ __("litres") }}';
                }
            }
            // Case 2: If Liters and Price per Liter are entered, calculate Amount
            // (Only if liters was just edited, or amount is empty/zero)
            else if (lastEditedField === 'fuel_liters' && fuelLiters > 0 && pricePerLiter > 0) {
                const calculatedAmount = fuelLiters * pricePerLiter;
                amountInput.value = Math.round(calculatedAmount);
                
                // Show calculation info
                if (calculationInfo) {
                    calculationInfo.style.display = 'block';
                }
                if (calculatedAmountSpan) {
                    calculatedAmountSpan.textContent = Math.round(calculatedAmount) + ' {{ __("MAD") }}';
                }
                
                // Trigger denominations calculation
                calculateDenominations();
            }
            // Case 3: If price per liter was edited, calculate based on what's available
            else if (lastEditedField === 'price_per_liter' && pricePerLiter > 0) {
                if (fuelLiters > 0) {
                    // Calculate amount from liters
                    const calculatedAmount = fuelLiters * pricePerLiter;
                    amountInput.value = Math.round(calculatedAmount);
                    
                    if (calculationInfo) {
                        calculationInfo.style.display = 'block';
                    }
                    if (calculatedAmountSpan) {
                        calculatedAmountSpan.textContent = calculatedAmount.toFixed(2) + ' {{ __("MAD") }}';
                    }
                    calculateDenominations();
                } else if (amount > 0) {
                    // Calculate liters from amount
                    const calculatedLiters = amount / pricePerLiter;
                    fuelLitersInput.value = calculatedLiters.toFixed(2);
                    
                    if (calculationInfo) {
                        calculationInfo.style.display = 'block';
                    }
                    if (calculatedAmountSpan) {
                        calculatedAmountSpan.textContent = calculatedLiters.toFixed(2) + ' {{ __("litres") }}';
                    }
                }
            } else {
                // Hide calculation info if values are not valid
                if (calculationInfo) {
                    calculationInfo.style.display = 'none';
                }
            }
        }
    </script>
</x-admin.app>

