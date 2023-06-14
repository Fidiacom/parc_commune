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
                        <form>
                            <div class="form-group">
                                <label for="simpleinput">{{ __('brand') }}</label>
                                <input type="text" id="simpleinput" class="form-control" placeholder="Dacia/Peugot/...">
                            </div>

                            <div class="form-group">
                                <label for="example-password">{{ __('Model') }}</label>
                                <input type="text" id="example-password" class="form-control" value="">
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlInput1">{{ __('matricule') }}</label>
                                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="">
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlInput1">{{ __('chassis') }}</label>
                                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="">
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlInput1">{{ __('num carte grise') }}</label>
                                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="">
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlInput1">{{ __('Km actuel') }}</label>
                                <input type="number" class="form-control" id="exampleFormControlInput1" placeholder="">
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlInput1">{{ __('horses') }}</label>
                                <input type="number" class="form-control" id="exampleFormControlInput1" placeholder="">
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlInput1">{{ __('seuil KM vidange') }}</label>
                                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="">
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlInput1">{{ __('seuil KM pneu') }}</label>
                                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="">
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlInput1">{{ __('seuil KM chaine de distrubution') }}</label>
                                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="">
                            </div>


                            <div class="form-group">
                                <label for="inputPassword2" class="">{{ __('expiration assurance') }}</label>
                                <input type="date" class="form-control" id="inputPassword2">
                            </div>

                            <div class="form-group">
                                <label for="inputPassword2" class="">{{ __('expiration visite technique') }}</label>
                                <input type="date" class="form-control" id="inputPassword2">
                            </div>


                            <div class="form-inline form-group mt-4">

                                <div class="form-group w-50">
                                    <label for="inputPassword2" class="">{{ __('Pneu (Avant|Gauche)') }}</label>
                                    <input type="number" class="form-control w-100" id="inputPassword2">
                                </div>

                                <div class="form-group w-50">
                                    <label for="inputPassword2" class="">{{ __('Pneu (Avant|Droit)') }}</label>
                                    <input type="number" class="form-control w-100 ml-2" id="inputPassword2">
                                </div>
                            </div>

                            <div class="form-inline form-group mt-4">

                                <div class="form-group w-50">
                                    <label for="inputPassword2" class="">{{ __('Pneu (Derriere|Gauche)') }}</label>
                                    <input type="number" class="form-control w-100" id="inputPassword2">
                                </div>

                                <div class="form-group w-50">
                                    <label for="inputPassword2" class="">{{ __('Pneu (Derriere|Droit)') }}</label>
                                    <input type="number" class="form-control w-100 ml-2" id="inputPassword2">
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
