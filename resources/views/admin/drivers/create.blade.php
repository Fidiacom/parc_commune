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
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.driver.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">

                                <div>
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


                            </div>

                            <div class="form-group">
                                <label for="simpleinput">{{ __('full name') }}</label>
                                <input type="text" id="simpleinput" class="form-control @error('full_name') is-invalid @enderror" name="full_name" placeholder="Name...">
                                @error('full_name')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="example-password">{{ __('CIN') }}</label>
                                <input type="text" id="example-password" class="form-control  @error('cin') is-invalid @enderror" name="cin" value="">
                                @error('cin')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>


                            <div class="form-group">
                                <div class="form-group mb-0">
                                    <label for="exampleFormControlInput1">{{ __('license') }}</label>

                                    <select class="form-control select2-multiple @error('permisType') is-invalid @enderror" data-toggle="select2" multiple="multiple" name="permisType[]" data-placeholder="permis ...">
                                        @foreach ($permis as $p)
                                            <option value="{{ $p->id }}">{{ $p->label }}</option>
                                        @endforeach
                                    </select>
                                    @error('permisType')
                                    <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror

                                </div>
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlInput1">{{ __('phone') }}</label>
                                <input type="text" class="form-control  @error('phone') is-invalid @enderror" id="exampleFormControlInput1" name="phone" placeholder="">
                                @error('phone')
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
