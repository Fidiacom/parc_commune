<x-admin.app>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="mb-1 font-size-18">
                            <i class="mdi mdi-pencil mr-2 text-primary"></i>{{ __('Modifier le bon de paiement') }}
                        </h4>
                        <p class="text-muted mb-0">{{ __('Modifiez les informations du bon de paiement') }}</p>
                    </div>
                    <a href="{{ route('admin.payment_voucher.show', $voucher->getId()) }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left mr-2"></i>{{ __('Retour') }}
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-10 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.payment_voucher.update', $voucher->getId()) }}" method="POST" enctype="multipart/form-data" id="voucherForm">
                            @csrf
                            @method('PUT')

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

                                    <option value="{{ $key }}" {{ old('category', $voucher->getCategory()) === $key ? 'selected' : '' }}>{{ $label }}</option>
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
                                    <option value="{{ $v->getId() }}" {{ old('vehicule_id', $voucher->getVehiculeId()) == $v->getId() ? 'selected' : '' }}>
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
                                       value="{{ old('vehicle_km', number_format($voucher->getVehicleKm(), 0, '', '')) }}" required placeholder="{{ __('Entrer le kilométrage') }}">
                                @error('vehicle_km')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Vehicle Hours -->
                            <div class="form-group">
                                <label class="font-weight-semibold">{{ __('Heures du véhicule') }}</label>
                                <input type="text" name="vehicle_hours" id="vehicle_hours" class="form-control @error('vehicle_hours') is-invalid @enderror" 
                                       value="{{ old('vehicle_hours', $voucher->getVehicleHours() ? number_format($voucher->getVehicleHours(), 0, '', '') : '') }}" 
                                       placeholder="{{ __('Entrer les heures (pour véhicules avec compteur d\'heures)') }}">
                                @error('vehicle_hours')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Voucher Number -->
                            <div class="form-group">
                                <label class="font-weight-semibold">{{ __('Numéro de bon') }}</label>
                                <input type="text" name="voucher_number" class="form-control @error('voucher_number') is-invalid @enderror" 
                                       value="{{ old('voucher_number', $voucher->getVoucherNumber()) }}" placeholder="{{ __('Laisser vide pour générer automatiquement') }}">
                                @error('voucher_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Voucher Date -->
                            <div class="form-group">
                                <label class="font-weight-semibold">{{ __('Date du bon') }}</label>
                                <input type="date" name="voucher_date" class="form-control @error('voucher_date') is-invalid @enderror" 
                                       value="{{ old('voucher_date', $voucher->getVoucherDate() ?? $voucher->getInvoiceDate()) }}">
                                @error('voucher_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Invoice Number -->
                            <div class="form-group">
                                <label class="font-weight-semibold">{{ __('Numéro de facture') }}</label>
                                <input type="text" name="invoice_number" class="form-control @error('invoice_number') is-invalid @enderror" 
                                       value="{{ old('invoice_number', $voucher->getInvoiceNumber()) }}">
                                @error('invoice_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Invoice Date -->
                            <div class="form-group">
                                <label class="font-weight-semibold">{{ __('Date de facture') }}</label>
                                <input type="date" name="invoice_date" class="form-control @error('invoice_date') is-invalid @enderror" 
                                       value="{{ old('invoice_date', $voucher->getInvoiceDate()) }}">
                                @error('invoice_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Amount -->
                            <div class="form-group">
                                <label class="font-weight-semibold">{{ __('Montant') }} <span class="text-danger">*</span></label>
                                <input type="text" name="amount" id="amount" class="form-control @error('amount') is-invalid @enderror" 
                                       value="{{ old('amount', number_format($voucher->getAmount(), 2, '.', '')) }}" required 
                                       placeholder="{{ __('Montant en DH') }}"
                                       onchange="calculateDenominations(); calculateFuelAmount('amount');" onkeyup="calculateDenominations(); calculateFuelAmount('amount');">
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
                                    @php
                                        $denominations = $voucher->getDenominations() ?: [];
                                    @endphp
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="font-weight-semibold">{{ __('20 DH') }}</label>
                                            <input type="number" name="denominations[20]" id="denomination_20" class="form-control" 
                                                   value="{{ old('denominations.20', $denominations[20] ?? 0) }}" min="0" onchange="updateTotal()" onkeyup="updateTotal()">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="font-weight-semibold">{{ __('50 DH') }}</label>
                                            <input type="number" name="denominations[50]" id="denomination_50" class="form-control" 
                                                   value="{{ old('denominations.50', $denominations[50] ?? 0) }}" min="0" onchange="updateTotal()" onkeyup="updateTotal()">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="font-weight-semibold">{{ __('100 DH') }}</label>
                                            <input type="number" name="denominations[100]" id="denomination_100" class="form-control" 
                                                   value="{{ old('denominations.100', $denominations[100] ?? 0) }}" min="0" onchange="updateTotal()" onkeyup="updateTotal()">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="font-weight-semibold">{{ __('200 DH') }}</label>
                                            <input type="number" name="denominations[200]" id="denomination_200" class="form-control" 
                                                   value="{{ old('denominations.200', $denominations[200] ?? 0) }}" min="0" onchange="updateTotal()" onkeyup="updateTotal()">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="font-weight-semibold">{{ __('300 DH') }}</label>
                                            <input type="number" name="denominations[300]" id="denomination_300" class="form-control" 
                                                   value="{{ old('denominations.300', $denominations[300] ?? 0) }}" min="0" onchange="updateTotal()" onkeyup="updateTotal()">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="font-weight-semibold">{{ __('400 DH') }}</label>
                                            <input type="number" name="denominations[400]" id="denomination_400" class="form-control" 
                                                   value="{{ old('denominations.400', $denominations[400] ?? 0) }}" min="0" onchange="updateTotal()" onkeyup="updateTotal()">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="font-weight-semibold">{{ __('500 DH') }}</label>
                                            <input type="number" name="denominations[500]" id="denomination_500" class="form-control" 
                                                   value="{{ old('denominations.500', $denominations[500] ?? 0) }}" min="0" onchange="updateTotal()" onkeyup="updateTotal()">
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
                                <input type="text" name="fuel_liters" id="fuel_liters" class="form-control @error('fuel_liters') is-invalid @enderror" 
                                               value="{{ old('fuel_liters', $voucher->getFuelLiters() ? number_format($voucher->getFuelLiters(), 2, '.', '') : '') }}" 
                                               placeholder="{{ __('Quantité en litres') }}"
                                               onchange="calculateFuelAmount('fuel_liters')" onkeyup="calculateFuelAmount('fuel_liters')">
                                @error('fuel_liters')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="font-weight-semibold">{{ __('Prix par litre (DH)') }}</label>
                                        @php
                                            $pricePerLiter = '';
                                            if ($voucher->getFuelLiters() && $voucher->getFuelLiters() > 0 && $voucher->getAmount() > 0) {
                                                $pricePerLiter = number_format($voucher->getAmount() / $voucher->getFuelLiters(), 2, '.', '');
                                            }
                                        @endphp
                                        <input type="text" name="price_per_liter" id="price_per_liter" class="form-control" 
                                               value="{{ old('price_per_liter', $pricePerLiter) }}" placeholder="{{ __('Prix par litre') }}"
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
                                <label class="font-weight-semibold">{{ __('Pneu à changer') }} <span class="text-danger">*</span></label>
                                <select name="tire_id" id="tire_id" class="form-control @error('tire_id') is-invalid @enderror">
                                    <option value="">{{ __('Sélectionner un pneu') }}</option>
                                    @if($selectedVehicule && $tires)
                                        @foreach($tires as $tire)
                                        <option value="{{ $tire->getId() }}" {{ old('tire_id', $voucher->getTireId()) == $tire->getId() ? 'selected' : '' }}>
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
                                    <input class="form-check-input" type="checkbox" name="maintenance_type[]" value="vidange" id="maintenance_vidange" 
                                           {{ $voucher->getVidangeId() ? 'checked' : '' }} onchange="toggleMaintenanceFields()">
                                    <label class="form-check-label" for="maintenance_vidange">
                                        {{ __('Vidange') }}
                                    </label>
                                </div>
                                <div class="form-group ml-4" id="vidange_group" style="display: {{ $voucher->getVidangeId() ? 'block' : 'none' }};">
                                    <select name="vidange_id" id="vidange_id" class="form-control">
                                        <option value="">{{ __('Sélectionner') }}</option>
                                        @foreach($vidanges as $vidange)
                                        <option value="{{ $vidange->getId() }}" {{ old('vidange_id', $voucher->getVidangeId()) == $vidange->getId() ? 'selected' : '' }}>
                                            {{ __('Vidange') }} (Seuil: {{ number_format($vidange->getThresholdKm(), 0, ',', ' ') }} KM)
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif

                                @if(count($timingChaines) > 0)
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="maintenance_type[]" value="timing_chaine" id="maintenance_timing" 
                                           {{ $voucher->getTimingChaineId() ? 'checked' : '' }} onchange="toggleMaintenanceFields()">
                                    <label class="form-check-label" for="maintenance_timing">
                                        {{ __('Chaîne de distribution') }}
                                    </label>
                                </div>
                                <div class="form-group ml-4" id="timing_chaine_group" style="display: {{ $voucher->getTimingChaineId() ? 'block' : 'none' }};">
                                    <select name="timing_chaine_id" id="timing_chaine_id" class="form-control">
                                        <option value="">{{ __('Sélectionner') }}</option>
                                        @foreach($timingChaines as $timingChaine)
                                        <option value="{{ $timingChaine->getId() }}" {{ old('timing_chaine_id', $voucher->getTimingChaineId()) == $timingChaine->getId() ? 'selected' : '' }}>
                                            {{ __('Chaîne de distribution') }} (Seuil: {{ number_format($timingChaine->getThresholdKm(), 0, ',', ' ') }} KM)
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                            </div> -->

                            <!-- Supplier -->
                            <div class="form-group">
                                <label class="font-weight-semibold">{{ __('Fournisseur') }}</label>
                                <input type="text" name="supplier" class="form-control @error('supplier') is-invalid @enderror" 
                                       value="{{ old('supplier', $voucher->getSupplier()) }}">
                                @error('supplier')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Insurance Expiration Date (only for insurance category) -->
                            <div class="form-group" id="insurance_expiration_group" style="display: none;">
                                <label class="font-weight-semibold">{{ __('Date d\'expiration de l\'assurance') }} <span class="text-danger">*</span></label>
                                <input type="date" name="insurance_expiration_date" id="insurance_expiration_date" class="form-control @error('insurance_expiration_date') is-invalid @enderror" 
                                       value="{{ old('insurance_expiration_date', $voucher->getInsuranceExpirationDate() ?? '') }}">
                                @error('insurance_expiration_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Technical Visit Expiration Date (only for visite_technique category) -->
                            <div class="form-group" id="technical_visit_expiration_group" style="display: none;">
                                <label class="font-weight-semibold">{{ __('Date d\'expiration visite technique') }} <span class="text-danger">*</span></label>
                                <input type="date" name="technical_visit_expiration_date" id="technical_visit_expiration_date" class="form-control @error('technical_visit_expiration_date') is-invalid @enderror" 
                                       value="{{ old('technical_visit_expiration_date', $voucher->getTechnicalVisitExpirationDate() ?? '') }}">
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
                                          rows="3">{{ old('additional_info', $voucher->getAdditionalInfo()) }}</textarea>
                                @error('additional_info')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Document Upload -->
                            <!-- <div class="form-group">
                                <label class="font-weight-semibold">{{ __('Document (Bon ou Facture)') }}</label>
                                @if($voucher->getDocumentPath())
                                <div class="mb-2">
                                    <a href="{{ asset($voucher->getDocumentPath()) }}" target="_blank" class="btn btn-sm btn-info">
                                        <i class="mdi mdi-eye mr-1"></i>{{ __('Voir le document actuel') }}
                                    </a>
                                </div>
                                @endif
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="document" id="document" accept="image/*,application/pdf">
                                    <label class="custom-file-label" for="document">
                                        <i class="fas fa-cloud-upload-alt mr-2"></i>{{ __('Choisir un nouveau fichier (Image ou PDF, max 50MB)') }}
                                    </label>
                                </div>
                                <small class="form-text text-muted">{{ __('Laissez vide pour conserver le document actuel') }}</small>
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
                                    <i class="fas fa-save mr-2"></i>{{ __('Enregistrer les modifications') }}
                                </button>
                                <a href="{{ route('admin.payment_voucher.show', $voucher->getId()) }}" class="btn btn-secondary waves-effect waves-light ml-2">
                                    {{ __('Annuler') }}
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Existing Documents Section (for viewing/deleting) --}}
                <div class="card mt-3">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0"><i class="fas fa-file-upload mr-2"></i>{{ __('Documents') }}</h5>
                    </div>
                    <div class="card-body">
                        {{-- Voucher (Bon) Upload --}}
                        <div class="card mb-3">
                            <div class="card-header bg-info text-white">
                                <h6 class="mb-0">{{ __('Bon') }} ({{ __('Voucher') }})</h6>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.payment_voucher.attachments.add') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="payment_voucher_id" value="{{ $voucher->getId() }}">
                                    <input type="hidden" name="document_type" value="voucher">
                                    <div class="form-group">
                                        <input type="file" class="form-control-file" name="files[]" multiple accept="image/*,.pdf,.doc,.docx">
                                        <small class="form-text text-muted">{{ __('Vous pouvez sélectionner plusieurs fichiers. Taille maximum: 50MB par fichier') }}</small>
                                    </div>
                                    <button type="submit" class="btn btn-sm btn-info waves-effect waves-light">
                                        <i class="fas fa-upload"></i> {{ __('Télécharger') }}
                                    </button>
                                </form>
                                @if($voucher->attachments)
                                    @php
                                        $vouchers = $voucher->attachments->where('document_type', 'voucher');
                                    @endphp
                                    @if($vouchers->count() > 0)
                                        <div class="mt-3">
                                            <h6>{{ __('Fichiers téléchargés') }}:</h6>
                                            <ul class="list-group">
                                                @foreach($vouchers as $attachment)
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        <a href="{{ asset($attachment->getFilePath()) }}" target="_blank">
                                                            <i class="fas fa-file"></i> {{ $attachment->getFileName() ?: __('Fichier') }}
                                                        </a>
                                                        <form action="{{ route('admin.payment_voucher.attachments.delete', $attachment->getId()) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('{{ __('Êtes-vous sûr de vouloir supprimer ce fichier?') }}')">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>

                        {{-- Invoice (Facture) Upload --}}
                        <div class="card mb-3">
                            <div class="card-header bg-success text-white">
                                <h6 class="mb-0">{{ __('Facture') }} ({{ __('Invoice') }})</h6>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.payment_voucher.attachments.add') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="payment_voucher_id" value="{{ $voucher->getId() }}">
                                    <input type="hidden" name="document_type" value="invoice">
                                    <div class="form-group">
                                        <input type="file" class="form-control-file" name="files[]" multiple accept="image/*,.pdf,.doc,.docx">
                                        <small class="form-text text-muted">{{ __('Vous pouvez sélectionner plusieurs fichiers. Taille maximum: 50MB par fichier') }}</small>
                                    </div>
                                    <button type="submit" class="btn btn-sm btn-success waves-effect waves-light">
                                        <i class="fas fa-upload"></i> {{ __('Télécharger') }}
                                    </button>
                                </form>
                                @if($voucher->attachments)
                                    @php
                                        $invoices = $voucher->attachments->where('document_type', 'invoice');
                                    @endphp
                                    @if($invoices->count() > 0)
                                        <div class="mt-3">
                                            <h6>{{ __('Fichiers téléchargés') }}:</h6>
                                            <ul class="list-group">
                                                @foreach($invoices as $attachment)
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        <a href="{{ asset($attachment->getFilePath()) }}" target="_blank">
                                                            <i class="fas fa-file"></i> {{ $attachment->getFileName() ?: __('Fichier') }}
                                                        </a>
                                                        <form action="{{ route('admin.payment_voucher.attachments.delete', $attachment->getId()) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('{{ __('Êtes-vous sûr de vouloir supprimer ce fichier?') }}')">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>

                        {{-- Vignette Upload --}}
                        <div class="card mb-3">
                            <div class="card-header bg-warning text-dark">
                                <h6 class="mb-0">{{ __('Vignette') }}</h6>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.payment_voucher.attachments.add') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="payment_voucher_id" value="{{ $voucher->getId() }}">
                                    <input type="hidden" name="document_type" value="vignette">
                                    <div class="form-group">
                                        <input type="file" class="form-control-file" name="files[]" multiple accept="image/*,.pdf,.doc,.docx">
                                        <small class="form-text text-muted">{{ __('Vous pouvez sélectionner plusieurs fichiers. Taille maximum: 50MB par fichier') }}</small>
                                    </div>
                                    <button type="submit" class="btn btn-sm btn-warning waves-effect waves-light">
                                        <i class="fas fa-upload"></i> {{ __('Télécharger') }}
                                    </button>
                                </form>
                                @if($voucher->attachments)
                                    @php
                                        $vignettes = $voucher->attachments->where('document_type', 'vignette');
                                    @endphp
                                    @if($vignettes->count() > 0)
                                        <div class="mt-3">
                                            <h6>{{ __('Fichiers téléchargés') }}:</h6>
                                            <ul class="list-group">
                                                @foreach($vignettes as $attachment)
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        <a href="{{ asset($attachment->getFilePath()) }}" target="_blank">
                                                            <i class="fas fa-file"></i> {{ $attachment->getFileName() ?: __('Fichier') }}
                                                        </a>
                                                        <form action="{{ route('admin.payment_voucher.attachments.delete', $attachment->getId()) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('{{ __('Êtes-vous sûr de vouloir supprimer ce fichier?') }}')">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>

                        {{-- Other Documents Upload --}}
                        <div class="card mb-3">
                            <div class="card-header bg-primary text-white">
                                <h6 class="mb-0">{{ __('Autres Documents') }} ({{ __('Other Documents') }})</h6>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.payment_voucher.attachments.add') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="payment_voucher_id" value="{{ $voucher->getId() }}">
                                    <input type="hidden" name="document_type" value="other">
                                    <div class="form-group">
                                        <input type="file" class="form-control-file" name="files[]" multiple accept="image/*,.pdf,.doc,.docx">
                                        <small class="form-text text-muted">{{ __('Vous pouvez sélectionner plusieurs fichiers. Taille maximum: 50MB par fichier') }}</small>
                                    </div>
                                    <button type="submit" class="btn btn-sm btn-primary waves-effect waves-light">
                                        <i class="fas fa-upload"></i> {{ __('Télécharger') }}
                                    </button>
                                </form>
                                @if($voucher->attachments)
                                    @php
                                        $others = $voucher->attachments->where('document_type', 'other');
                                    @endphp
                                    @if($others->count() > 0)
                                        <div class="mt-3">
                                            <h6>{{ __('Fichiers téléchargés') }}:</h6>
                                            <ul class="list-group">
                                                @foreach($others as $attachment)
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        <a href="{{ asset($attachment->getFilePath()) }}" target="_blank">
                                                            <i class="fas fa-file"></i> {{ $attachment->getFileName() ?: __('Fichier') }}
                                                        </a>
                                                        <form action="{{ route('admin.payment_voucher.attachments.delete', $attachment->getId()) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('{{ __('Êtes-vous sûr de vouloir supprimer ce fichier?') }}')">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
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
            const additionalInfoElement = document.querySelector('textarea[name="additional_info"]');
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
                    if (insuranceDateElement && !insuranceDateElement.value) {
                        insuranceDateElement.value = data.expiration_date;
                    }
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
                    if (technicalVisitDateElement && !technicalVisitDateElement.value) {
                        technicalVisitDateElement.value = data.expiration_date;
                    }
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
                window.location.href = "{{ route('admin.payment_voucher.edit', $voucher->getId()) }}?vehicule_id=" + vehiculeId;
            } else if (category === 'entretien' && vehiculeId) {
                // Reload page with vehicule selection to load maintenance options
                window.location.href = "{{ route('admin.payment_voucher.edit', $voucher->getId()) }}?vehicule_id=" + vehiculeId;
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
                const vidangeCategoryGroup = document.getElementById('vidange_category_group');
                if (vidangeCategoryGroup) {
                    vidangeCategoryGroup.style.display = 'block';
                    const vidangeThresholdElement = document.getElementById('vidange_threshold_km');
                    if (vidangeThresholdElement) vidangeThresholdElement.required = true;
                }
            }

            // Calculate fuel amount if category is carburant and values exist
            if (category === 'carburant') {
                setTimeout(calculateFuelAmount, 200);
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
                amountInput.value = calculatedAmount.toFixed(2);
                
                // Show calculation info
                if (calculationInfo) {
                    calculationInfo.style.display = 'block';
                }
                if (calculatedAmountSpan) {
                    calculatedAmountSpan.textContent = calculatedAmount.toFixed(2) + ' {{ __("MAD") }}';
                }
                
                // Trigger denominations calculation
                calculateDenominations();
            }
            // Case 3: If price per liter was edited, calculate based on what's available
            else if (lastEditedField === 'price_per_liter' && pricePerLiter > 0) {
                if (fuelLiters > 0) {
                    // Calculate amount from liters
                    const calculatedAmount = fuelLiters * pricePerLiter;
                    amountInput.value = calculatedAmount.toFixed(2);
                    
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

