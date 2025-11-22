{{-- Vehicle File Attachments Component --}}
@props(['vehicule', 'showUpload' => true])

@if($showUpload)
{{-- File Upload Form --}}
<div class="card mb-3">
    <div class="card-body">
        <h5 class="card-title">{{ __('Upload New Files') }}</h5>
        <form id="fileUploadForm" action="{{ route('admin.vehicule.files.upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="vehicule_id" value="{{ Crypt::encrypt($vehicule->getId()) }}">
            <div class="form-group">
                <input type="file" class="form-control-file" name="files[]" id="fileInput" multiple accept="image/*,.pdf,.doc,.docx">
                <small class="form-text text-muted">{{ __('You can select multiple files. Max size: 10MB per file') }}</small>
            </div>
            <button type="submit" class="btn btn-success waves-effect waves-light">
                <i class="fas fa-upload"></i> {{ __('Upload Files') }}
            </button>
        </form>
    </div>
</div>
@endif

{{-- Files Slider --}}
@if($vehicule->attachments && $vehicule->attachments->count() > 0)
<div class="card">
    <div class="card-body">
        <h5 class="card-title mb-3">{{ __('Uploaded Files') }} ({{ $vehicule->attachments->count() }})</h5>
        
        <div id="filesCarousel" class="carousel slide" data-ride="carousel" data-interval="false">
            <div class="carousel-inner">
                @foreach($vehicule->attachments as $index => $attachment)
                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                    <div class="d-flex justify-content-center align-items-center" style="min-height: 300px; background-color: #f8f9fa;">
                        @php
                            $fileExtension = strtolower(pathinfo($attachment->getFilePath(), PATHINFO_EXTENSION));
                            $isImage = in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                        @endphp
                        
                        @if($isImage)
                            <img src="{{ asset($attachment->getFilePath()) }}" alt="File {{ $index + 1 }}" class="img-fluid" style="max-height: 300px; max-width: 100%; object-fit: contain;">
                        @else
                            <div class="text-center">
                                <i class="fas fa-file fa-5x text-primary mb-3"></i>
                                <p class="mb-0">{{ strtoupper($fileExtension) }} {{ __('File') }}</p>
                                <a href="{{ asset($attachment->getFilePath()) }}" target="_blank" class="btn btn-sm btn-primary mt-2">
                                    <i class="fas fa-download"></i> {{ __('Download') }}
                                </a>
                            </div>
                        @endif
                    </div>
                    <div class="text-center mt-3">
                        <form action="{{ route('admin.vehicule.files.delete', Crypt::encrypt($attachment->getId())) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('Are you sure you want to delete this file?') }}');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm waves-effect waves-light">
                                <i class="fas fa-trash"></i> {{ __('Delete') }}
                            </button>
                        </form>
                        @if($isImage)
                        <a href="{{ asset($attachment->getFilePath()) }}" target="_blank" class="btn btn-primary btn-sm waves-effect waves-light ml-2">
                            <i class="fas fa-external-link-alt"></i> {{ __('View Full Size') }}
                        </a>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            
            @if($vehicule->attachments->count() > 1)
            <a class="carousel-control-prev" href="#filesCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">{{ __('Previous') }}</span>
            </a>
            <a class="carousel-control-next" href="#filesCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">{{ __('Next') }}</span>
            </a>
            
            <ol class="carousel-indicators">
                @foreach($vehicule->attachments as $index => $attachment)
                <li data-target="#filesCarousel" data-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}"></li>
                @endforeach
            </ol>
            @endif
        </div>
    </div>
</div>
@else
<div class="alert alert-info">
    <i class="fas fa-info-circle"></i> {{ __('No files uploaded yet. Use the form above to upload files.') }}
</div>
@endif

