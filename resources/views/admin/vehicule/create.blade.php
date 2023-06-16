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
                        <form action="{{ route('admin.vehicule.store') }}" method="POST">
                            @csrf
                            <div class="form-group">

                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="image" id="customFile">
                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                </div>

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
                                <input type="text" id="example-password" class="form-control  @error('brand') is-invalid @enderror" name="model" value="">
                                @error('brand')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlInput1">{{ __('matricule') }}</label>
                                <input type="text" class="form-control  @error('brand') is-invalid @enderror" id="exampleFormControlInput1" name="matricule" placeholder="">
                                @error('brand')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlInput1">{{ __('chassis') }}</label>
                                <input type="text" class="form-control  @error('brand') is-invalid @enderror" id="exampleFormControlInput1" name="chassis" placeholder="">
                                @error('brand')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlInput1">{{ __('num carte grise') }}</label>
                                <input type="text" class="form-control  @error('brand') is-invalid @enderror" id="exampleFormControlInput1" name="carte_grise" placeholder="">
                                @error('brand')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlInput1">{{ __('Km actuel') }}</label>
                                <input type="number" class="form-control  @error('brand') is-invalid @enderror" id="exampleFormControlInput1" name="km_actuel" placeholder="">
                                @error('brand')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlInput1">{{ __('horses') }}</label>
                                <input type="number" class="form-control  @error('brand') is-invalid @enderror" id="exampleFormControlInput1" name="horses" placeholder="">
                                @error('brand')
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
                                <input type="number" class="form-control  @error('brand') is-invalid @enderror" id="exampleFormControlInput1" name="threshold_vidange" placeholder="">
                                @error('brand')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>



                            <div class="form-group">
                                <label for="exampleFormControlInput1">{{ __('seuil KM chaine de distrubution') }}</label>
                                <input type="number" class="form-control  @error('brand') is-invalid @enderror" id="exampleFormControlInput1" name="threshold_timing_chaine" placeholder="">
                                @error('brand')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>


                            <div class="form-group">
                                <label for="inputPassword2" class="">{{ __('expiration assurance') }}</label>
                                <input type="date" class="form-control  @error('brand') is-invalid @enderror" id="inputPassword2" name="inssurance_expiration">
                                @error('brand')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="inputPassword2" class="">{{ __('expiration visite technique') }}</label>
                                <input type="date" class="form-control  @error('brand') is-invalid @enderror" id="inputPassword2" name="technical_visit_expiration">
                                @error('brand')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>


                            <div class="form-inline form-group mt-4">

                                <div class="form-group w-50">
                                    <label for="inputPassword2" class="">{{ __('seuil KM Pneu (Avant|Gauche)') }}</label>
                                    <input type="number" class="form-control  @error('brand') is-invalid @enderror w-100" id="inputPassword2" name="pneu_ag">
                                    @error('brand')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                                </div>

                                <div class="form-group w-50">
                                    <label for="inputPassword2" class="">{{ __('seuil KM Pneu (Avant|Droit)') }}</label>
                                    <input type="number" class="form-control  @error('brand') is-invalid @enderror w-100 ml-2" id="inputPassword2" name="pneu_ad">
                                    @error('brand')
                                    <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-inline form-group mt-4">

                                <div class="form-group w-50">
                                    <label for="inputPassword2" class="">{{ __('seuil KM Pneu (Derriere|Gauche)') }}</label>
                                    <input type="number" class="form-control  @error('brand') is-invalid @enderror w-100" id="inputPassword2" name="pneu_dg">
                                    @error('brand')
                                    <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group w-50">
                                    <label for="inputPassword2" class="">{{ __('seuil KM Pneu (Derriere|Droit)') }}</label>
                                    <input type="number" class="form-control  @error('brand') is-invalid @enderror w-100 ml-2" id="inputPassword2" name="pneu_dd">
                                    @error('brand')
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
