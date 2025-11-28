<x-admin.app>
    <div class="container-fluid">
        <!-- Page Title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">
                        <i class="fas fa-recycle mr-2"></i>{{ __('Gestion des réformes') }}
                    </h4>
                    <div class="page-title-right">
                        <a href="{{ route('admin.reforme.create') }}" class="btn btn-primary waves-effect waves-light">
                            <i class="fas fa-plus-circle mr-2"></i>{{ __('Nouvelle réforme') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Table Card -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap w-100">
                                <thead class="thead-light">
                                    <tr>
                                        <th>{{ __('Véhicule') }}</th>
                                        <th>{{ __('Matricule') }}</th>
                                        <th>{{ __('Description') }}</th>
                                        <th>{{ __('Statut') }}</th>
                                        <th>{{ __('Fichiers') }}</th>
                                        <th>{{ __('Créé le') }}</th>
                                        <th width="15%" class="text-center">{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($reformes as $reforme)
                                    <tr>
                                        <td>
                                            <a href="{{ route('admin.reforme.show', $reforme->getId()) }}" class="text-dark font-weight-semibold">
                                                <i class="fas fa-car mr-1 text-primary"></i>
                                                {{ $reforme->getVehicule()->getBrand() }} - {{ $reforme->getVehicule()->getModel() }}
                                            </a>
                                        </td>
                                        <td>
                                            <code class="text-dark">{{ $reforme->getVehicule()->getMatricule() }}</code>
                                        </td>
                                        <td>
                                            <span class="text-muted">{{ Str::limit($reforme->getDescription(), 50) }}</span>
                                        </td>
                                        <td>
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
                                            <span class="badge badge-soft-{{ $statusColor }}">
                                                {{ $statusLabels[$reforme->getStatus()] }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($reforme->attachments->count() > 0)
                                                <span class="badge badge-soft-info">
                                                    <i class="fas fa-file-alt mr-1"></i>{{ $reforme->attachments->count() }}
                                                </span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="text-muted">{{ $reforme->created_at->format('d/m/Y H:i') }}</span>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.reforme.show', $reforme->getId()) }}" 
                                               class="btn btn-sm btn-info" 
                                               title="{{ __('Voir') }}">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.reforme.edit', $reforme->getId()) }}" 
                                               class="btn btn-sm btn-warning" 
                                               title="{{ __('Modifier') }}">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.reforme.delete', $reforme->getId()) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('{{ __('Êtes-vous sûr de vouloir supprimer cette réforme?') }}');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-danger" 
                                                        title="{{ __('Supprimer') }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            <p class="text-muted mt-3">{{ __('Aucune réforme trouvée') }}</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin.app>

