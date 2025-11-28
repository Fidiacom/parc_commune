<x-admin.app>
    <div class="container-fluid">
        <!-- Page Title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="mb-1 font-size-18">
                            <i class="fas fa-recycle mr-2 text-primary"></i>{{ __('Détails de la réforme') }}
                        </h4>
                        <p class="text-muted mb-0">
                            {{ $reforme->getVehicule()->getBrand() }} {{ $reforme->getVehicule()->getModel() }} - {{ $reforme->getVehicule()->getMatricule() }}
                        </p>
                    </div>
                    <div>
                        <a href="{{ route('admin.reforme') }}" class="btn btn-outline-secondary mr-2">
                            <i class="fas fa-arrow-left mr-2"></i>{{ __('Retour') }}
                        </a>
                        <a href="{{ route('admin.reforme.edit', $reforme->getId()) }}" class="btn btn-primary">
                            <i class="fas fa-edit mr-2"></i>{{ __('Modifier') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Reforme Information -->
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4"><i class="fas fa-info-circle mr-2"></i>{{ __('Informations') }}</h5>
                        
                        <div class="mb-3">
                            <label class="text-muted">{{ __('Véhicule') }}</label>
                            <p class="mb-0 font-weight-semibold">
                                {{ $reforme->getVehicule()->getBrand() }} {{ $reforme->getVehicule()->getModel() }}
                            </p>
                            <small class="text-muted">{{ $reforme->getVehicule()->getMatricule() }}</small>
                        </div>
                        
                        <div class="mb-3">
                            <label class="text-muted">{{ __('Statut actuel') }}</label>
                            <div>
                                @php
                                    $statusColors = [
                                        'in_progress' => 'warning',
                                        'confirmed' => 'success',
                                        'rejected' => 'danger',
                                        'selled' => 'info'
                                    ];
                                    $statusLabels = [
                                        'in_progress' => __('En cours'),
                                        'confirmed' => __('Confirmé'),
                                        'rejected' => __('Rejeté'),
                                        'selled' => __('Vendu')
                                    ];
                                    $statusColor = $statusColors[$reforme->getStatus()] ?? 'secondary';
                                @endphp
                                <span class="badge badge-soft-{{ $statusColor }} badge-lg">
                                    {{ $statusLabels[$reforme->getStatus()] }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="text-muted">{{ __('Description') }}</label>
                            <p class="mb-0">{{ $reforme->getDescription() }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="text-muted">{{ __('Créé le') }}</label>
                            <p class="mb-0">{{ $reforme->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Attachments -->
                <div class="card mt-3">
                    <div class="card-body">
                        <h5 class="card-title mb-4">
                            <i class="fas fa-file-alt mr-2"></i>{{ __('Fichiers joints') }}
                        </h5>
                        
                        @if($reforme->attachments->count() > 0)
                            <div class="list-group">
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
                            
                            <form action="{{ route('admin.reforme.attachments.add') }}" method="POST" enctype="multipart/form-data" class="mt-3">
                                @csrf
                                <input type="hidden" name="reforme_id" value="{{ $reforme->getId() }}">
                                <div class="form-group">
                                    <input type="file" class="form-control" name="files[]" multiple>
                                </div>
                                <button type="submit" class="btn btn-sm btn-primary">
                                    <i class="fas fa-plus mr-1"></i>{{ __('Ajouter des fichiers') }}
                                </button>
                            </form>
                        @else
                            <p class="text-muted">{{ __('Aucun fichier joint') }}</p>
                            <form action="{{ route('admin.reforme.attachments.add') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="reforme_id" value="{{ $reforme->getId() }}">
                                <div class="form-group">
                                    <input type="file" class="form-control" name="files[]" multiple>
                                </div>
                                <button type="submit" class="btn btn-sm btn-primary">
                                    <i class="fas fa-plus mr-1"></i>{{ __('Ajouter des fichiers') }}
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Status History and Update -->
            <div class="col-xl-8">
                <!-- Update Status Form -->
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title mb-4">
                            <i class="fas fa-sync-alt mr-2"></i>{{ __('Mettre à jour le statut') }}
                        </h5>
                        
                        <form action="{{ route('admin.reforme.update-status', $reforme->getId()) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="form-group">
                                <label for="status">{{ __('Nouveau statut') }} <span class="text-danger">*</span></label>
                                <select class="form-control @error('status') is-invalid @enderror" name="status" id="status" required>
                                    <option value="in_progress" {{ $reforme->getStatus() == 'in_progress' ? 'selected' : '' }}>
                                        {{ __('En cours') }}
                                    </option>
                                    <option value="confirmed" {{ $reforme->getStatus() == 'confirmed' ? 'selected' : '' }}>
                                        {{ __('Confirmé') }}
                                    </option>
                                    <option value="rejected" {{ $reforme->getStatus() == 'rejected' ? 'selected' : '' }}>
                                        {{ __('Rejeté') }}
                                    </option>
                                    <option value="selled" {{ $reforme->getStatus() == 'selled' ? 'selected' : '' }}>
                                        {{ __('Vendu') }}
                                    </option>
                                </select>
                                @error('status')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="description">{{ __('Description du changement') }}</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          name="description" 
                                          id="description" 
                                          rows="3" 
                                          placeholder="{{ __('Décrivez le changement de statut...') }}">{{ old('description') }}</textarea>
                                @error('description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="status_files">{{ __('Fichiers joints') }}</label>
                                <input type="file" 
                                       class="form-control @error('files.*') is-invalid @enderror" 
                                       name="files[]" 
                                       id="status_files" 
                                       multiple 
                                       accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                <small class="form-text text-muted">
                                    {{ __('Vous pouvez joindre des fichiers pour ce changement de statut') }}
                                </small>
                                @error('files.*')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            
                            <button type="submit" class="btn btn-primary waves-effect waves-light">
                                <i class="fas fa-save mr-2"></i>{{ __('Mettre à jour le statut') }}
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Status History -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">
                            <i class="fas fa-history mr-2"></i>{{ __('Historique des statuts') }}
                        </h5>
                        
                        @if($reforme->statusHistoriques->count() > 0)
                            <div class="timeline">
                                @foreach($reforme->statusHistoriques->sortByDesc('created_at') as $historique)
                                <div class="timeline-item mb-4">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0">
                                            @php
                                                $statusColors = [
                                                    'in_progress' => 'warning',
                                                    'confirmed' => 'success',
                                                    'rejected' => 'danger',
                                                    'selled' => 'info'
                                                ];
                                                $statusLabels = [
                                                    'in_progress' => __('En cours'),
                                                    'confirmed' => __('Confirmé'),
                                                    'rejected' => __('Rejeté'),
                                                    'selled' => __('Vendu')
                                                ];
                                                $statusColor = $statusColors[$historique->getStatus()] ?? 'secondary';
                                            @endphp
                                            <div class="avatar-sm rounded-circle bg-soft-{{ $statusColor }} align-self-center">
                                                <span class="avatar-title bg-{{ $statusColor }} rounded-circle">
                                                    <i class="fas fa-circle font-size-10"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                                        <div>
                                                            <h6 class="mb-1">
                                                                <span class="badge badge-soft-{{ $statusColor }}">
                                                                    {{ $statusLabels[$historique->getStatus()] }}
                                                                </span>
                                                            </h6>
                                                            <p class="text-muted mb-0 small">
                                                                <i class="fas fa-clock mr-1"></i>
                                                                {{ $historique->created_at->format('d/m/Y H:i') }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    
                                                    @if($historique->getDescription())
                                                    <p class="mb-2">{{ $historique->getDescription() }}</p>
                                                    @endif
                                                    
                                                    @if($historique->attachments->count() > 0)
                                                    <div class="mt-2">
                                                        <small class="text-muted d-block mb-1">{{ __('Fichiers joints:') }}</small>
                                                        <div class="d-flex flex-wrap gap-2">
                                                            @foreach($historique->attachments as $attachment)
                                                            <div class="d-flex align-items-center">
                                                                <a href="{{ asset($attachment->getFilePath()) }}" 
                                                                   target="_blank" 
                                                                   class="btn btn-sm btn-outline-primary">
                                                                    <i class="fas fa-file mr-1"></i>
                                                                    {{ $attachment->getFileName() ?? 'Fichier' }}
                                                                </a>
                                                                <form action="{{ route('admin.reforme.status-attachments.delete', $attachment->getId()) }}" 
                                                                      method="POST" 
                                                                      class="d-inline ml-1"
                                                                      onsubmit="return confirm('{{ __('Êtes-vous sûr de vouloir supprimer ce fichier?') }}');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted">{{ __('Aucun historique disponible') }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin.app>

