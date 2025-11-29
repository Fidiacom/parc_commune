<x-admin.app>

    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="mb-1 font-size-18">
                            <i class="fas fa-car mr-2 text-primary"></i>{{ __('Ajout d\'un nouveau véhicule') }}
                        </h4>
                        <p class="text-muted mb-0">{{ __('Remplissez les informations ci-dessous pour ajouter un nouveau véhicule au parc') }}</p>
                    </div>
                    <a href="{{ route('admin.vehicule') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left mr-2"></i>{{ __('Retour') }}
                    </a>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-8 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <!-- Step Indicators -->
                        <div class="wizard mb-4">
                            <div class="wizard-steps">
                                <div class="wizard-step active" id="step-indicator-1">
                                    <div class="wizard-step-icon">
                                        <i class="fas fa-car"></i>
                                    </div>
                                    <div class="wizard-step-label">
                                        <h6 class="mb-0">{{ __('Informations véhicule') }}</h6>
                                        <small class="text-muted">{{ __('Données principales') }}</small>
                                    </div>
                                </div>
                                <div class="wizard-step-line"></div>
                                <div class="wizard-step" id="step-indicator-2">
                                    <div class="wizard-step-icon">
                                        <i class="fas fa-circle-notch"></i>
                                    </div>
                                    <div class="wizard-step-label">
                                        <h6 class="mb-0">{{ __('Informations pneus') }}</h6>
                                        <small class="text-muted">{{ __('Configuration pneus') }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Progress Bar -->
                        <div class="progress mb-4" style="height: 4px;">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 50%" id="progressBar"></div>
                        </div>

                        <form action="{{ route('admin.vehicule.store') }}" method="POST" enctype="multipart/form-data" id="vehiculeForm">
                            @csrf
                            
                            {{-- Display Validation Errors --}}
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
                            
                            {{-- Frontend Validation Error Display --}}
                            <div id="frontendErrors" class="alert alert-danger" style="display: none;" role="alert">
                                <h5 class="alert-heading"><i class="fas fa-exclamation-triangle"></i> {{ __('Veuillez corriger les erreurs suivantes:') }}</h5>
                                <ul id="frontendErrorsList" class="mb-0"></ul>
                            </div>
                            
                            <div class="tab-content" id="stepTabsContent">
                                <!-- Step 1: Vehicle Information -->
                                <div class="tab-pane fade show active" id="step1" role="tabpanel" aria-labelledby="step1-tab">
                            
                            <!-- Section: Images -->
                            <div class="card border mb-4">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">
                                        <i class="fas fa-images text-primary mr-2"></i>{{ __('Images du véhicule') }}
                                    </h5>
                                                </div>
                                <div class="card-body">
                                    <div class="form-group mb-0">
                                        <label class="mb-2 font-weight-semibold">{{ __('Télécharger des images') }}</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="images[]" id="vehicleImages" multiple accept="image/*"/>
                                            <label class="custom-file-label" for="vehicleImages">
                                                <i class="fas fa-cloud-upload-alt mr-2"></i>{{ __('Choisir des images (max 50MB par image)') }}
                                            </label>
                                            </div>
                                        <small class="form-text text-muted mt-2">
                                            <i class="fas fa-info-circle mr-1"></i>{{ __('Vous pouvez sélectionner plusieurs images. La première image sera utilisée comme image principale.') }}
                                        </small>
                                        <div id="imagePreview" class="mt-3" style="display: flex; flex-wrap: wrap; gap: 10px;"></div>
                                        </div>

                                @error('images')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                                @error('images.*')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                                </div>
                            </div>

                            <!-- Section: Informations générales -->
                            <div class="card border mb-4">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">
                                        <i class="fas fa-info-circle text-primary mr-2"></i>{{ __('Informations générales') }}
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                            <div class="form-group">
                                                <label for="simpleinput">
                                                    <i class="fas fa-tag mr-1 text-muted"></i>{{ __('Marque') }} <span class="text-danger">*</span>
                                                </label>
                                <input
                                    type="text"
                                    id="simpleinput"
                                    class="form-control @error('brand') is-invalid @enderror"
                                    name="brand"
                                                    placeholder="Ex: Dacia, Peugeot, Renault..."
                                                    value="{{ old('brand') }}"
                                                    required>
                                @error('brand')
                                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                                        </div>
                                        <div class="col-md-6">
                            <div class="form-group">
                                                <label for="example-password">
                                                    <i class="fas fa-car-side mr-1 text-muted"></i>{{ __('Modèle') }} <span class="text-danger">*</span>
                                                </label>
                                <input
                                    type="text"
                                    id="example-password"
                                                    class="form-control @error('model') is-invalid @enderror"
                                    name="model"
                                                    placeholder="Ex: Logan, 208, Clio..."
                                                    value="{{ old('model') }}"
                                                    required>
                                @error('model')
                                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                            <div class="form-group">
                                                <label for="exampleFormControlInput1">
                                                    <i class="fas fa-id-card mr-1 text-muted"></i>{{ __('Matricule') }} <span class="text-danger">*</span>
                                                </label>
                                <input
                                    type="text"
                                                    class="form-control @error('matricule') is-invalid @enderror"
                                    id="exampleFormControlInput1"
                                    name="matricule"
                                                    placeholder="Ex: 12345-A-67"
                                                    value="{{ old('matricule') }}"
                                                    required>
                                @error('matricule')
                                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                                        </div>
                                        <div class="col-md-6">
                            <div class="form-group">
                                                <label for="chassis">
                                                    <i class="fas fa-barcode mr-1 text-muted"></i>{{ __('Numéro de châssis') }}
                                                </label>
                                <input
                                    type="text"
                                                    class="form-control @error('chassis') is-invalid @enderror"
                                                    id="chassis"
                                    name="chassis"
                                                    placeholder="Numéro VIN (optionnel)"
                                                    value="{{ old('chassis') }}">
                                @error('chassis')
                                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                            <div class="form-group">
                                                <label for="inputPassword2">
                                                    <i class="fas fa-calendar-alt mr-1 text-muted"></i>{{ __('Date de mise en circulation') }}
                                                </label>
                                <input
                                    type="date"
                                    value="{{ old('circulation_date') }}"
                                                    class="form-control @error('circulation_date') is-invalid @enderror"
                                                    id="inputPassword2"
                                    name="circulation_date">
                                @error('circulation_date')
                                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="category">
                                                    <i class="fas fa-id-badge mr-1 text-muted"></i>{{ __('Catégorie de permis') }} <span class="text-danger">*</span>
                                                </label>
                                                <select name="category" class="form-control @error('category') is-invalid @enderror" required>
                                                    <option value="0">{{ __('Sélectionner une catégorie') }}</option>
                                                    @foreach ($categories as $c)
                                                    <option value="{{ $c->id }}" @selected($c->id == old('category'))>{{ $c->label }}</option>
                                                    @endforeach
                                                </select>
                                                @error('category')
                                                <div class="invalid-feedback d-block">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Section: Kilométrage et performances -->
                            <div class="card border mb-4">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">
                                        <i class="fas fa-tachometer-alt text-primary mr-2"></i>{{ __('Kilométrage et performances') }}
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                            <div class="form-group">
                                                <label for="km_actuel">
                                                    <i class="fas fa-road mr-1 text-muted"></i>{{ __('Kilométrage actuel') }} <span class="text-danger">*</span>
                                                </label>
                                <input
                                    type="text"
                                    value="{{ old('km_actuel') }}"
                                    class="form-control autonumber @error('km_actuel') is-invalid @enderror"
                                    name="km_actuel"
                                            id="km_actuel"
                                    data-a-sep="."
                                                    data-a-dec=","
                                                    required>
                                @error('km_actuel')
                                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                                        </div>
                                        <div class="col-md-4">
                            <div class="form-group">
                                                <label for="total_hours">
                                                    <i class="fas fa-clock mr-1 text-muted"></i>{{ __('Heures totales') }}
                                                </label>
                                                <input
                                                    type="text"
                                                    value="{{ old('total_hours') }}"
                                                    class="form-control autonumber @error('total_hours') is-invalid @enderror"
                                                    name="total_hours"
                                                    id="total_hours"
                                                    placeholder="{{ __('Optionnel') }}"
                                                    data-a-sep="."
                                                    data-a-dec=",">
                                                <small class="form-text text-muted">{{ __('Pour véhicules fonctionnant aux heures') }}</small>
                                                @error('total_hours')
                                                <div class="invalid-feedback d-block">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="horses">
                                                    <i class="fas fa-horse mr-1 text-muted"></i>{{ __('Puissance (CV)') }} <span class="text-danger">*</span>
                                                </label>
                                <input
                                    type="text"
                                    value="{{ old('horses') }}"
                                    class="form-control autonumber @error('horses') is-invalid @enderror"
                                    name="horses"
                                                    id="horses"
                                    data-a-sep="."
                                                    data-a-dec=","
                                                    required>
                                @error('horses')
                                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Section: Carburant et consommation -->
                            <div class="card border mb-4">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">
                                        <i class="fas fa-gas-pump text-primary mr-2"></i>{{ __('Carburant et consommation') }}
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                            <div class="form-group">
                                                <label for="fuel_type">
                                                    <i class="fas fa-fill-drip mr-1 text-muted"></i>{{ __('Type de carburant') }} <span class="text-danger">*</span>
                                                </label>
                                                <select name="fuel_type" id="fuel_type" class="form-control @error('fuel_type') is-invalid @enderror" required>
                                                    <option value="0">{{ __('Sélectionner le type de carburant') }}</option>
                                                    <option value="Gasoline" @selected(old('fuel_type') == 'Gasoline')>
                                                        <i class="fas fa-gas-pump"></i> {{ __('Essence') }}
                                                    </option>
                                                    <option value="Diesel" @selected(old('fuel_type') == 'Diesel')>
                                                        <i class="fas fa-oil-can"></i> {{ __('Diesel') }}
                                                    </option>
                                                    <option value="Eletric" @selected(old('fuel_type') == 'Eletric')>
                                                        <i class="fas fa-charging-station"></i> {{ __('Électrique') }}
                                                    </option>
                                </select>
                                                @error('fuel_type')
                                                <div class="invalid-feedback d-block">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="min_fuel_consumption_100km">
                                                    <i class="fas fa-arrow-down mr-1 text-muted"></i>{{ __('Consommation min (L/100km)') }}
                                                </label>
                                                <input
                                                    type="number"
                                                    step="0.01"
                                                    value="{{ old('min_fuel_consumption_100km') }}"
                                                    class="form-control @error('min_fuel_consumption_100km') is-invalid @enderror"
                                                    name="min_fuel_consumption_100km"
                                                    id="min_fuel_consumption_100km"
                                                    placeholder="Ex: 5.5"
                                                    min="0">
                                                <small class="form-text text-muted">{{ __('Optionnel') }}</small>
                                                @error('min_fuel_consumption_100km')
                                                <div class="invalid-feedback d-block">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="max_fuel_consumption_100km">
                                                    <i class="fas fa-arrow-up mr-1 text-muted"></i>{{ __('Consommation max (L/100km)') }}
                                                </label>
                                                <input
                                                    type="number"
                                                    step="0.01"
                                                    value="{{ old('max_fuel_consumption_100km') }}"
                                                    class="form-control @error('max_fuel_consumption_100km') is-invalid @enderror"
                                                    name="max_fuel_consumption_100km"
                                                    id="max_fuel_consumption_100km"
                                                    placeholder="Ex: 8.5"
                                                    min="0">
                                                <small class="form-text text-muted">{{ __('Optionnel') }}</small>
                                                @error('max_fuel_consumption_100km')
                                                <div class="invalid-feedback d-block">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="min_fuel_consumption_hour">
                                                    <i class="fas fa-arrow-down mr-1 text-muted"></i>{{ __('Consommation min (L/H)') }}
                                                </label>
                                                <input
                                                    type="number"
                                                    step="0.01"
                                                    value="{{ old('min_fuel_consumption_hour') }}"
                                                    class="form-control @error('min_fuel_consumption_hour') is-invalid @enderror"
                                                    name="min_fuel_consumption_hour"
                                                    id="min_fuel_consumption_hour"
                                                    placeholder="Ex: 2.5"
                                                    min="0">
                                                <small class="form-text text-muted">{{ __('Optionnel - Pour véhicules avec compteur d\'heures') }}</small>
                                                @error('min_fuel_consumption_hour')
                                                <div class="invalid-feedback d-block">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="max_fuel_consumption_hour">
                                                    <i class="fas fa-arrow-up mr-1 text-muted"></i>{{ __('Consommation max (L/H)') }}
                                                </label>
                                                <input
                                                    type="number"
                                                    step="0.01"
                                                    value="{{ old('max_fuel_consumption_hour') }}"
                                                    class="form-control @error('max_fuel_consumption_hour') is-invalid @enderror"
                                                    name="max_fuel_consumption_hour"
                                                    id="max_fuel_consumption_hour"
                                                    placeholder="Ex: 4.5"
                                                    min="0">
                                                <small class="form-text text-muted">{{ __('Optionnel - Pour véhicules avec compteur d\'heures') }}</small>
                                                @error('max_fuel_consumption_hour')
                                                <div class="invalid-feedback d-block">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Section: Sécurité et équipements -->
                            <div class="card border mb-4">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">
                                        <i class="fas fa-shield-alt text-primary mr-2"></i>{{ __('Sécurité et équipements') }}
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-group mb-0">
                                        <label class="mb-3">{{ __('Équipements de sécurité') }}</label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="custom-control custom-checkbox mb-2">
                                    <input type="checkbox" class="custom-control-input" id="customCheck5" checked @checked(old('airbag') == 'on') name="airbag">
                                                    <label class="custom-control-label" for="customCheck5">
                                                        <i class="fas fa-shield-alt text-success mr-2"></i>{{ __('Airbag') }}
                                                    </label>
                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="custom-control custom-checkbox mb-2">
                                    <input type="checkbox" class="custom-control-input" id="customCheck6" checked @checked(old('abs') == 'on') name="abs">
                                                    <label class="custom-control-label" for="customCheck6">
                                                        <i class="fas fa-car-crash text-info mr-2"></i>{{ __('Système ABS') }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Section: Maintenance -->
                            <div class="card border mb-4">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">
                                        <i class="fas fa-cogs text-primary mr-2"></i>{{ __('Maintenance') }}
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                            <div class="form-group">
                                                <label for="threshold_vidange">
                                                    <i class="fas fa-oil-can mr-1 text-muted"></i>{{ __('Seuil KM vidange') }} <span class="text-danger">*</span>
                                                </label>
                                <input
                                    type="text"
                                                    placeholder="Ex: 10000"
                                    value="{{ old('threshold_vidange') }}"
                                    class="form-control autonumber @error('threshold_vidange') is-invalid @enderror"
                                    name="threshold_vidange"
                                                    id="threshold_vidange"
                                                    data-a-sep="." 
                                                    data-a-dec=","
                                                    required>
                                                <small class="form-text text-muted">{{ __('Kilométrage entre chaque vidange') }}</small>
                                @error('threshold_vidange')
                                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                                        </div>
                                        <div class="col-md-6">
                            <div class="form-group">
                                                <label for="threshold_timing_chaine">
                                                    <i class="fas fa-link mr-1 text-muted"></i>{{ __('Seuil KM chaîne de distribution') }} <span class="text-danger">*</span>
                                                </label>
                                <input
                                    type="text"
                                    value="{{ old('threshold_timing_chaine') }}"
                                    class="form-control autonumber @error('threshold_timing_chaine') is-invalid @enderror"
                                    name="threshold_timing_chaine"
                                                    id="threshold_timing_chaine"
                                    data-a-sep="."
                                                    data-a-dec=","
                                                    required>
                                                <small class="form-text text-muted">{{ __('Kilométrage pour changement de chaîne') }}</small>
                                @error('threshold_timing_chaine')
                                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Section: Documents et assurances -->
                            <div class="card border mb-4">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">
                                        <i class="fas fa-file-contract text-primary mr-2"></i>{{ __('Documents et assurances') }}
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                            <div class="form-group">
                                                <label for="inssurance_expiration">
                                                    <i class="fas fa-shield-alt mr-1 text-muted"></i>{{ __('Date d\'expiration assurance') }} <span class="text-danger">*</span>
                                                </label>
                                <input
                                    type="date"
                                    value="{{ old('inssurance_expiration') }}"
                                                    class="form-control @error('inssurance_expiration') is-invalid @enderror"
                                                    id="inssurance_expiration"
                                                    name="inssurance_expiration"
                                                    required>
                                @error('inssurance_expiration')
                                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                                        </div>
                                        <div class="col-md-6">
                            <div class="form-group">
                                                <label for="technical_visit_expiration">
                                                    <i class="fas fa-clipboard-check mr-1 text-muted"></i>{{ __('Date d\'expiration visite technique') }}
                                                </label>
                                <input
                                    type="date"
                                    value="{{ old('technical_visit_expiration') }}"
                                    class="form-control @error('technical_visit_expiration') is-invalid @enderror"
                                                    id="technical_visit_expiration"
                                    name="technical_visit_expiration">
                                @error('technical_visit_expiration')
                                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Section: Pneus -->
                            <div class="card border mb-4">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">
                                        <i class="fas fa-circle-notch text-primary mr-2"></i>{{ __('Configuration des pneus') }}
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                            <div class="form-group">
                                                <label for="numOfTires">
                                                    <i class="fas fa-circle-notch mr-1 text-muted"></i>{{ __('Nombre de pneus') }} <span class="text-danger">*</span>
                                                </label>
                                <input
                                    type="number"
                                                    class="form-control @error('numOfTires') is-invalid @enderror"
                                    name="numOfTires"
                                            id="numOfTires"
                                            value="{{ old('numOfTires', 4) }}"
                                            min="1"
                                                    max="20"
                                                    required>
                                @error('numOfTires')
                                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                                        </div>
                                        <div class="col-md-6">
                            <div class="form-group">
                                                <label for="tireSize">
                                                    <i class="fas fa-ruler mr-1 text-muted"></i>{{ __('Taille des pneus') }}
                                                </label>
                                <input
                                    type="text"
                                    class="form-control @error('tire_size') is-invalid @enderror"
                                    id="tireSize"
                                    name="tire_size"
                                                    placeholder="Ex: 205/55R16"
                                    value="{{ old('tire_size') }}">
                                                <small class="form-text text-muted">{{ __('Format: 205/55R16') }}</small>
                                @error('tire_size')
                                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Section: Documents -->
                            <div class="card border mb-4">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">
                                        <i class="fas fa-file-alt text-primary mr-2"></i>{{ __('Documents et fichiers') }}
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-group mb-0">
                                        <label class="mb-2 font-weight-semibold">{{ __('Télécharger des fichiers') }}</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="files[]" id="fileInput" multiple accept="image/*,.pdf,.doc,.docx">
                                            <label class="custom-file-label" for="fileInput">
                                                <i class="fas fa-cloud-upload-alt mr-2"></i>{{ __('Choisir des fichiers (PDF, images, documents)') }}
                                            </label>
                                        </div>
                                        <small class="form-text text-muted mt-2">
                                            <i class="fas fa-info-circle mr-1"></i>{{ __('Vous pouvez télécharger plusieurs fichiers. Taille maximum: 50MB par fichier.') }}
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <!-- Navigation Buttons -->
                            <div class="form-group mt-4 d-flex justify-content-between">
                                <a href="{{ route('admin.vehicule') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times mr-2"></i>{{ __('Annuler') }}
                                </a>
                                <button type="button" class="btn btn-primary waves-effect waves-light" id="nextToStep2">
                                    {{ __('Suivant: Informations des pneus') }}
                                    <i class="fas fa-arrow-right ml-2"></i>
                                </button>
                            </div>
                                </div>

                                <!-- Step 2: Tire Information -->
                                <div class="tab-pane fade" id="step2" role="tabpanel" aria-labelledby="step2-tab">
                                    <div class="card border mb-4">
                                        <div class="card-header bg-light">
                                            <h5 class="mb-0">
                                                <i class="fas fa-circle-notch text-primary mr-2"></i>{{ __('Configuration détaillée des pneus') }}
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div id="tireFieldsContainer">
                                                <!-- Tire fields will be dynamically generated here -->
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mt-4 d-flex justify-content-between">
                                        <button type="button" class="btn btn-outline-secondary waves-effect waves-light" id="backToStep1">
                                            <i class="fas fa-arrow-left mr-2"></i>{{ __('Précédent') }}
                                        </button>
                                        <button type="submit" class="btn btn-primary waves-effect waves-light" id="submitForm">
                                            <i class="fas fa-save mr-2"></i>{{ __('Enregistrer le véhicule') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- end card-body-->
                </div>
                <!-- end card -->
            </div> <!-- end col -->
        </div>
        <!-- end row-->
    </div> <!-- container-fluid -->

    <script>
        // Pass old values from PHP to JavaScript
        const oldTirePositions = @json(old('tire_positions', []));
        const oldTireThresholds = @json(old('tire_thresholds', []));
        const oldTireNextKMs = @json(old('tire_nextKMs', []));
    </script>

    <style>
        /* Wizard Styles */
        .wizard {
            margin-bottom: 2rem;
        }
        .wizard-steps {
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }
        .wizard-step {
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 1;
            position: relative;
        }
        .wizard-step-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: #e9ecef;
            color: #6c757d;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            margin-bottom: 0.5rem;
            transition: all 0.3s ease;
        }
        .wizard-step.active .wizard-step-icon {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }
        .wizard-step.completed .wizard-step-icon {
            background: #28a745;
            color: white;
        }
        .wizard-step-label {
            text-align: center;
        }
        .wizard-step-label h6 {
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }
        .wizard-step-label small {
            font-size: 0.75rem;
        }
        .wizard-step-line {
            flex: 1;
            height: 2px;
            background: #e9ecef;
            margin: 0 1rem;
            margin-top: -25px;
            position: relative;
        }
        .wizard-step.active ~ .wizard-step-line,
        .wizard-step.completed ~ .wizard-step-line {
            background: #28a745;
        }
        
        /* Form Section Cards */
        .card.border {
            border: 1px solid #e9ecef !important;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .card-header.bg-light {
            background-color: #f8f9fa !important;
            border-bottom: 1px solid #e9ecef;
        }
        .card-header h5 {
            color: #495057;
        }
        
        /* Custom File Input */
        .custom-file-label::after {
            content: "Parcourir";
        }
        
        /* Better form spacing */
        .form-group label {
            font-weight: 500;
            color: #495057;
            margin-bottom: 0.5rem;
        }
        .form-group label i {
            width: 18px;
        }
        
        /* Image Preview */
        #imagePreview img {
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        /* Progress Bar */
        .progress {
            border-radius: 10px;
            overflow: hidden;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Update progress bar and step indicators
            function updateProgress(step) {
                const progressBar = document.getElementById('progressBar');
                const step1Indicator = document.getElementById('step-indicator-1');
                const step2Indicator = document.getElementById('step-indicator-2');
                
                if (step === 1) {
                    progressBar.style.width = '50%';
                    step1Indicator.classList.add('active');
                    step1Indicator.classList.remove('completed');
                    step2Indicator.classList.remove('active', 'completed');
                } else if (step === 2) {
                    progressBar.style.width = '100%';
                    step1Indicator.classList.remove('active');
                    step1Indicator.classList.add('completed');
                    step2Indicator.classList.add('active');
                }
            }
            
            // Initialize progress
            updateProgress(1);
            // Image preview functionality
            const fileInput = document.getElementById('vehicleImages');
            if (fileInput) {
                fileInput.addEventListener('change', function(e) {
                    const preview = document.getElementById('imagePreview');
                    preview.innerHTML = '';
                    
                    if (this.files && this.files.length > 0) {
                        Array.from(this.files).forEach((file) => {
                            if (file.type.startsWith('image/')) {
                                const reader = new FileReader();
                                reader.onload = function(e) {
                                    const div = document.createElement('div');
                                    div.style.cssText = 'position: relative; display: inline-block; margin: 5px;';
                                    
                                    const img = document.createElement('img');
                                    img.src = e.target.result;
                                    img.className = 'img-thumbnail';
                                    img.style.cssText = 'max-width: 150px; max-height: 150px; object-fit: cover;';
                                    
                                    const removeBtn = document.createElement('button');
                                    removeBtn.type = 'button';
                                    removeBtn.className = 'btn btn-sm btn-danger';
                                    removeBtn.style.cssText = 'position: absolute; top: 5px; right: 5px; padding: 2px 6px; font-size: 10px;';
                                    removeBtn.innerHTML = '<i class="fas fa-times"></i>';
                                    removeBtn.onclick = function() {
                                        div.remove();
                                    };
                                    
                                    div.appendChild(img);
                                    div.appendChild(removeBtn);
                                    preview.appendChild(div);
                                };
                                reader.readAsDataURL(file);
                            }
                        });
                    }
                });
            }

            // Step navigation
            const numOfTiresInput = document.getElementById('numOfTires');
            const tireFieldsContainer = document.getElementById('tireFieldsContainer');
            const nextToStep2Btn = document.getElementById('nextToStep2');
            const backToStep1Btn = document.getElementById('backToStep1');
            const kmActuelInput = document.getElementById('km_actuel');

            // Generate tire fields based on number of tires
            function generateTireFields() {
                const numOfTires = parseInt(numOfTiresInput.value) || 4;
                tireFieldsContainer.innerHTML = '';

                for (let i = 0; i < numOfTires; i++) {
                    const tireIndex = i + 1;
                    const oldPosition = oldTirePositions[i] || tireIndex;
                    const oldThreshold = oldTireThresholds[i] || '';
                    const oldNextKM = oldTireNextKMs[i] || '';
                    
                    const tireCard = document.createElement('div');
                    tireCard.className = 'card mb-3';
                    tireCard.innerHTML = `
                        <div class="card-header">
                            <h5 class="mb-0">{{ __('Pneu') }} ${tireIndex}</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="tire_position_${i}">{{ __('Position du pneu') }}</label>
                                <input 
                                    type="text" 
                                    id="tire_position_${i}" 
                                    class="form-control" 
                                    name="tire_positions[]" 
                                    placeholder="{{ __('Ex: Avant Gauche, Avant Droit, Arrière Gauche, Arrière Droit') }}"
                                    value="${oldPosition}"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="tire_threshold_${i}">{{ __('Seuil km') }}</label>
                                <input 
                                    type="text" 
                                    id="tire_threshold_${i}" 
                                    class="form-control autonumber" 
                                    name="tire_thresholds[]" 
                                    data-a-sep="." 
                                    data-a-dec=","
                                    placeholder=""
                                    value="${oldThreshold}"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="tire_nextKM_${i}">{{ __('Prochain km pour changement') }}</label>
                                <input 
                                    type="text" 
                                    id="tire_nextKM_${i}" 
                                    class="form-control autonumber" 
                                    name="tire_nextKMs[]" 
                                    data-a-sep="." 
                                    data-a-dec=","
                                    placeholder=""
                                    value="${oldNextKM}"
                                    required>
                            </div>
                        </div>
                    `;
                    tireFieldsContainer.appendChild(tireCard);
                }

                // Reinitialize autonumber for new fields
                if (typeof AutoNumeric !== 'undefined') {
                    document.querySelectorAll('#tireFieldsContainer .autonumber').forEach(function(el) {
                        new AutoNumeric(el, {
                            digitGroupSeparator: '.',
                            decimalCharacter: ','
                        });
                    });
                }
            }

            // Generate tire fields on page load
            generateTireFields();

            // Regenerate tire fields when number of tires changes
            numOfTiresInput.addEventListener('change', generateTireFields);
            numOfTiresInput.addEventListener('input', generateTireFields);

            // Navigate to step 2
            if (nextToStep2Btn) {
                nextToStep2Btn.addEventListener('click', function() {
                    // Validate step 1 required fields
                    const step1RequiredFields = document.querySelectorAll('#step1 [required]');
                    let isValid = true;
                    
                    step1RequiredFields.forEach(function(field) {
                        if (!field.value || (field.type === 'select-one' && field.value === '0')) {
                            isValid = false;
                            field.classList.add('is-invalid');
                        } else {
                            field.classList.remove('is-invalid');
                        }
                    });

                    if (isValid) {
                        // Clear any previous validation errors
                        document.getElementById('frontendErrors').style.display = 'none';
                        // Switch to step 2
                        const step1 = document.getElementById('step1');
                        const step2 = document.getElementById('step2');
                        if (step1 && step2) {
                            step1.classList.remove('show', 'active');
                            step2.classList.add('show', 'active');
                        }
                        updateProgress(2);
                        generateTireFields(); // Regenerate in case numOfTires changed
                    } else {
                        // Show error display
                        const errorDisplay = document.getElementById('frontendErrors');
                        const errorList = document.getElementById('frontendErrorsList');
                        errorList.innerHTML = '<li>{{ __("Veuillez remplir tous les champs obligatoires de l'étape 1") }}</li>';
                        errorDisplay.style.display = 'block';
                        errorDisplay.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                });
            }

            // Navigate back to step 1
            if (backToStep1Btn) {
                backToStep1Btn.addEventListener('click', function() {
                    // Clear validation errors
                    document.querySelectorAll('.is-invalid').forEach(el => {
                        el.classList.remove('is-invalid');
                    });
                    document.getElementById('frontendErrors').style.display = 'none';
                    // Switch to step 1
                    const step1 = document.getElementById('step1');
                    const step2 = document.getElementById('step2');
                    if (step1 && step2) {
                        step2.classList.remove('show', 'active');
                        step1.classList.add('show', 'active');
                    }
                    updateProgress(1);
                });
            }
            
            // Update file input labels
            const fileInputs = document.querySelectorAll('.custom-file-input');
            fileInputs.forEach(input => {
                input.addEventListener('change', function(e) {
                    const label = this.nextElementSibling;
                    if (this.files && this.files.length > 0) {
                        if (this.files.length === 1) {
                            label.textContent = this.files[0].name;
                        } else {
                            label.textContent = this.files.length + ' fichiers sélectionnés';
                        }
                    } else {
                        label.textContent = label.getAttribute('data-original-text') || 'Choisir un fichier';
                    }
                });
            });

            // Auto-calculate next KM for change based on current KM + threshold
            tireFieldsContainer.addEventListener('input', function(e) {
                if (e.target.name === 'tire_thresholds[]') {
                    const index = Array.from(document.querySelectorAll('input[name="tire_thresholds[]"]')).indexOf(e.target);
                    const threshold = parseFloat(e.target.value.replace(/\./g, '').replace(',', '.')) || 0;
                    const currentKm = parseFloat(kmActuelInput.value.replace(/\./g, '').replace(',', '.')) || 0;
                    const nextKmInput = document.querySelectorAll('input[name="tire_nextKMs[]"]')[index];
                    
                    if (nextKmInput && currentKm > 0) {
                        const nextKm = currentKm + threshold;
                        nextKmInput.value = nextKm.toLocaleString('fr-FR').replace(/,/g, '.');
                    }
                }
            });

            // Frontend form validation before submission
            const form = document.getElementById('vehiculeForm');
            const submitBtn = document.getElementById('submitForm');
            
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                let isValid = true;
                const errors = [];
                
                // Clear previous error states
                document.querySelectorAll('.is-invalid').forEach(el => {
                    el.classList.remove('is-invalid');
                });
                
                // Validate Step 1 fields
                const brand = document.querySelector('input[name="brand"]');
                if (!brand.value.trim()) {
                    brand.classList.add('is-invalid');
                    errors.push('{{ __("La marque est requise") }}');
                    isValid = false;
                }
                
                const model = document.querySelector('input[name="model"]');
                if (!model.value.trim()) {
                    model.classList.add('is-invalid');
                    errors.push('{{ __("Le modèle est requis") }}');
                    isValid = false;
                }
                
                const matricule = document.querySelector('input[name="matricule"]');
                if (!matricule.value.trim()) {
                    matricule.classList.add('is-invalid');
                    errors.push('{{ __("Le matricule est requis") }}');
                    isValid = false;
                }
                
                const kmActuel = document.querySelector('input[name="km_actuel"]');
                if (!kmActuel.value.trim()) {
                    kmActuel.classList.add('is-invalid');
                    errors.push('{{ __("Le kilométrage actuel est requis") }}');
                    isValid = false;
                }
                
                const horses = document.querySelector('input[name="horses"]');
                if (!horses.value.trim()) {
                    horses.classList.add('is-invalid');
                    errors.push('{{ __("La puissance fiscale est requise") }}');
                    isValid = false;
                }
                
                const fuelType = document.querySelector('select[name="fuel_type"]');
                if (!fuelType.value || fuelType.value === '0') {
                    fuelType.classList.add('is-invalid');
                    errors.push('{{ __("Le type de carburant est requis") }}');
                    isValid = false;
                }
                
                const category = document.querySelector('select[name="category"]');
                if (!category.value || category.value === '0') {
                    category.classList.add('is-invalid');
                    errors.push('{{ __("La catégorie est requise") }}');
                    isValid = false;
                }
                
                const thresholdVidange = document.querySelector('input[name="threshold_vidange"]');
                if (!thresholdVidange.value.trim()) {
                    thresholdVidange.classList.add('is-invalid');
                    errors.push('{{ __("Le seuil de vidange est requis") }}');
                    isValid = false;
                }
                
                const thresholdTimingChaine = document.querySelector('input[name="threshold_timing_chaine"]');
                if (!thresholdTimingChaine.value.trim()) {
                    thresholdTimingChaine.classList.add('is-invalid');
                    errors.push('{{ __("Le seuil de chaîne de distribution est requis") }}');
                    isValid = false;
                }
                
                const inssuranceExpiration = document.querySelector('input[name="inssurance_expiration"]');
                if (!inssuranceExpiration.value) {
                    inssuranceExpiration.classList.add('is-invalid');
                    errors.push('{{ __("La date d'expiration de l'assurance est requise") }}');
                    isValid = false;
                }
                
                const numOfTires = document.querySelector('input[name="numOfTires"]');
                if (!numOfTires.value || parseInt(numOfTires.value) < 1) {
                    numOfTires.classList.add('is-invalid');
                    errors.push('{{ __("Le nombre de pneus est requis et doit être d'au moins 1") }}');
                    isValid = false;
                }
                
                // Validate Step 2 (Tire fields)
                const tirePositions = document.querySelectorAll('input[name="tire_positions[]"]');
                const tireThresholds = document.querySelectorAll('input[name="tire_thresholds[]"]');
                const tireNextKMs = document.querySelectorAll('input[name="tire_nextKMs[]"]');
                
                if (tirePositions.length !== parseInt(numOfTires.value)) {
                    errors.push('{{ __("Le nombre d'entrées de pneus doit correspondre au nombre de pneus") }}');
                    isValid = false;
                }
                
                tirePositions.forEach((field, index) => {
                    if (!field.value.trim()) {
                        field.classList.add('is-invalid');
                        errors.push(`{{ __("Position du pneu") }} ${index + 1} {{ __("est requise") }}`);
                        isValid = false;
                    }
                });
                
                tireThresholds.forEach((field, index) => {
                    if (!field.value.trim()) {
                        field.classList.add('is-invalid');
                        errors.push(`{{ __("Seuil du pneu") }} ${index + 1} {{ __("est requis") }}`);
                        isValid = false;
                    }
                });
                
                tireNextKMs.forEach((field, index) => {
                    if (!field.value.trim()) {
                        field.classList.add('is-invalid');
                        errors.push(`{{ __("Prochain KM du pneu") }} ${index + 1} {{ __("est requis") }}`);
                        isValid = false;
                    }
                });
                
                // Validate file sizes
                const imageInput = document.getElementById('vehicleImages');
                if (imageInput && imageInput.files.length > 0) {
                    Array.from(imageInput.files).forEach((file, index) => {
                        if (file.size > 50 * 1024 * 1024) { // 50MB
                            errors.push(`{{ __("Image") }} ${index + 1} {{ __("dépasse la limite de 50MB") }}`);
                            isValid = false;
                        }
                    });
                }
                
                const fileInput = document.getElementById('fileInput');
                if (fileInput && fileInput.files.length > 0) {
                    Array.from(fileInput.files).forEach((file, index) => {
                        if (file.size > 50 * 1024 * 1024) { // 50MB
                            errors.push(`{{ __("Fichier") }} ${index + 1} {{ __("dépasse la limite de 50MB") }}`);
                            isValid = false;
                        }
                    });
                }
                
                // Display errors or submit
                if (!isValid) {
                    // Show error display
                    const errorDisplay = document.getElementById('frontendErrors');
                    const errorList = document.getElementById('frontendErrorsList');
                    errorList.innerHTML = '';
                    
                    // Remove duplicates
                    const uniqueErrors = [...new Set(errors)];
                    uniqueErrors.forEach((error) => {
                        const li = document.createElement('li');
                        li.textContent = error;
                        errorList.appendChild(li);
                    });
                    
                    errorDisplay.style.display = 'block';
                    
                    // Scroll to error display
                    errorDisplay.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    
                    // Scroll to first error field after a short delay
                    setTimeout(() => {
                        const firstError = document.querySelector('.is-invalid');
                        if (firstError) {
                            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }
                    }, 300);
                    
                    return false;
                } else {
                    // Hide error display if validation passes
                    document.getElementById('frontendErrors').style.display = 'none';
                }
                
                // If validation passes, submit the form
                form.submit();
            });
        });
    </script>
</x-admin.app>
