<x-admin.app>
    <div class="container-fluid">
        <!-- Page Title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">{{ __('Modifier la réforme') }}</h4>
                    <div class="page-title-right">
                        <a href="{{ route('admin.reforme.show', $reforme->getId()) }}" class="btn btn-secondary waves-effect waves-light">
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
                        <form action="{{ route('admin.reforme.update', $reforme->getId()) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="form-group">
                                <label for="vehicule_id">{{ __('Véhicule') }}</label>
                                <input type="text" 
                                       class="form-control" 
                                       value="{{ $reforme->getVehicule()->getBrand() }} {{ $reforme->getVehicule()->getModel() }} - {{ $reforme->getVehicule()->getMatricule() }}" 
                                       disabled>
                                <small class="text-muted">{{ __('Le véhicule ne peut pas être modifié') }}</small>
                            </div>

                            <div class="form-group">
                                <label for="description">{{ __('Description') }} <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          name="description" 
                                          id="description" 
                                          rows="5" 
                                          placeholder="{{ __('Décrivez la raison de la réforme...') }}" 
                                          required>{{ old('description', $reforme->getDescription()) }}</textarea>
                                @error('description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>{{ __('Fichiers joints actuels') }}</label>
                                @if($reforme->attachments->count() > 0)
                                    <div class="list-group mb-2">
                                        @foreach($reforme->attachments as $attachment)
                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <i class="fas fa-file mr-2"></i>
                                                <a href="{{ asset($attachment->getFilePath()) }}" target="_blank" class="text-primary">
                                                    {{ $attachment->getFileName() ?? 'Fichier' }}
                                                </a>
                                            </div>
                                            <form action="{{ route('admin.reforme.attachments.delete', $attachment->getId()) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('{{ __('Êtes-vous sûr de vouloir supprimer ce fichier?') }}');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-muted">{{ __('Aucun fichier joint') }}</p>
                                @endif
                                
                                <label for="files">{{ __('Ajouter de nouveaux fichiers') }}</label>
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
                                <a href="{{ route('admin.reforme.show', $reforme->getId()) }}" class="btn btn-secondary waves-effect waves-light">
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

