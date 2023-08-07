<x-admin.app>

    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-8 mx-auto">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">{{ __('Pneu') }}</h4>
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
                        <h4 class="mb-0 h6">{{ __('Pneu').' '.$item }}</h4>
                    </div>
                    <div class="card">

                        <div class="card-body">


                                <div class="form-group">
                                    <label for="simpleinput">{{ __('Tire Position') }}</label>

                                    <input type="text" id="simpleinput" class="form-control @error('positions') is-invalid @enderror" name="positions[]" placeholder="" value="{{ $item }}">

                                </div>

                                <div class="form-group">
                                    <label for="simpleinput">{{ __('Seuil km') }}</label>


                                    <input type="text" placeholder="" class="form-control autonumber @error('thresholds') is-invalid @enderror" name="thresholds[]" data-a-sep="." data-a-dec=",">

                                </div>


                                <div class="form-group">
                                    <label for="simpleinput">{{ __('next km for change') }}</label>
                                    <input type="text" placeholder="" class="form-control autonumber @error('nextKMs') is-invalid @enderror" name="nextKMs[]" data-a-sep="." data-a-dec=",">

                                </div>


                            </div>
                            <!-- end card-body-->
                        </div>
                        @endforeach
                        <input type="hidden" value="{{ $carId }}" name="carId">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary waves-effect waves-light">{{ __('Sauvgarder') }}</button>
                        </div>
                </form>
                <!-- end card -->



            </div> <!-- end col -->

        </div>
        <!-- end row-->

    </div> <!-- container-fluid -->
</x-admin.app>
