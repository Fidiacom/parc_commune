<x-admin.app>
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">{{ __('Modifier la catégorie de permis') }}</h4>
                
                <form action="{{ route('admin.categorie_permis.update', $categorie->getId()) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group">
                        <label class="font-weight-semibold">{{ __('Libellé') }} <span class="text-danger">*</span></label>
                        <input type="text" 
                               name="label" 
                               class="form-control @error('label') is-invalid @enderror" 
                               value="{{ old('label', $categorie->getLabel()) }}" 
                               placeholder="{{ __('Ex: A, B, C, D, E') }}"
                               required>
                        @error('label')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">{{ __('Entrez le libellé de la catégorie de permis (ex: A, B, C, D, E)') }}</small>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">
                            {{ __('Mettre à jour') }}
                        </button>
                        <a href="{{ route('admin.categorie_permis.index') }}" class="btn btn-secondary waves-effect waves-light">
                            {{ __('Annuler') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin.app>

