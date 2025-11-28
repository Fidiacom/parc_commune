<x-admin.app>
    <div class="container-fluid">
        <!-- Page Title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">{{ __('Nouvelle réforme') }}</h4>
                    <div class="page-title-right">
                        <a href="{{ route('admin.reforme') }}" class="btn btn-secondary waves-effect waves-light">
                            <i class="fas fa-arrow-left mr-2"></i>{{ __('Retour') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-8 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.reforme.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="form-group">
                                <label for="vehicule_id">{{ __('Véhicule') }} <span class="text-danger">*</span></label>
                                <select class="form-control @error('vehicule_id') is-invalid @enderror" 
                                        data-toggle="select2" 
                                        style="width: 100%" 
                                        name="vehicule_id" 
                                        id="vehicule_id" 
                                        required>
                                    <option value="0">{{ __('Sélectionner un véhicule') }}</option>
                                    @foreach ($vehicules as $vehicule)
                                        <option value="{{ $vehicule->getId() }}" {{ old('vehicule_id') == $vehicule->getId() ? 'selected' : '' }}>
                                            {{ $vehicule->getBrand() }} - {{ $vehicule->getModel() }} - {{ $vehicule->getMatricule() }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('vehicule_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="description">{{ __('Description') }} <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          name="description" 
                                          id="description" 
                                          rows="5" 
                                          placeholder="{{ __('Décrivez la raison de la réforme...') }}" 
                                          required>{{ old('description') }}</textarea>
                                @error('description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="files">{{ __('Fichiers joints') }}</label>
                                <input type="file" 
                                       class="form-control @error('files.*') is-invalid @enderror" 
                                       name="files[]" 
                                       id="files" 
                                       multiple 
                                       accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                <small class="form-text text-muted">
                                    {{ __('Vous pouvez sélectionner plusieurs fichiers. Taille maximale: 50MB par fichier') }}
                                </small>
                                @error('files.*')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary waves-effect waves-light">
                                    <i class="fas fa-save mr-2"></i>{{ __('Enregistrer') }}
                                </button>
                                <a href="{{ route('admin.reforme') }}" class="btn btn-secondary waves-effect waves-light">
                                    {{ __('Annuler') }}
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin.app>


