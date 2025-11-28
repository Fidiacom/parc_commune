{{-- Vehicle Images Component --}}
@props(['vehicule', 'showUpload' => true])

@if($showUpload)
{{-- Image Upload Form --}}
<div class="card mb-3">
    <div class="card-body">
        <h5 class="card-title">{{ __('Télécharger de nouvelles images') }}</h5>
        <form id="imageUploadForm" action="{{ route('admin.vehicule.images.add') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="vehicule_id" value="{{ $vehicule->getId() }}">
            <div class="form-group">
                <input type="file" class="form-control-file" name="images[]" id="imageInput" multiple accept="image/*">
                <small class="form-text text-muted">{{ __('Vous pouvez sélectionner plusieurs images. Taille maximum: 50MB par image') }}</small>
            </div>
            <button type="submit" class="btn btn-success waves-effect waves-light">
                <i class="fas fa-upload"></i> {{ __('Télécharger les images') }}
            </button>
        </form>
    </div>
</div>
@endif

{{-- Images Gallery --}}
@if($vehicule->images && $vehicule->images->count() > 0)
<div class="card">
    <div class="card-body">
        <h5 class="card-title mb-3">{{ __('Images du véhicule') }} ({{ $vehicule->images->count() }})</h5>
        
        <div class="row">
            @foreach($vehicule->images as $image)
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="position-relative">
                        <img src="{{ asset($image->getFilePath()) }}" alt="Vehicle Image" class="card-img-top" style="height: 200px; object-fit: cover;">
                        @if($image->getIsMain())
                        <span class="badge badge-success position-absolute" style="top: 10px; right: 10px;">
                            <i class="fas fa-star"></i> {{ __('Image principale') }}
                        </span>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="btn-group btn-group-sm" role="group">
                            @if(!$image->getIsMain())
                            <form action="{{ route('admin.vehicule.images.set-main') }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="vehicule_id" value="{{ $vehicule->getId() }}">
                                <input type="hidden" name="image_id" value="{{ $image->getId() }}">
                                <button type="submit" class="btn btn-primary btn-sm" title="{{ __('Définir comme image principale') }}">
                                    <i class="fas fa-star"></i> {{ __('Définir principale') }}
                                </button>
                            </form>
                            @endif
                            <a href="{{ asset($image->getFilePath()) }}" target="_blank" class="btn btn-info btn-sm" title="{{ __('Voir en taille réelle') }}">
                                <i class="fas fa-eye"></i> {{ __('Voir') }}
                            </a>
                            <form action="{{ route('admin.vehicule.images.delete', $image->getId()) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('Êtes-vous sûr de vouloir supprimer cette image?') }}');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" title="{{ __('Supprimer l\'image') }}">
                                    <i class="fas fa-trash"></i> {{ __('Supprimer') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@else
<div class="alert alert-info">
    <i class="fas fa-info-circle"></i> {{ __('Aucune image téléchargée pour le moment. Utilisez le formulaire ci-dessus pour télécharger des images.') }}
</div>
@endif

