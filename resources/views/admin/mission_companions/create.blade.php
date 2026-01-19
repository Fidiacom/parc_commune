<x-admin.app>
    <div class="container-fluid">
        <div class="row">
            <div class="col-8 mx-auto">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">{{ __('Ajout accompagnant') }}</h4>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-8 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.mission_companions.store') }}" method="POST">
                            @csrf

                            <div class="card mb-3">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0">{{ __('Données en arabe') }} ({{ __('العربية') }})</h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="first_name_ar">{{ __('First Name') }}</label>
                                        <input type="text" id="first_name_ar" class="form-control @error('first_name_ar') is-invalid @enderror" name="first_name_ar" placeholder="{{ __('First Name in Arabic') }}" dir="rtl" value="{{ old('first_name_ar') }}">
                                        @error('first_name_ar')
                                        <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="last_name_ar">{{ __('Last Name') }}</label>
                                        <input type="text" id="last_name_ar" class="form-control @error('last_name_ar') is-invalid @enderror" name="last_name_ar" placeholder="{{ __('Last Name in Arabic') }}" dir="rtl" value="{{ old('last_name_ar') }}">
                                        @error('last_name_ar')
                                        <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-3">
                                <div class="card-header bg-info text-white">
                                    <h5 class="mb-0">{{ __('Données en français') }} ({{ __('Français') }})</h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="first_name_fr">{{ __('First Name') }}</label>
                                        <input type="text" id="first_name_fr" class="form-control @error('first_name_fr') is-invalid @enderror" name="first_name_fr" placeholder="{{ __('First Name in French') }}" value="{{ old('first_name_fr') }}">
                                        @error('first_name_fr')
                                        <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="last_name_fr">{{ __('Last Name') }}</label>
                                        <input type="text" id="last_name_fr" class="form-control @error('last_name_fr') is-invalid @enderror" name="last_name_fr" placeholder="{{ __('Last Name in French') }}" value="{{ old('last_name_fr') }}">
                                        @error('last_name_fr')
                                        <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="cin">{{ __('cin') }}</label>
                                <input type="text" id="cin" class="form-control @error('cin') is-invalid @enderror" name="cin" value="{{ old('cin') }}">
                                @error('cin')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary waves-effect waves-light">{{ __('Sauvgarder') }}</button>
                                <a href="{{ route('admin.mission_companions.index') }}" class="btn btn-secondary waves-effect waves-light ml-2">{{ __('Cancel') }}</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin.app>
