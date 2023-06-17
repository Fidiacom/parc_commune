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
                                <label for="simpleinput">{{ __('brand') }}</label>
                                <input type="text" id="simpleinput" class="form-control @error('brand') is-invalid @enderror" name="brand" placeholder="Dacia/Peugot/...">
                                @error('brand')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="example-password">{{ __('Model') }}</label>
                                <input type="text" id="example-password" class="form-control  @error('model') is-invalid @enderror" name="model" value="">
                                @error('model')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlInput1">{{ __('matricule') }}</label>
                                <input type="text" class="form-control  @error('matricule') is-invalid @enderror" id="exampleFormControlInput1" name="matricule" placeholder="">
                                @error('matricule')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlInput1">{{ __('chassis') }}</label>
                                <input type="text" class="form-control  @error('chassis') is-invalid @enderror" id="exampleFormControlInput1" name="chassis" placeholder="">
                                @error('chassis')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlInput1">{{ __('num carte grise') }}</label>
                                <input type="text" class="form-control  @error('carte_grise') is-invalid @enderror" id="exampleFormControlInput1" name="carte_grise" placeholder="">
                                @error('carte_grise')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlInput1">{{ __('Km actuel') }}</label>
                                <input type="number" class="form-control  @error('km_actuel') is-invalid @enderror" id="exampleFormControlInput1" name="km_actuel" placeholder="">
                                @error('km_actuel')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlInput1">{{ __('horses') }}</label>
                                <input type="number" class="form-control  @error('horses') is-invalid @enderror" id="exampleFormControlInput1" name="horses" placeholder="">
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
                                    <option value="Gasoline">{{ __('Gasoline') }}</option>
                                    <option value="Diesel">{{ __('Diesel') }}</option>
                                    <option value="Eletric">{{ __('Eletric') }}</option>
                                </select>
                                @error('fuel_type')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="mt-2">
                                <div class="custom-control custom-checkbox custom-control-inline">
                                    <input type="checkbox" class="custom-control-input" id="customCheck5" name="airbag">
                                    <label class="custom-control-label" for="customCheck5">Airbag</label>
                                </div>
                                <div class="custom-control custom-checkbox custom-control-inline">
                                    <input type="checkbox" class="custom-control-input" id="customCheck6" name="abs">
                                    <label class="custom-control-label" for="customCheck6">Abs</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlInput1">{{ __('seuil KM vidange') }}</label>
                                <input type="number" class="form-control  @error('threshold_vidange') is-invalid @enderror" id="exampleFormControlInput1" name="threshold_vidange" placeholder="">
                                @error('threshold_vidange')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>



                            <div class="form-group">
                                <label for="exampleFormControlInput1">{{ __('seuil KM chaine de distrubution') }}</label>
                                <input type="number" class="form-control  @error('threshold_timing_chaine') is-invalid @enderror" id="exampleFormControlInput1" name="threshold_timing_chaine" placeholder="">
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


                            <div class="form-inline form-group mt-4">

                                <div class="form-group w-50">
                                    <label for="inputPassword2" class="">{{ __('seuil KM Pneu (Avant|Gauche)') }}</label>
                                    <input type="number" class="form-control  @error('pneu_ag') is-invalid @enderror w-100" id="inputPassword2" name="pneu_ag">
                                    @error('pneu_ag')
                                    <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group w-50">
                                    <label for="inputPassword2" class="">{{ __('seuil KM Pneu (Avant|Droit)') }}</label>
                                    <input type="number" class="form-control  @error('pneu_ad') is-invalid @enderror w-100 ml-2" id="inputPassword2" name="pneu_ad">
                                    @error('pneu_ad')
                                    <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-inline form-group mt-4">

                                <div class="form-group w-50">
                                    <label for="inputPassword2" class="">{{ __('seuil KM Pneu (Derriere|Gauche)') }}</label>
                                    <input type="number" class="form-control  @error('pneu_dg') is-invalid @enderror w-100" id="inputPassword2" name="pneu_dg">
                                    @error('pneu_dg')
                                    <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group w-50">
                                    <label for="inputPassword2" class="">{{ __('seuil KM Pneu (Derriere|Droit)') }}</label>
                                    <input type="number" class="form-control  @error('pneu_dd') is-invalid @enderror w-100 ml-2" id="inputPassword2" name="pneu_dd">
                                    @error('pneu_dd')
                                    <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
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
