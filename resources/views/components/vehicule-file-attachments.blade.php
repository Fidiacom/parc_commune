{{-- Vehicle File Attachments Component --}}
@props(['vehicule', 'showUpload' => true])

@if($showUpload)
{{-- File Upload Form --}}
<div class="card mb-3">
    <div class="card-body">
        <h5 class="card-title">{{ __('Télécharger de nouveaux fichiers') }}</h5>
        <form id="fileUploadForm" action="{{ route('admin.vehicule.attachments.add') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="vehicule_id" value="{{ $vehicule->getId() }}">
            <div class="form-group">
                <input type="file" class="form-control-file" name="files[]" id="fileInput" multiple accept="image/*,.pdf,.doc,.docx">
                <small class="form-text text-muted">{{ __('Vous pouvez sélectionner plusieurs fichiers. Taille maximum: 50MB par fichier') }}</small>
            </div>
            <button type="submit" class="btn btn-success waves-effect waves-light">
                <i class="fas fa-upload"></i> {{ __('Télécharger les fichiers') }}
            </button>
        </form>
    </div>
</div>
@endif

{{-- Files Slider --}}
@if($vehicule->attachments && $vehicule->attachments->count() > 0)
<div class="card">
    <div class="card-body">
        <h5 class="card-title mb-3">{{ __('Fichiers téléchargés') }} ({{ $vehicule->attachments->count() }})</h5>
        
        <div class="position-relative">
            <div id="filesCarousel" class="carousel slide" data-ride="carousel" data-interval="false" style="width: 100%;">
                <div class="carousel-inner" style="min-height: 350px;">
                    @foreach($vehicule->attachments as $index => $attachment)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                        <div class="d-flex flex-column justify-content-center align-items-center" style="min-height: 350px; background-color: #f8f9fa; padding: 20px;">
                            @php
                                $fileExtension = strtolower(pathinfo($attachment->getFilePath(), PATHINFO_EXTENSION));
                                $isImage = in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                            @endphp
                            
                            @if($isImage)
                                <img src="{{ asset($attachment->getFilePath()) }}" alt="File {{ $index + 1 }}" class="img-fluid" style="max-height: 300px; max-width: 100%; object-fit: contain; border-radius: 4px;">
                            @else
                                <div class="text-center">
                                    <i class="fas fa-file fa-5x text-primary mb-3"></i>
                                    <p class="mb-0 font-weight-bold">{{ strtoupper($fileExtension) }} {{ __('Fichier') }}</p>
                                    <a href="{{ asset($attachment->getFilePath()) }}" target="_blank" class="btn btn-sm btn-primary mt-2">
                                        <i class="fas fa-download"></i> {{ __('Télécharger') }}
                                    </a>
                                </div>
                            @endif
                            
                            <div class="text-center mt-3">
                                <form action="{{ route('admin.vehicule.attachments.delete', $attachment->getId()) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('Êtes-vous sûr de vouloir supprimer ce fichier?') }}');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm waves-effect waves-light">
                                        <i class="fas fa-trash"></i> {{ __('Supprimer') }}
                                    </button>
                                </form>
                                @if($isImage)
                                <a href="{{ asset($attachment->getFilePath()) }}" target="_blank" class="btn btn-primary btn-sm waves-effect waves-light ml-2">
                                    <i class="fas fa-external-link-alt"></i> {{ __('Voir en taille réelle') }}
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                @if($vehicule->attachments->count() > 1)
                <a class="carousel-control-prev" href="#filesCarousel" role="button" data-slide="prev" style="width: 5%; background-color: rgba(0,0,0,0.3);">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">{{ __('Précédent') }}</span>
                </a>
                <a class="carousel-control-next" href="#filesCarousel" role="button" data-slide="next" style="width: 5%; background-color: rgba(0,0,0,0.3);">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">{{ __('Suivant') }}</span>
                </a>
                
                <ol class="carousel-indicators" style="bottom: 35px;">
                    @foreach($vehicule->attachments as $index => $attachment)
                    <li data-target="#filesCarousel" data-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}" style="background-color: #007bff; border: 2px solid #007bff;"></li>
                    @endforeach
                </ol>
                <style>
                    #filesCarousel .carousel-indicators li.active {
                        background-color: #0056b3 !important;
                        border-color: #0056b3 !important;
                    }
                    #filesCarousel .carousel-indicators li:not(.active) {
                        background-color: rgba(0, 123, 255, 0.5) !important;
                        border-color: rgba(0, 123, 255, 0.5) !important;
                    }
                </style>
                @endif
            </div>
        </div>
    </div>
</div>
@else
<div class="alert alert-info">
    <i class="fas fa-info-circle"></i> {{ __('Aucun fichier téléchargé pour le moment. Utilisez le formulaire ci-dessus pour télécharger des fichiers.') }}
</div>
@endif

@if($vehicule->attachments && $vehicule->attachments->count() > 0)
<script>
    (function() {
        // Ensure carousel is initialized after DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initCarousel);
        } else {
            initCarousel();
        }
        
        function initCarousel() {
            var carousel = document.getElementById('filesCarousel');
            if (carousel && typeof $ !== 'undefined' && $.fn.carousel) {
                $(carousel).carousel({
                    interval: false,
                    wrap: true
                });
            }
        }
    })();
</script>
@endif

