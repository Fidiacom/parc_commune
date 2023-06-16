<x-admin.app>
    <div class="col-12">
        <div class="container mb-5">
            <form action="">
                <div class="card-subtitle mb-4">
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
                </div>
                <div class="text-right">
                    <button type="button" class="btn btn-primary waves-effect waves-light">Submit</button>
                </div>
            </form>
        </div>
        <div class="card">
            <div class="card-body">

                <div class="container">
                    <h4 class="card-title">Basic Data Table</h4>
                    <div class="row">
                        @foreach (range(1,8) as $item)
                        <div class="col-6 col-md-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    <img class="rounded-circle w-50 mb-3" alt="avatar1" src="https://mdbcdn.b-cdn.net/img/new/avatars/9.webp" />

                                    <h4 class="card-title">Special title treatment</h4>
                                    <p class="card-text">With supporting text below as a natural lead-in to
                                        additional content.</p>
                                    <a href="#" class="btn btn-primary waves-effect waves-light">More details</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</x-admin.app>
