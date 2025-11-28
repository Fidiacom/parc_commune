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
                                <select name="vehicule_id" id="vehicule_id" class="form-control @error('vehicule_id') is-invalid @enderror" required>
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
                                <input type="text" name="vehicle_km" class="form-control @error('vehicle_km') is-invalid @enderror" 
                                       value="{{ old('vehicle_km', number_format($voucher->getVehicleKm(), 0, '', '')) }}" required>
                                @error('vehicle_km')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Vehicle Hours -->
                            <div class="form-group">
                                <label class="font-weight-semibold">{{ __('Heures du véhicule') }}</label>
                                <input type="text" name="vehicle_hours" class="form-control @error('vehicle_hours') is-invalid @enderror" 
                                       value="{{ old('vehicle_hours', $voucher->getVehicleHours() ? number_format($voucher->getVehicleHours(), 0, '', '') : '') }}" 
                                       placeholder="{{ __('Entrer les heures') }}">
                                @error('vehicle_hours')
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
                                <label class="font-weight-semibold">{{ __('Date de facture') }} <span class="text-danger">*</span></label>
                                <input type="date" name="invoice_date" class="form-control @error('invoice_date') is-invalid @enderror" 
                                       value="{{ old('invoice_date', $voucher->getInvoiceDate()) }}" required>
                                @error('invoice_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Amount -->
                            <div class="form-group">
                                <label class="font-weight-semibold">{{ __('Montant') }} <span class="text-danger">*</span></label>
                                <input type="text" name="amount" class="form-control @error('amount') is-invalid @enderror" 
                                       value="{{ old('amount', number_format($voucher->getAmount(), 2, '.', '')) }}" required>
                                @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Fuel Liters (for carburant) -->
                            <div class="form-group" id="fuel_liters_group" style="display: {{ $voucher->getCategory() === 'carburant' ? 'block' : 'none' }};">
                                <label class="font-weight-semibold">{{ __('Litres de carburant') }} <span class="text-danger">*</span></label>
                                <input type="text" name="fuel_liters" id="fuel_liters" class="form-control @error('fuel_liters') is-invalid @enderror" 
                                       value="{{ old('fuel_liters', $voucher->getFuelLiters() ? number_format($voucher->getFuelLiters(), 2, '.', '') : '') }}">
                                @error('fuel_liters')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tire Selection (for rechange_pneu) -->
                            <div class="form-group" id="tire_group" style="display: {{ $voucher->getCategory() === 'rechange_pneu' ? 'block' : 'none' }};">
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
                            <div class="form-group" id="maintenance_group" style="display: {{ $voucher->getCategory() === 'entretien' ? 'block' : 'none' }};">
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
                            </div>

                            <!-- Supplier -->
                            <div class="form-group">
                                <label class="font-weight-semibold">{{ __('Fournisseur') }}</label>
                                <input type="text" name="supplier" class="form-control @error('supplier') is-invalid @enderror" 
                                       value="{{ old('supplier', $voucher->getSupplier()) }}">
                                @error('supplier')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Insurance Expiration Date -->
                            <div class="form-group">
                                <label class="font-weight-semibold">{{ __('Date d\'expiration de l\'assurance') }}</label>
                                <input type="date" name="insurance_expiration_date" class="form-control @error('insurance_expiration_date') is-invalid @enderror" 
                                       value="{{ old('insurance_expiration_date', $voucher->getInsuranceExpirationDate()) }}">
                                @error('insurance_expiration_date')
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
                            <div class="form-group">
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
            </div>
        </div>
    </div>

    <script>
        function handleCategoryChange() {
            const category = document.getElementById('category').value;
            const fuelGroup = document.getElementById('fuel_liters_group');
            const tireGroup = document.getElementById('tire_group');
            const maintenanceGroup = document.getElementById('maintenance_group');

            // Hide all groups
            fuelGroup.style.display = 'none';
            tireGroup.style.display = 'none';
            maintenanceGroup.style.display = 'none';

            // Show relevant group
            if (category === 'carburant') {
                fuelGroup.style.display = 'block';
                document.getElementById('fuel_liters').required = true;
            } else {
                document.getElementById('fuel_liters').required = false;
            }

            if (category === 'rechange_pneu') {
                tireGroup.style.display = 'block';
                document.getElementById('tire_id').required = true;
            } else {
                document.getElementById('tire_id').required = false;
            }

            if (category === 'entretien') {
                maintenanceGroup.style.display = 'block';
            }
        }

        function toggleMaintenanceFields() {
            const vidangeCheck = document.getElementById('maintenance_vidange');
            const timingCheck = document.getElementById('maintenance_timing');
            const vidangeGroup = document.getElementById('vidange_group');
            const timingGroup = document.getElementById('timing_chaine_group');

            if (vidangeCheck && vidangeCheck.checked) {
                vidangeGroup.style.display = 'block';
            } else {
                vidangeGroup.style.display = 'none';
                document.getElementById('vidange_id').value = '';
            }

            if (timingCheck && timingCheck.checked) {
                timingGroup.style.display = 'block';
            } else {
                timingGroup.style.display = 'none';
                document.getElementById('timing_chaine_id').value = '';
            }
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            handleCategoryChange();
            toggleMaintenanceFields();

            // File input label update
            document.getElementById('document').addEventListener('change', function(e) {
                const fileName = e.target.files[0]?.name || '{{ __('Choisir un fichier') }}';
                e.target.nextElementSibling.textContent = fileName;
            });
        });
    </script>
</x-admin.app>

