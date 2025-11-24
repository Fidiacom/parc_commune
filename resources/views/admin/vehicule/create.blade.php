<x-admin.app>

    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-8 mx-auto">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">{{ __('Ajout vehicule') }}</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-8 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <!-- Step Indicators -->
                        <ul class="nav nav-pills bg-nav-pills nav-justified mb-3" id="stepTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="step1-tab" data-toggle="tab" href="#step1" role="tab" aria-controls="step1" aria-selected="true">
                                    <span class="d-block d-sm-none"><i class="mdi mdi-car"></i></span>
                                    <span class="d-none d-sm-block">{{ __('Étape 1: Informations du véhicule') }}</span>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="step2-tab" data-toggle="tab" href="#step2" role="tab" aria-controls="step2" aria-selected="false">
                                    <span class="d-block d-sm-none"><i class="mdi mdi-circle-multiple"></i></span>
                                    <span class="d-none d-sm-block">{{ __('Étape 2: Informations des pneus') }}</span>
                                </a>
                            </li>
                        </ul>

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
                            <div class="form-group">
                                <label class="mb-2">{{ __('Images de vehicule') }}</label>
                                <div class="col-xl-8 mx-auto">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title">{{ __('Images de vehicule') }}</h4>
                                            <p class="card-subtitle mb-4">{{ __('Vous pouvez sélectionner plusieurs images. Taille maximum: 50M par image.') }}</p>

                                            <input type="file" class="form-control-file" name="images[]" id="vehicleImages" multiple accept="image/*"/>
                                            <small class="form-text text-muted">{{ __('Sélectionnez une ou plusieurs images du véhicule') }}</small>
                                            
                                            <div id="imagePreview" class="mt-3" style="display: flex; flex-wrap: wrap; gap: 10px;"></div>
                                                </div>
                                            </div>
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

                            <div class="form-group">
                                <label for="simpleinput">{{ __('marque') }}</label>
                                <input
                                    type="text"
                                    id="simpleinput"
                                    class="form-control @error('brand') is-invalid @enderror"
                                    name="brand"
                                    placeholder="Dacia/Peugot/..."
                                    value="{{ old('brand') }}">
                                @error('brand')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="example-password">{{ __('model') }}</label>
                                <input
                                    type="text"
                                    id="example-password"
                                    class="form-control  @error('model') is-invalid @enderror"
                                    name="model"
                                    value="{{ old('model') }}">
                                @error('model')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlInput1">{{ __('matricule') }}</label>
                                <input
                                    type="text"
                                    class="form-control  @error('matricule') is-invalid @enderror"
                                    id="exampleFormControlInput1"
                                    name="matricule"
                                    placeholder=""
                                    value="{{ old('matricule') }}">
                                @error('matricule')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlInput1">{{ __('chassis') }}</label>
                                <input
                                    type="text"
                                    class="form-control  @error('chassis') is-invalid @enderror"
                                    id="exampleFormControlInput1"
                                    name="chassis"
                                    value="{{ old('chassis') }}">
                                @error('chassis')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="inputPassword2" class="">{{ __('circulation date') }}</label>
                                <input
                                    type="date"
                                    value="{{ old('circulation_date') }}"
                                    class="form-control  @error('circulation_date') is-invalid @enderror"
                                    name="circulation_date">
                                @error('circulation_date')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlInput1">{{ __('Km actuel') }}</label>
                                <input
                                    type="text"
                                    value="{{ old('km_actuel') }}"
                                    class="form-control autonumber @error('km_actuel') is-invalid @enderror"
                                    name="km_actuel"
                                            id="km_actuel"
                                    data-a-sep="."
                                    data-a-dec=",">
                                @error('km_actuel')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlInput1">{{ __('cheveaux') }}</label>
                                <input
                                    type="text"
                                    value="{{ old('horses') }}"
                                    class="form-control autonumber @error('horses') is-invalid @enderror"
                                    name="horses"
                                    data-a-sep="."
                                    data-a-dec=",">
                                @error('horses')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlInput1">{{ __('Permis Used (Category)') }}</label>
                                <select name="category" class="form-control @error('category') is-invalid @enderror" >
                                    <option value="0">{{ __('Sélectionner une catégorie') }}</option>
                                    @foreach ($categories as $c)
                                    <option value="{{ $c->id }}" @selected($c->id == old('category'))>{{ $c->label }}</option>
                                    @endforeach
                                </select>
                                @error('category')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlInput1">{{ __('Type de carburant') }}</label>
                                <select name="fuel_type" id="" class="form-control @error('fuel_type') is-invalid @enderror" >
                                    <option value="0">{{ __('Sélectionner le type de carburant') }}</option>
                                    <option value="Gasoline" @selected(old('fuel_type') == 'Gasoline')>{{ __('Essence') }}</option>
                                    <option value="Diesel" @selected(old('fuel_type') == 'Diesel')>{{ __('Diesel') }}</option>
                                    <option value="Eletric" @selected(old('fuel_type') == 'Eletric')>{{ __('Électrique') }}</option>
                                </select>
                                @error('fuel_type')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="mt-2">
                                <div class="custom-control custom-checkbox custom-control-inline">
                                    <input type="checkbox" class="custom-control-input" id="customCheck5" checked @checked(old('airbag') == 'on') name="airbag">
                                    <label class="custom-control-label" for="customCheck5">{{ __('Airbag') }}</label>
                                </div>
                                <div class="custom-control custom-checkbox custom-control-inline">
                                    <input type="checkbox" class="custom-control-input" id="customCheck6" checked @checked(old('abs') == 'on') name="abs">
                                    <label class="custom-control-label" for="customCheck6">{{ __('Abs') }}</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlInput1">{{ __('seuil KM vidange') }}</label>
                                <input
                                    type="text"
                                    placeholder=""
                                    value="{{ old('threshold_vidange') }}"
                                    class="form-control autonumber @error('threshold_vidange') is-invalid @enderror"
                                    name="threshold_vidange"
                                    data-a-sep="." data-a-dec=",">

                                @error('threshold_vidange')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlInput1">{{ __('seuil KM chaine de distrubution') }}</label>
                                <input
                                    type="text"
                                    value="{{ old('threshold_timing_chaine') }}"
                                    class="form-control autonumber @error('threshold_timing_chaine') is-invalid @enderror"
                                    name="threshold_timing_chaine"
                                    data-a-sep="."
                                    data-a-dec=",">
                                @error('threshold_timing_chaine')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="inputPassword2" class="">{{ __('expiration assurance') }}</label>
                                <input
                                    type="date"
                                    value="{{ old('inssurance_expiration') }}"
                                    class="form-control  @error('inssurance_expiration') is-invalid @enderror"
                                    name="inssurance_expiration">
                                @error('inssurance_expiration')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="inputPassword2" class="">{{ __('expiration visite technique') }}</label>
                                <input
                                    type="date"
                                    value="{{ old('technical_visit_expiration') }}"
                                    class="form-control @error('technical_visit_expiration') is-invalid @enderror"
                                    name="technical_visit_expiration">
                                @error('technical_visit_expiration')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="inputPassword2" class="">{{ __('Number of tires') }}</label>
                                <input
                                    type="number"
                                    class="form-control  @error('numOfTires') is-invalid @enderror"
                                    name="numOfTires"
                                            id="numOfTires"
                                            value="{{ old('numOfTires', 4) }}"
                                            min="1"
                                            max="20">
                                @error('numOfTires')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="tireSize">{{ __('Tire Size') }}</label>
                                <input
                                    type="text"
                                    class="form-control @error('tire_size') is-invalid @enderror"
                                    id="tireSize"
                                    name="tire_size"
                                    placeholder=""
                                    value="{{ old('tire_size') }}">
                                @error('tire_size')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group mt-4">
                                <label class="mb-3">{{ __('Documents et fichiers du véhicule') }}</label>
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ __('Télécharger des fichiers') }}</h5>
                                        <p class="text-muted">{{ __('Vous pouvez télécharger plusieurs fichiers (images, PDF, documents) lors de la création du véhicule. Taille maximum: 50MB par fichier.') }}</p>
                                        <div class="form-group">
                                            <input type="file" class="form-control-file" name="files[]" id="fileInput" multiple accept="image/*,.pdf,.doc,.docx">
                                            <small class="form-text text-muted">{{ __('Sélectionner plusieurs fichiers à télécharger') }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                                    <div class="form-group mt-4">
                                        <button type="button" class="btn btn-primary waves-effect waves-light" id="nextToStep2">{{ __('Suivant: Informations des pneus') }}</button>
                                    </div>
                                </div>

                                <!-- Step 2: Tire Information -->
                                <div class="tab-pane fade" id="step2" role="tabpanel" aria-labelledby="step2-tab">
                                    <div id="tireFieldsContainer">
                                        <!-- Tire fields will be dynamically generated here -->
                                    </div>

                                    <div class="form-group mt-4">
                                        <button type="button" class="btn btn-secondary waves-effect waves-light mr-2" id="backToStep1">{{ __('Précédent') }}</button>
                                        <button type="submit" class="btn btn-primary waves-effect waves-light" id="submitForm">{{ __('Enregistrer le véhicule') }}</button>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
                    document.getElementById('step2-tab').click();
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

            // Navigate back to step 1
            backToStep1Btn.addEventListener('click', function() {
                // Clear validation errors
                document.querySelectorAll('.is-invalid').forEach(el => {
                    el.classList.remove('is-invalid');
                });
                document.getElementById('frontendErrors').style.display = 'none';
                document.getElementById('step1-tab').click();
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
                
                const chassis = document.querySelector('input[name="chassis"]');
                if (!chassis.value.trim()) {
                    chassis.classList.add('is-invalid');
                    errors.push('{{ __("Le numéro de châssis est requis") }}');
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
