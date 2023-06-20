<x-admin.app>

    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-8 mx-auto">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">{{ __('add vehicule') }}</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-8 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.vehicule.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">

                                <div class="col-xl-5 mx-auto">
                                    <div class="card">
                                        <div class="card-body">

                                            <h4 class="card-title">Car Picture</h4>
                                            <p class="card-subtitle mb-4">MAX SIZE 5M.</p>

                                            <input type="file" class="dropify" data-max-file-size="5M" name="image" accept="image/*" data-default-file="{{ asset($vehicule->image) }}"/>

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
                                <label for="simpleinput">{{ __('brand') }}</label>
                                <input
                                    type="text"
                                    id="simpleinput"
                                    class="form-control @error('brand') is-invalid @enderror"
                                    name="brand"
                                    value="{{ $vehicule->brand }}"
                                    placeholder="Dacia/Peugot/..."
                                >
                                @error('brand')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="example-password">{{ __('Model') }}</label>
                                <input
                                    type="text"
                                    id="example-password"
                                    class="form-control  @error('model') is-invalid @enderror"
                                    name="model"
                                    value="{{ $vehicule->model }}"
                                >
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
                                    class="form-control @error('matricule') is-invalid @enderror"
                                    id="exampleFormControlInput1"
                                    name="matricule"
                                    placeholder=""
                                    value="{{ $vehicule->matricule }}"
                                >
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
                                    class="form-control @error('chassis') is-invalid @enderror"
                                    id="exampleFormControlInput1"
                                    name="chassis"
                                    placeholder=""
                                    value="{{ $vehicule->num_chassis }}"
                                >
                                @error('chassis')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>



                            <div class="form-group">
                                <label for="exampleFormControlInput1">{{ __('Km actuel') }}</label>
                                <input type="text"
                                    value="{{ $vehicule->total_km }}"
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

                            <div class="form-group">
                                <label for="exampleFormControlInput1">{{ __('horses') }}</label>

                                <input
                                    type="text"
                                    class="form-control autonumber @error('horses') is-invalid @enderror"
                                    name="horses"
                                    value="{{ $vehicule->horses }}"
                                    data-a-sep="."
                                    data-a-dec=",">
                                @error('horses')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlInput1">{{ __('Fuel Type') }}</label>
                                <select name="fuel_type" id="" class="form-control @error('fuel_type') is-invalid @enderror" >
                                    <option value="0">{{ __('Select Fuel Type') }}</option>
                                    <option value="Gasoline" @selected($vehicule->fuel_type == "Gasoline")>{{ __('Gasoline') }}</option>
                                    <option value="Diesel" @selected($vehicule->fuel_type == "Diesel")>{{ __('Diesel') }}</option>
                                    <option value="Eletric" @selected($vehicule->fuel_type == "Eletric")>{{ __('Eletric') }}</option>
                                </select>
                                @error('fuel_type')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="mt-2">
                                <div class="custom-control custom-checkbox custom-control-inline">
                                    <input type="checkbox" class="custom-control-input" id="customCheck5" @checked($vehicule->airbag) name="airbag">
                                    <label class="custom-control-label" for="customCheck5">Airbag</label>
                                </div>
                                <div class="custom-control custom-checkbox custom-control-inline">
                                    <input type="checkbox" class="custom-control-input" id="customCheck6" @checked($vehicule->abs) name="abs">
                                    <label class="custom-control-label" for="customCheck6">Abs</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlInput1">{{ __('seuil KM vidange') }}</label>
                                <input type="text"
                                    value=""
                                    class="form-control autonumber @error('threshold_vidange') is-invalid @enderror"
                                    name="threshold_vidange"
                                    data-a-sep="."
                                    data-a-dec=","
                                >
                                @error('threshold_vidange')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>



                            <div class="form-group">
                                <label for="exampleFormControlInput1">{{ __('seuil KM chaine de distrubution') }}</label>
                                <input type="text" placeholder="" class="form-control autonumber @error('threshold_timing_chaine') is-invalid @enderror"  name="threshold_timing_chaine" data-a-sep="." data-a-dec=",">
                                @error('threshold_timing_chaine')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>


                            <div class="form-group">
                                <label for="inputPassword2" class="">{{ __('expiration assurance') }}</label>
                                <input type="date" class="form-control  @error('inssurance_expiration') is-invalid @enderror" id="inputPassword2" name="inssurance_expiration">
                                @error('inssurance_expiration')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="inputPassword2" class="">{{ __('expiration visite technique') }}</label>
                                <input type="date" class="form-control  @error('technical_visit_expiration') is-invalid @enderror" id="inputPassword2" name="technical_visit_expiration">
                                @error('technical_visit_expiration')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="inputPassword2" class="">{{ __('Number of tires') }}</label>
                                <input type="number" class="form-control  @error('numOfTires') is-invalid @enderror" name="numOfTires">
                                @error('numOfTires')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>


                            <div class="form-group">
                                <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button>
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
