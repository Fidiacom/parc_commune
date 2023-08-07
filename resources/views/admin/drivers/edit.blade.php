<x-admin.app>

    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-8 mx-auto">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">{{ __('edit condicteur') }}</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-8 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.driver.update', crypt::encrypt($driver->id)) }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            {{-- Picture --}}
                            <div class="form-group">

                                <div>
                                    <div class="col-xl-5 mx-auto">
                                        <div class="card">
                                            <div class="card-body">

                                                <h4 class="card-title">{{ __('Image') }}</h4>
                                                <p class="card-subtitle mb-4">{{ __('la taile maximum est') }}</p>

                                                <input type="file" class="dropify" data-max-file-size="5M" name="image" accept="image/*" data-default-file="{{ asset($driver->image) }}"/>

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

                            {{-- Full name --}}
                            <div class="form-group">
                                <label for="simpleinput">{{ __('full name') }}</label>
                                <input
                                    type="text"
                                    id="simpleinput"
                                    class="form-control @error('full_name') is-invalid @enderror"
                                    name="full_name"
                                    placeholder="Name..."
                                    value="{{ $driver->full_name }}">
                                @error('full_name')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            {{-- CIN --}}
                            <div class="form-group">
                                <label for="example-password">{{ __('cin') }}</label>
                                <input
                                    type="text"
                                    id="example-password"
                                    class="form-control  @error('cin') is-invalid @enderror"
                                    name="cin"
                                    value="{{ $driver->cin }}">
                                @error('cin')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            {{-- License --}}
                            <div class="form-group">
                                <div class="form-group mb-0">
                                    <label for="exampleFormControlInput1">{{ __('license') }}</label>

                                    <select class="form-control select2-multiple @error('permisType') is-invalid @enderror" data-toggle="select2" multiple="multiple" name="permisType[]" data-placeholder="permis ...">
                                        @foreach ($permis as $p)
                                            <option value="{{ $p->id }}" @selected($driver->permis->pluck('id')->contains($p->id))>{{ $p->label }}</option>
                                        @endforeach
                                    </select>
                                    @error('permisType')
                                    <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror

                                </div>
                            </div>

                            {{-- Phone --}}
                            <div class="form-group">
                                <label for="exampleFormControlInput1">{{ __('telephone') }}</label>
                                <input
                                    type="text"
                                    class="form-control  @error('phone') is-invalid @enderror"
                                    id="exampleFormControlInput1"
                                    name="phone"
                                    value="{{ $driver->phone }}">
                                @error('phone')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary waves-effect waves-light">{{ __('Sauvgarde') }}</button>
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
