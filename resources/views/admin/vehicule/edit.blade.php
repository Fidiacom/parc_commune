<x-admin.app>

    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="mb-1 font-size-18">
                            <i class="fas fa-edit mr-2 text-primary"></i>{{ __('Modifier le véhicule') }}
                        </h4>
                        <p class="text-muted mb-0">{{ __('Modifiez les informations du véhicule') }}: <strong>{{ $vehicule->getBrand() }} {{ $vehicule->getModel() }}</strong> - {{ $vehicule->getMatricule() }}</p>
                    </div>
                    <div>
                        <a href="{{ route('admin.vehicule') }}" class="btn btn-outline-secondary mr-2">
                            <i class="fas fa-arrow-left mr-2"></i>{{ __('Retour') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-8 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <!-- Consumption Statistics -->
                        @if(isset($consumptionStats) && $fuelVouchers->count() >= 2)
                        <div class="card border mb-4 {{ $consumptionStats['exceeds_max_consumption'] ? 'border-danger' : '' }}">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">
                                    <i class="fas fa-chart-line text-primary mr-2"></i>{{ __('Statistiques de consommation') }}
                                    @if($consumptionStats['exceeds_max_consumption'])
                                        <span class="badge badge-danger ml-2">
                                            @if($consumptionStats['exceeds_max_consumption_km'] && $consumptionStats['exceeds_max_consumption_hour'])
                                                {{ __('Consommation élevée (KM & H)!') }}
                                            @elseif($consumptionStats['exceeds_max_consumption_km'])
                                                {{ __('Consommation élevée (KM)!') }}
                                            @elseif($consumptionStats['exceeds_max_consumption_hour'])
                                                {{ __('Consommation élevée (H)!') }}
                                            @endif
                                        </span>
                                    @endif
                                    @if($consumptionStats['below_min_consumption_hour'] ?? false)
                                        <span class="badge badge-warning ml-2">{{ __('Consommation faible (H)!') }}</span>
                                    @endif
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <div class="text-center">
                                            <h6 class="text-muted mb-1">{{ __('Consommation moyenne') }}</h6>
                                            <h4 class="mb-0 {{ $consumptionStats['exceeds_max_consumption'] ? 'text-danger' : 'text-success' }}">
                                                {{ $consumptionStats['average_consumption_100km'] ? number_format($consumptionStats['average_consumption_100km'], 2, ',', ' ') : '-' }} L/100km
                                            </h4>
                                            @if($vehicule->getMinFuelConsumption100km() && $vehicule->getMaxFuelConsumption100km())
                                                <small class="text-muted">
                                                    {{ __('Normale') }}: {{ $vehicule->getMinFuelConsumption100km() }} - {{ $vehicule->getMaxFuelConsumption100km() }} L/100km
                                                </small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="text-center">
                                            <h6 class="text-muted mb-1">{{ __('Total carburant') }}</h6>
                                            <h4 class="mb-0 text-info">
                                                {{ number_format($consumptionStats['total_fuel_liters'], 2, ',', ' ') }} L
                                            </h4>
                                            <small class="text-muted">{{ __('Coût total') }}: {{ number_format($consumptionStats['total_fuel_cost'], 2, ',', ' ') }} {{ __('DH') }}</small>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="text-center">
                                            <h6 class="text-muted mb-1">{{ __('Distance parcourue') }}</h6>
                                            <h4 class="mb-0 text-primary">
                                                {{ number_format($consumptionStats['total_km'], 0, ',', ' ') }} {{ __('KM') }}
                                            </h4>
                                            @if($consumptionStats['total_hours'] > 0)
                                                <small class="text-muted">{{ __('Heures') }}: {{ number_format($consumptionStats['total_hours'], 0, ',', ' ') }} H</small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="text-center">
                                            <h6 class="text-muted mb-1">{{ __('Prix moyen/Litre') }}</h6>
                                            <h4 class="mb-0 text-success">
                                                {{ $consumptionStats['average_price_per_liter'] ? number_format($consumptionStats['average_price_per_liter'], 2, ',', ' ') : '-' }} {{ __('DH/L') }}
                                            </h4>
                                            @if($consumptionStats['average_consumption_hour'])
                                                <small class="text-muted {{ ($consumptionStats['exceeds_max_consumption_hour'] ?? false) || ($consumptionStats['below_min_consumption_hour'] ?? false) ? 'text-danger' : '' }}">
                                                    {{ __('Consommation/heure') }}: {{ number_format($consumptionStats['average_consumption_hour'], 2, ',', ' ') }} L/H
                                                    @if($vehicule->getMinFuelConsumptionHour() && $vehicule->getMaxFuelConsumptionHour())
                                                        ({{ __('Normale') }}: {{ $vehicule->getMinFuelConsumptionHour() }} - {{ $vehicule->getMaxFuelConsumptionHour() }} L/H)
                                                    @endif
                                                </small>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @if($consumptionStats['last_fuel_entry'])
                                <div class="mt-3 pt-3 border-top">
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        {{ __('Dernière entrée carburant') }}: 
                                        {{ \Carbon\Carbon::parse($consumptionStats['last_fuel_entry']->getInvoiceDate())->format('d/m/Y') }} 
                                        ({{ number_format($consumptionStats['last_fuel_entry']->getFuelLiters(), 2, ',', ' ') }} L)
                                    </small>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endif

                        <!-- Images Section (Outside main form to avoid nested forms) -->
                        <div class="card border mb-4">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">
                                    <i class="fas fa-images text-primary mr-2"></i>{{ __('Images du véhicule') }}
                                </h5>
                            </div>
                            <div class="card-body">
                                <x-vehicule-images :vehicule="$vehicule" :showUpload="true" />
                            </div>
                        </div>

                        <!-- Attachments Section (Outside main form to avoid nested forms) -->
                        <div class="card border mb-4">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">
                                    <i class="fas fa-file-alt text-primary mr-2"></i>{{ __('Documents et fichiers') }}
                                </h5>
                            </div>
                            <div class="card-body">
                                <x-vehicule-file-attachments :vehicule="$vehicule" :showUpload="true" />
                            </div>
                        </div>

                        <form id="vehiculeEditForm" action="{{ route('admin.vehicule.update', $vehicule->getId()) }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Informations générales -->
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
                                                    value="{{ $vehicule->getBrand() }}"
                                                    placeholder="Dacia/Peugot/..."
                                                    required
                                                >
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
                                                    value="{{ $vehicule->getModel() }}"
                                                    required
                                                >
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
                                                    placeholder=""
                                                    value="{{ $vehicule->getMatricule() }}"
                                                    required
                                                >
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
                                                    value="{{ $vehicule->getNumChassis() }}"
                                                >
                                                @error('chassis')
                                                <div class="invalid-feedback d-block">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Kilométrage et performances -->
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
                                                <label for="inputPassword2">
                                                    <i class="fas fa-calendar-alt mr-1 text-muted"></i>{{ __('Date de mise en circulation') }}
                                                </label>
                                                <input
                                                    type="date"
                                                    class="form-control @error('circulation_date') is-invalid @enderror"
                                                    id="inputPassword2"
                                                    name="circulation_date"
                                                    value="{{ $vehicule->getCirculationDate() }}"
                                                >
                                                @error('circulation_date')
                                                <div class="invalid-feedback d-block">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="km_actuel">
                                                    <i class="fas fa-road mr-1 text-muted"></i>{{ __('Kilométrage actuel') }} <span class="text-danger">*</span>
                                                </label>
                                                <input type="number"
                                                    value="{{ $vehicule->getTotalKm() }}"
                                                    class="form-control @error('km_actuel') is-invalid @enderror"
                                                    name="km_actuel"
                                                    id="km_actuel"
                                                    step="1"
                                                    min="0"
                                                    required
                                                >
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
                                                    type="number"
                                                    value="{{ $vehicule->getTotalHours() }}"
                                                    class="form-control @error('total_hours') is-invalid @enderror"
                                                    name="total_hours"
                                                    id="total_hours"
                                                    placeholder="{{ __('Optionnel') }}"
                                                    step="1"
                                                    min="0"
                                                >
                                                <small class="form-text text-muted">{{ __('Pour véhicules fonctionnant aux heures') }}</small>
                                                @error('total_hours')
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
                                                <label for="horses">
                                                    <i class="fas fa-horse mr-1 text-muted"></i>{{ __('Puissance (CV)') }} <span class="text-danger">*</span>
                                                </label>
                                                <input
                                                    type="number"
                                                    class="form-control @error('horses') is-invalid @enderror"
                                                    name="horses"
                                                    id="horses"
                                                    value="{{ $vehicule->getHorses() }}"
                                                    step="1"
                                                    min="0"
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

                            <!-- Carburant et consommation -->
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
                                                    <option value="Essence" @selected($vehicule->getFuelType() == "Essence")>{{ __('Essence') }}</option>
                                                    <option value="Diesel" @selected($vehicule->getFuelType() == "Diesel")>{{ __('Diesel') }}</option>
                                                    <option value="Eletric" @selected($vehicule->getFuelType() == "Eletric")>{{ __('Électrique') }}</option>
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
                                                    value="{{ $vehicule->getMinFuelConsumption100km() ?? old('min_fuel_consumption_100km') }}"
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
                                                    value="{{ $vehicule->getMaxFuelConsumption100km() ?? old('max_fuel_consumption_100km') }}"
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
                                                    value="{{ $vehicule->getMinFuelConsumptionHour() ?? old('min_fuel_consumption_hour') }}"
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
                                                    value="{{ $vehicule->getMaxFuelConsumptionHour() ?? old('max_fuel_consumption_hour') }}"
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

                            <!-- Sécurité et équipements -->
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
                                                    <input
                                                        type="checkbox"
                                                        class="custom-control-input"
                                                        id="customCheck5"
                                                        @checked($vehicule->getAirbag())
                                                        name="airbag"
                                                    >
                                                    <label class="custom-control-label" for="customCheck5">
                                                        <i class="fas fa-shield-alt text-success mr-2"></i>{{ __('Airbag') }}
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="custom-control custom-checkbox mb-2">
                                                    <input
                                                        type="checkbox"
                                                        class="custom-control-input"
                                                        id="customCheck6"
                                                        @checked($vehicule->getAbs())
                                                        name="abs"
                                                    >
                                                    <label class="custom-control-label" for="customCheck6">
                                                        <i class="fas fa-car-crash text-info mr-2"></i>{{ __('Système ABS') }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <!-- Maintenance -->
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
                                                    <i class="fas fa-oil-can mr-1 text-muted"></i>{{ __('Seuil KM vidange') }}
                                                </label>
                                                <input
                                                    type="number"
                                                    placeholder=""
                                                    class="form-control @error('threshold_vidange') is-invalid @enderror"
                                                    name="threshold_vidange"
                                                    id="threshold_vidange"
                                                    value="{{ $vehicule->getThresholdVidange() ?? '' }}"
                                                    step="1"
                                                    min="0">
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
                                                    <i class="fas fa-link mr-1 text-muted"></i>{{ __('Seuil KM chaîne de distribution') }}
                                                </label>
                                                <input
                                                    type="number"
                                                    value="{{ $vehicule->getThresholdTimingChaine() ?? '' }}"
                                                    class="form-control @error('threshold_timing_chaine') is-invalid @enderror"
                                                    name="threshold_timing_chaine"
                                                    id="threshold_timing_chaine"
                                                    step="1"
                                                    min="0">
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

                            <!-- Documents et assurances -->
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
                                                    class="form-control @error('inssurance_expiration') is-invalid @enderror"
                                                    id="inssurance_expiration"
                                                    name="inssurance_expiration"
                                                    value="{{ $vehicule->getInssuranceExpiration() }}"
                                                    required
                                                >
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
                                                    class="form-control @error('technical_visit_expiration') is-invalid @enderror"
                                                    id="technical_visit_expiration"
                                                    name="technical_visit_expiration"
                                                    value="{{ $vehicule->getTechnicalvisiteExpiration() }}"
                                                >
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

                            <!-- Configuration des pneus -->
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
                                                    value="{{ $vehicule->getNumberOfTires() }}"
                                                    required
                                                >
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
                                                    value="{{ $vehicule->getTireSize() ?? old('tire_size') }}">
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

                            {{-- Tires Information Section --}}
                            <div class="card border mb-4">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">
                                        <i class="fas fa-circle-notch text-primary mr-2"></i>{{ __('Informations détaillées des pneus') }}
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div id="tireFieldsContainer">
                                        @if($vehicule->pneu && $vehicule->pneu->count() > 0)
                                            @foreach($vehicule->pneu as $index => $tire)
                                            @php
                                                // Get the latest historique for this tire
                                                $latestHistorique = $tire->pneu_historique->sortByDesc('created_at')->first();
                                                $nextKmForChange = $latestHistorique ? $latestHistorique->getNextKmForChange() : ($vehicule->getTotalKm() + $tire->getThresholdKm());
                                            @endphp
                                            <div class="card mb-3 tire-card" data-tire-index="{{ $index }}">
                                                <div class="card-header">
                                                    <h5 class="mb-0">{{ __('Pneu') }} {{ $index + 1 }}</h5>
                                                </div>
                                                <div class="card-body">
                                                    <input type="hidden" name="tire_ids[]" value="{{ $tire->getId() }}">
                                                    <div class="form-group">
                                                        <label for="tire_position_{{ $index }}">{{ __('Position du pneu') }}</label>
                                                        <input 
                                                            type="text" 
                                                            id="tire_position_{{ $index }}" 
                                                            class="form-control" 
                                                            name="tire_positions[]" 
                                                            placeholder="{{ __('Ex: Avant Gauche, Avant Droit, Arrière Gauche, Arrière Droit') }}"
                                                            value="{{ old("tire_positions.{$index}", $tire->getTirePosition()) }}"
                                                            required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="tire_threshold_{{ $index }}">{{ __('Seuil km') }}</label>
                                                        <input 
                                                            type="number" 
                                                            id="tire_threshold_{{ $index }}" 
                                                            class="form-control" 
                                                            name="tire_thresholds[]" 
                                                            placeholder=""
                                                            value="{{ old("tire_thresholds.{$index}", $tire->getThresholdKm()) }}"
                                                            step="1"
                                                            min="0"
                                                            required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="tire_nextKM_{{ $index }}">{{ __('Prochain km pour changement') }}</label>
                                                        <input 
                                                            type="number" 
                                                            id="tire_nextKM_{{ $index }}" 
                                                            class="form-control" 
                                                            name="tire_nextKMs[]" 
                                                            placeholder=""
                                                            value="{{ old("tire_nextKMs.{$index}", $nextKmForChange) }}"
                                                            step="1"
                                                            min="0"
                                                            required>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        @else
                                            {{-- Tires will be generated dynamically via JavaScript based on numOfTires --}}
                                            <div class="alert alert-info">
                                                <i class="fas fa-info-circle"></i> {{ __('Les champs de pneus seront générés automatiquement selon le nombre de pneus.') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="form-group mt-4 d-flex justify-content-between">
                                <a href="{{ route('admin.vehicule') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times mr-2"></i>{{ __('Annuler') }}
                                </a>
                                <button type="button" id="submitVehiculeForm" class="btn btn-primary waves-effect waves-light" onclick="submitVehiculeEditForm(event)">
                                    <i class="fas fa-save mr-2"></i>{{ __('Enregistrer les modifications') }}
                                </button>
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
        // Global function to submit the form
        function submitVehiculeEditForm(event) {
            event.preventDefault();
            event.stopPropagation();
            console.log('submitVehiculeEditForm called');
            
            const form = document.getElementById('vehiculeEditForm');
            if (!form) {
                console.error('Form not found!');
                alert('Erreur: Formulaire introuvable');
                return false;
            }
            
            // Ensure all number inputs are integers
            const numberInputs = form.querySelectorAll('input[type="number"]');
            numberInputs.forEach(function(field) {
                if (field.value && !isNaN(field.value)) {
                    field.value = Math.floor(parseFloat(field.value)).toString();
                }
            });
            
            // Log all form data before submission
            const formData = new FormData(form);
            console.log('Form data before submission:');
            for (let [key, value] of formData.entries()) {
                console.log(key + ':', value);
            }
            
            // Validate required fields
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;
            const firstInvalidField = [];
            requiredFields.forEach(function(field) {
                const value = field.type === 'checkbox' ? field.checked : field.value;
                if (!value || (field.type === 'select-one' && value === '0')) {
                    isValid = false;
                    field.classList.add('is-invalid');
                    if (firstInvalidField.length === 0) {
                        firstInvalidField.push(field);
                    }
                } else {
                    field.classList.remove('is-invalid');
                }
            });
            
            if (!isValid) {
                alert('Veuillez remplir tous les champs obligatoires');
                if (firstInvalidField.length > 0) {
                    firstInvalidField[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
                    firstInvalidField[0].focus();
                }
                return false;
            }
            
            // Submit the form
            console.log('Submitting form...');
            form.submit();
            return false;
        }
        
        document.addEventListener('DOMContentLoaded', function() {
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

            // Ensure number inputs only accept integers
            document.querySelectorAll('input[type="number"][step="1"]').forEach(function(el) {
                // Prevent decimal input
                el.addEventListener('input', function(e) {
                    if (this.value && this.value.includes('.')) {
                        this.value = Math.floor(parseFloat(this.value)).toString();
                    }
                });
                
                // Clean paste events to ensure integers only
                el.addEventListener('paste', function(e) {
                    e.preventDefault();
                    const paste = (e.clipboardData || window.clipboardData).getData('text');
                    const cleaned = Math.floor(parseFloat(paste.replace(/[^0-9.]/g, '')) || 0);
                    if (cleaned >= 0) {
                        this.value = cleaned.toString();
                    }
                });
            });

            // Tire fields generation
            const numOfTiresInput = document.getElementById('numOfTires');
            const tireFieldsContainer = document.getElementById('tireFieldsContainer');
            const kmActuelInput = document.getElementById('km_actuel');
            
            // Check if tires exist in DB
            const existingTires = tireFieldsContainer.querySelectorAll('.tire-card');
            const hasExistingTires = existingTires.length > 0;
            
            // Pass old values from PHP to JavaScript
            const oldTirePositions = @json(old('tire_positions', []));
            const oldTireThresholds = @json(old('tire_thresholds', []));
            const oldTireNextKMs = @json(old('tire_nextKMs', []));
            
            // Generate tire fields based on number of tires (if no existing tires)
            function generateTireFields() {
                // Only generate if no existing tires in DB
                if (hasExistingTires) {
                    return;
                }
                
                const numOfTires = parseInt(numOfTiresInput.value) || 4;
                tireFieldsContainer.innerHTML = '';

                for (let i = 0; i < numOfTires; i++) {
                    const tireIndex = i + 1;
                    const oldPosition = oldTirePositions[i] || tireIndex;
                    const oldThreshold = oldTireThresholds[i] || '';
                    const oldNextKM = oldTireNextKMs[i] || '';
                    
                    const tireCard = document.createElement('div');
                    tireCard.className = 'card mb-3 tire-card';
                    tireCard.setAttribute('data-tire-index', i);
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
                                    type="number" 
                                    id="tire_threshold_${i}" 
                                    class="form-control" 
                                    name="tire_thresholds[]" 
                                    placeholder=""
                                    value="${oldThreshold}"
                                    step="1"
                                    min="0"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="tire_nextKM_${i}">{{ __('Prochain km pour changement') }}</label>
                                <input 
                                    type="number" 
                                    id="tire_nextKM_${i}" 
                                    class="form-control" 
                                    name="tire_nextKMs[]" 
                                    placeholder=""
                                    value="${oldNextKM}"
                                    step="1"
                                    min="0"
                                    required>
                            </div>
                        </div>
                    `;
                    tireFieldsContainer.appendChild(tireCard);
                }

                // Initialize integer validation for new number fields
                document.querySelectorAll('#tireFieldsContainer input[type="number"][step="1"]').forEach(function(el) {
                    el.addEventListener('input', function(e) {
                        if (this.value && this.value.includes('.')) {
                            this.value = Math.floor(parseFloat(this.value)).toString();
                        }
                    });
                });
            }

            // Generate tire fields on page load if no existing tires
            if (!hasExistingTires && numOfTiresInput) {
                generateTireFields();
            }

            // Regenerate tire fields when number of tires changes (only if no existing tires)
            if (!hasExistingTires && numOfTiresInput) {
                numOfTiresInput.addEventListener('change', generateTireFields);
                numOfTiresInput.addEventListener('input', generateTireFields);
            }

            // Auto-calculate next KM for change based on current KM + threshold
            if (tireFieldsContainer && kmActuelInput) {
                tireFieldsContainer.addEventListener('input', function(e) {
                    if (e.target.name === 'tire_thresholds[]') {
                        const index = Array.from(document.querySelectorAll('input[name="tire_thresholds[]"]')).indexOf(e.target);
                        const threshold = parseInt(e.target.value) || 0;
                        const currentKm = parseInt(kmActuelInput.value) || 0;
                        const nextKmInput = document.querySelectorAll('input[name="tire_nextKMs[]"]')[index];
                        
                        if (nextKmInput && currentKm > 0 && threshold > 0) {
                            const nextKm = currentKm + threshold;
                            nextKmInput.value = nextKm.toString();
                        }
                    }
                });
            }

            // Additional initialization if needed
            console.log('Page loaded, form ready');
        });
    </script>
</x-admin.app>
