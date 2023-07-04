<x-admin.app>

    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-8 mx-auto">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">{{ __('Maintenence & gasoile') }}</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-8 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.maintenance.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">

                                <div>
                                    <div class="col-xl-5 mx-auto">
                                        <div class="card">
                                            <div class="card-body">

                                                <h4 class="card-title">Car Picture</h4>
                                                <p class="card-subtitle mb-4">MAX SIZE 5M.</p>
                                                <input type="file" class="dropify" disabled data-max-file-size="5M" name="image" accept="image/*" data-default-file="{{ asset($vehicule->image) }}"/>
                                            </div> <!-- end card-body-->
                                        </div> <!-- end card-->
                                    </div> <!-- end col -->
                                </div>


                            </div>

                            <div class="form-group">
                                <label for="simpleinput">{{ __('vehicule brand & model') }}</label>
                                <input type="text" class="form-control" value="{{ $vehicule->brand.' | '.$vehicule->model }}" disabled>
                            </div>

                            <div class="form-group">
                                <label for="simpleinput">{{ __('vehicule matricule') }}</label>
                                <input type="text" id="simpleinput" class="form-control" value="{{ $vehicule->matricule }}" disabled>
                            </div>

                            <div class="form-group">
                                <label for="stock">Pieces || gasoil</label>
                                <select class="form-control @error('stock') is-invalid @enderror" data-toggle="select2" name="stock" id="stock" onchange="changePiece(this.value)">
                                    <option value="0" >Select</option>
                                    @foreach ($stocks as $stock)
                                    <option value="{{ $stock }}">{{ $stock->name }}</option>
                                    @endforeach
                                </select>
                                @error('stock')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlInput1">
                                    {{ __('Qantite').' | ' }}
                                    <label for="" class="text-danger" id="maxLabel"></label>
                                </label>
                                <input type="number" step="any" class="form-control  @error('qte') is-invalid @enderror" name="qte" id="qte">
                                @error('qte')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <input type="hidden" name="vehicule_id" value="{{ $vehicule->id }}">

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
        <script src="{{ asset('assets/js/maintenance/app.js') }}"></script>
        <!-- end row-->

    </div> <!-- container-fluid -->
</x-admin.app>
