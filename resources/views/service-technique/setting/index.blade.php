<x-serviceTechnique.app>
    <div class="col-xl-8 mx-auto">

        <div class="card">
            <div class="card-body text-right">

                <h4 class="card-title">{{ __('Settings') }}</h4>
                <p class="card-subtitle mb-4">{{ __('Manage logo and commune name settings') }}</p>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <form action="{{ route('serviceTechnique.setting.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="commune_name_fr">{{ __('Commune Name') }} ({{ __('Français') }})</label>
                        <input 
                            type="text" 
                            class="form-control @error('commune_name_fr') is-invalid @enderror" 
                            id="commune_name_fr" 
                            name="commune_name_fr" 
                            placeholder="{{ __('Enter commune name in French') }}"
                            value="{{ old('commune_name_fr', $setting->getCommuneNameFr()) }}"
                            required>
                        @error('commune_name_fr')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="commune_name_ar">{{ __('Commune Name') }} ({{ __('العربية') }})</label>
                        <input 
                            type="text" 
                            class="form-control @error('commune_name_ar') is-invalid @enderror" 
                            id="commune_name_ar" 
                            name="commune_name_ar" 
                            placeholder="{{ __('Enter commune name in Arabic') }}"
                            value="{{ old('commune_name_ar', $setting->getCommuneNameAr()) }}"
                            required dir="rtl">
                        @error('commune_name_ar')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="logo">{{ __('Logo') }}</label>
                        <div class="mb-3">
                            @if($setting->getLogo())
                                <div class="mb-2">
                                    <img src="{{ asset($setting->getLogo()) }}" alt="Logo" style="max-height: 100px; max-width: 200px;">
                                </div>
                            @else
                                <div class="mb-2">
                                    <img src="{{ asset('assets/images/logo-light.png') }}" alt="Placeholder Logo" style="max-height: 100px; max-width: 200px;">
                                    <small class="text-muted d-block">{{ __('Current placeholder logo') }}</small>
                                </div>
                            @endif
                        </div>
                        <input 
                            type="file" 
                            class="form-control @error('logo') is-invalid @enderror" 
                            id="logo" 
                            name="logo" 
                            accept="image/*">
                        <small class="form-text text-muted">{{ __('Upload a new logo (Max: 2MB, Formats: jpeg, png, jpg, gif, svg)') }}</small>
                        @error('logo')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary waves-effect waves-light">{{ __('Update Settings') }}</button>
                </form>

            </div> <!-- end card-body-->
        </div> <!-- end card-->

    </div> <!-- end col -->
</x-serviceTechnique.app>
