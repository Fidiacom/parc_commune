<x-admin.app>

    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-8 mx-auto">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">{{ __('modifier vehicule') }}</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-8 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.vehicule.update', $vehicule->getId()) }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            {{-- Vehicle Images Section --}}
                            <div class="form-group mt-4">
                                <label class="mb-3">{{ __('Images du véhicule') }}</label>
                                <x-vehicule-images :vehicule="$vehicule" :showUpload="true" />
                            </div>

                            <div class="form-group">
                                <a href="{{ route('admin.dtt', Crypt::encrypt($vehicule->getId())) }}" class="btn btn-primary waves-effect waves-light">
                                    {{ __('Pneus/Vidange/Chaine de distribution') }}
                                </a>

                                <a href="{{ route('admin.maintenance.create', Crypt::encrypt($vehicule->getId())) }}" class="btn btn-primary waves-effect waves-light">
                                    <div>
                                        <i class="fas fa-cogs"></i>
                                        {{ __('Maintenance & gasoile') }}
                                    </div>
                                </a>
                            </div>

                            {{-- Vehicle Attachments Section --}}
                            <div class="form-group mt-4">
                                <label class="mb-3">{{ __('Documents et fichiers du véhicule') }}</label>
                                <x-vehicule-file-attachments :vehicule="$vehicule" :showUpload="true" />
                            </div>

                            {{-- Brand --}}
                            <div class="form-group">
                                <label for="simpleinput">{{ __('marque') }}</label>
                                <input
                                    type="text"
                                    id="simpleinput"
                                    class="form-control @error('brand') is-invalid @enderror"
                                    name="brand"
                                    value="{{ $vehicule->getBrand() }}"
                                    placeholder="Dacia/Peugot/..."
                                >
                                @error('brand')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>


                            {{-- Model --}}
                            <div class="form-group">
                                <label for="example-password">{{ __('model') }}</label>
                                <input
                                    type="text"
                                    id="example-password"
                                    class="form-control  @error('model') is-invalid @enderror"
                                    name="model"
                                    value="{{ $vehicule->getModel() }}"
                                >
                                @error('model')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>


                            {{-- mattricule --}}
                            <div class="form-group">
                                <label for="exampleFormControlInput1">{{ __('matricule') }}</label>
                                <input
                                    type="text"
                                    class="form-control @error('matricule') is-invalid @enderror"
                                    id="exampleFormControlInput1"
                                    name="matricule"
                                    placeholder=""
                                    value="{{ $vehicule->getMatricule() }}"
                                >
                                @error('matricule')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>


                            {{-- Chassis --}}
                            <div class="form-group">
                                <label for="exampleFormControlInput1">{{ __('chassis') }}</label>
                                <input
                                    type="text"
                                    class="form-control @error('chassis') is-invalid @enderror"
                                    id="exampleFormControlInput1"
                                    name="chassis"
                                    placeholder=""
                                    value="{{ $vehicule->getNumChassis() }}"
                                >
                                @error('chassis')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            {{-- Circulation Date --}}
                            <div class="form-group">
                                <label for="inputPassword2" class="">{{ __('circulation date') }}</label>
                                <input
                                    type="date"
                                    class="form-control @error('circulation_date') is-invalid @enderror"
                                    id="inputPassword2"
                                    name="circulation_date"
                                    value="{{ $vehicule->getCirculationDate() }}"
                                >
                                @error('circulation_date')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            {{-- Km actuel --}}
                            <div class="form-group">
                                <label for="exampleFormControlInput1">{{ __('Km actuel') }}</label>
                                <input type="text"
                                    value="{{ $vehicule->getTotalKm() }}"
                                    class="form-control autonumber @error('km_actuel') is-invalid @enderror"
                                    name="km_actuel"
                                    data-a-sep="."
                                    data-a-dec=","
                                >
                                @error('km_actuel')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            {{-- Horses --}}
                            <div class="form-group">
                                <label for="exampleFormControlInput1">{{ __('cheveaux') }}</label>

                                <input
                                    type="text"
                                    class="form-control autonumber @error('horses') is-invalid @enderror"
                                    name="horses"
                                    value="{{ $vehicule->getHorses() }}"
                                    data-a-sep="."
                                    data-a-dec=",">
                                @error('horses')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            {{-- Fuel type --}}
                            <div class="form-group">
                                <label for="exampleFormControlInput1">{{ __('Type de carburant') }}</label>
                                <select name="fuel_type" id="" class="form-control @error('fuel_type') is-invalid @enderror" >
                                    <option value="0">{{ __('Sélectionner le type de carburant') }}</option>
                                    <option value="Gasoline" @selected($vehicule->getFuelType() == "Gasoline")>{{ __('Essence') }}</option>
                                    <option value="Diesel" @selected($vehicule->getFuelType() == "Diesel")>{{ __('Diesel') }}</option>
                                    <option value="Eletric" @selected($vehicule->getFuelType() == "Eletric")>{{ __('Électrique') }}</option>
                                </select>
                                @error('fuel_type')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>



                            {{-- CHeck boxes --}}
                            <div class="mt-2">
                                <div class="custom-control custom-checkbox custom-control-inline">
                                    <input
                                        type="checkbox"
                                        class="custom-control-input"
                                        id="customCheck5"
                                        @checked($vehicule->getAirbag())
                                        name="airbag"
                                    >
                                    <label class="custom-control-label" for="customCheck5">{{ __('Airbag') }}</label>
                                </div>
                                <div class="custom-control custom-checkbox custom-control-inline">
                                    <input
                                        type="checkbox"
                                        class="custom-control-input"
                                        id="customCheck6"
                                        @checked($vehicule->getAbs())
                                        name="abs"
                                    >
                                    <label class="custom-control-label" for="customCheck6">{{ __('Abs') }}</label>
                                </div>
                            </div>



                            <div class="form-group">
                                <label for="exampleFormControlInput1">{{ __('seuil KM vidange') }}</label>
                                <input
                                    type="text"
                                    placeholder=""
                                    class="form-control autonumber @error('threshold_vidange') is-invalid @enderror"
                                    name="threshold_vidange"
                                    value="{{ $vehicule->getThresholdVidange() }}"
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
                                    value="{{ $vehicule->getThresholdTimingChaine() }}"
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
                            {{-- Inssurance expiration --}}
                            <div class="form-group">
                                <label for="inputPassword2" class="">{{ __('expiration assurance') }}</label>
                                <input
                                    type="date"
                                    class="form-control @error('inssurance_expiration') is-invalid @enderror"
                                    id="inputPassword2"
                                    name="inssurance_expiration"
                                    value="{{ $vehicule->getInssuranceExpiration() }}"
                                >
                                @error('inssurance_expiration')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>


                            {{-- Visite technique --}}
                            <div class="form-group">
                                <label for="inputPassword2" class="">{{ __('expiration visite technique') }}</label>
                                <input
                                    type="date"
                                    class="form-control @error('technical_visit_expiration') is-invalid @enderror"
                                    id="inputPassword2"
                                    name="technical_visit_expiration"
                                    value="{{ $vehicule->getTechnicalvisiteExpiration() }}"
                                >
                                @error('technical_visit_expiration')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            {{-- Number Of TIRES --}}
                            <div class="form-group">
                                <label for="inputPassword2" class="">{{ __('Number of tires') }}</label>
                                <input
                                    type="number"
                                    class="form-control @error('numOfTires') is-invalid @enderror"
                                    name="numOfTires"
                                    value="{{ $vehicule->getNumberOfTires() }}"
                                >
                                @error('numOfTires')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            {{-- Tire Size --}}
                            <div class="form-group">
                                <label for="tireSize">{{ __('Taille des pneus') }}</label>
                                <input
                                    type="text"
                                    class="form-control @error('tire_size') is-invalid @enderror"
                                    id="tireSize"
                                    name="tire_size"
                                    placeholder="Ex: 205/55R16, 225/45R17"
                                    value="{{ $vehicule->getTireSize() ?? old('tire_size') }}">
                                <small class="form-text text-muted">{{ __('Entrer la taille des pneus (Ex: 205/55R16)') }}</small>
                                @error('tire_size')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            {{-- Tires Information Section --}}
                            <div class="form-group mt-4">
                                <label class="mb-3">{{ __('Informations des pneus') }}</label>
                                <div id="tireFieldsContainer">
                                    @if($vehicule->pneu && $vehicule->pneu->count() > 0)
                                        @foreach($vehicule->pneu as $index => $tire)
                                        <div class="card mb-3">
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
                                                        type="text" 
                                                        id="tire_threshold_{{ $index }}" 
                                                        class="form-control autonumber" 
                                                        name="tire_thresholds[]" 
                                                        data-a-sep="." 
                                                        data-a-dec=","
                                                        placeholder=""
                                                        value="{{ old("tire_thresholds.{$index}", $tire->getThresholdKm()) }}"
                                                        required>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    @else
                                        <div class="alert alert-info">
                                            <i class="fas fa-info-circle"></i> {{ __('Aucun pneu enregistré. Les pneus seront créés lors de la mise à jour.') }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <input type="hidden" name="vehicule_id" value="{{ Crypt::encrypt($vehicule->getId()) }}">
                            {{-- Submit --}}
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary waves-effect waves-light">{{ __('Sauvgarder') }}</button>
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

            // Initialize autonumber for tire threshold fields
            if (typeof AutoNumeric !== 'undefined') {
                document.querySelectorAll('#tireFieldsContainer .autonumber').forEach(function(el) {
                    new AutoNumeric(el, {
                        digitGroupSeparator: '.',
                        decimalCharacter: ','
                    });
                });
            }
        });
    </script>
</x-admin.app>
