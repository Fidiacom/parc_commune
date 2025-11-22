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
                        <form action="{{ route('admin.vehicule.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">

                                <div class="col-xl-5 mx-auto">
                                    <div class="card">
                                        <div class="card-body">

                                            <h4 class="card-title">{{ __('Image de vehicule') }}</h4>
                                            <p class="card-subtitle mb-4">{{ __('la taile maximum est') }} 5M.</p>

                                            <input type="file" class="dropify" data-max-file-size="5M" name="image" accept="image/*"/>

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
                                    <option value="0">{{ __('Select Category') }}</option>
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
                                <label for="exampleFormControlInput1">{{ __('Fuel Type') }}</label>
                                <select name="fuel_type" id="" class="form-control @error('fuel_type') is-invalid @enderror" >
                                    <option value="0">{{ __('Select Fuel Type') }}</option>
                                    <option value="Gasoline" @selected(old('Gasoline') == 'Gasoline')>{{ __('Gasoline') }}</option>
                                    <option value="Diesel" @selected(old('Diesel') == 'Diesel')>{{ __('Diesel') }}</option>
                                    <option value="Eletric" @selected(old('Electric') == 'Electric')>{{ __('Eletric') }}</option>
                                </select>
                                @error('fuel_type')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="mt-2">
                                <div class="custom-control custom-checkbox custom-control-inline">
                                    <input type="checkbox" class="custom-control-input" id="customCheck5" @checked(old('airbag') == 'on') name="airbag">
                                    <label class="custom-control-label" for="customCheck5">{{ __('Airbag') }}</label>
                                </div>
                                <div class="custom-control custom-checkbox custom-control-inline">
                                    <input type="checkbox" class="custom-control-input" id="customCheck6" @checked(old('abs') == 'on') name="abs">
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
                                    value="{{ old('numOfTires') }}">
                                @error('numOfTires')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>


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
