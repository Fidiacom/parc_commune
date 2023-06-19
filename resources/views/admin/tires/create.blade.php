<x-admin.app>

    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-8 mx-auto">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">{{ __('add Drivers') }}</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-8 mx-auto">
                <form action="{{ route('admin.tire.store') }}" method="post">
                    @csrf
                    @foreach (range(1,$tires) as $item)
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0 h6">{{ __('Tire').' '.$item }}</h4>
                    </div>
                    <div class="card">

                        <div class="card-body">


                                <div class="form-group">
                                    <label for="simpleinput">{{ __('Tire Position') }}</label>
                                    
                                    <input type="text" id="simpleinput" class="form-control @error('positions') is-invalid @enderror" name="positions[]" placeholder="">
                                    @error('tire_position')
                                    <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="simpleinput">{{ __('threshold km') }}</label>
                                    <input type="number" id="simpleinput" class="form-control @error('thresholds') is-invalid @enderror" name="thresholds[]" placeholder="">
                                    @error('threshold_km')
                                    <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>


                                <div class="form-group">
                                    <label for="simpleinput">{{ __('next km for change') }}</label>
                                    <input type="number" id="simpleinput" class="form-control @error('nextKMs') is-invalid @enderror" name="nextKMs[]" placeholder="">
                                    @error('next_km_for_change')
                                    <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>


                            </div>
                            <!-- end card-body-->
                        </div>
                        @endforeach
                        <input type="hidden" value="{{ $carId }}" name="carId">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button>
                        </div>
                </form>
                <!-- end card -->



            </div> <!-- end col -->

        </div>
        <!-- end row-->

    </div> <!-- container-fluid -->
</x-admin.app>
