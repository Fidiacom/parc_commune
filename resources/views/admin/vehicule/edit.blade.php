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

                            {{-- Picture --}}
                            <div class="form-group">

                                <div class="col-xl-5 mx-auto">
                                    <div class="card">
                                        <div class="card-body">

                                            <h4 class="card-title">{{ __('Image de vehicule') }}</h4>
                                            <p class="card-subtitle mb-4">{{ __("la taile maximum est") }}</p>

                                            <input type="file" class="dropify" data-max-file-size="5M" name="image" accept="image/*" data-default-file="{{ asset($vehicule->getImage()) }}"/>

                                        </div> <!-- end card-body-->
                                    </div> <!-- end card-->
                                </div> <!-- end col -->


                                @error('image')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
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
                                <label for="exampleFormControlInput1">{{ __('Fuel Type') }}</label>
                                <select name="fuel_type" id="" class="form-control @error('fuel_type') is-invalid @enderror" >
                                    <option value="0">{{ __('Select Fuel Type') }}</option>
                                    <option value="Gasoline" @selected($vehicule->getFuelType() == "Gasoline")>{{ __('Gasoline') }}</option>
                                    <option value="Diesel" @selected($vehicule->getFuelType() == "Diesel")>{{ __('Diesel') }}</option>
                                    <option value="Eletric" @selected($vehicule->getFuelType() == "Eletric")>{{ __('Eletric') }}</option>
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
</x-admin.app>
