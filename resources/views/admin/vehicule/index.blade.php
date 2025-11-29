<x-admin.app>

    <div class="container-fluid">
        <!-- Page Title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">
                        <i class="fas fa-car mr-2"></i>{{ __('Gestion des véhicules') }}
                    </h4>
                    <div class="page-title-right">
                        <a href="{{ route('admin.vehicule.create') }}" class="btn btn-primary waves-effect waves-light">
                            <i class="fas fa-plus-circle mr-2"></i>{{ __('Ajouter un véhicule') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h5 class="mb-0 text-muted">{{ __('Total véhicules') }}</h5>
                                <h3 class="mb-0 mt-2">{{ $vehicules->count() }}</h3>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-sm rounded-circle bg-soft-primary align-self-center">
                                    <span class="avatar-title bg-primary rounded-circle">
                                        <i class="fas fa-car font-size-20"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h5 class="mb-0 text-muted">{{ __('Avec fichiers') }}</h5>
                                <h3 class="mb-0 mt-2">{{ $vehicules->where('attachments_count', '>', 0)->count() }}</h3>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-sm rounded-circle bg-soft-success align-self-center">
                                    <span class="avatar-title bg-success rounded-circle">
                                        <i class="fas fa-file-alt font-size-20"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h5 class="mb-0 text-muted">{{ __('Essence') }}</h5>
                                <h3 class="mb-0 mt-2">{{ $vehicules->where('fuel_type', 'Essence')->count() }}</h3>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-sm rounded-circle bg-soft-warning align-self-center">
                                    <span class="avatar-title bg-warning rounded-circle">
                                        <i class="fas fa-gas-pump font-size-20"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h5 class="mb-0 text-muted">{{ __('Diesel') }}</h5>
                                <h3 class="mb-0 mt-2">{{ $vehicules->where('fuel_type', 'Diesel')->count() }}</h3>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-sm rounded-circle bg-soft-info align-self-center">
                                    <span class="avatar-title bg-info rounded-circle">
                                        <i class="fas fa-oil-can font-size-20"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Table Card -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Search and Filter Bar -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="search-box">
                                    <div class="position-relative">
                                        <input type="text" class="form-control" id="searchInput" placeholder="{{ __('Rechercher par marque, modèle, matricule...') }}">
                                        <i class="fas fa-search search-icon"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 text-right">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-outline-secondary btn-sm" id="filterAll">
                                        <i class="fas fa-list mr-1"></i>{{ __('Tous') }}
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm" id="filterWithFiles">
                                        <i class="fas fa-file-alt mr-1"></i>{{ __('Avec fichiers') }}
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Vehicles Table -->
                        <div class="table-responsive">
                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap w-100">
                                <thead class="thead-light">
                                    <tr>
                                        <th width="5%">
                                            <i class="fas fa-image mr-1"></i>
                                        </th>
                                        <th>{{ __('Marque') }}</th>
                                        <th>{{ __('Modèle') }}</th>
                                        <th>{{ __('Matricule') }}</th>
                                        <th>{{ __('Kilométrage') }}</th>
                                        <th>{{ __('Heures') }}</th>
                                        <th>{{ __('Type carburant') }}</th>
                                        <th>{{ __('Taille pneus') }}</th>
                                        <th>{{ __('Fichiers') }}</th>
                                        <th width="12%" class="text-center">{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($vehicules as $vehicule)
                                    <tr>
                                        <td class="text-center">
                                            @if($vehicule->images_count > 0)
                                                <i class="fas fa-image text-primary" title="{{ __('A des images') }}"></i>
                                            @else
                                                <i class="fas fa-image text-muted" title="{{ __('Pas d\'images') }}"></i>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.vehicule.edit', $vehicule->getId()) }}" class="text-dark font-weight-semibold">
                                                <i class="fas fa-car mr-1 text-primary"></i>{{ $vehicule->getBrand() }}
                                            </a>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info">{{ $vehicule->getModel() }}</span>
                                        </td>
                                        <td>
                                            <code class="text-dark">{{ $vehicule->getMatricule() }}</code>
                                        </td>
                                        <td>
                                            <span class="text-muted">
                                                <i class="fas fa-tachometer-alt mr-1"></i>
                                                {{ number_format((int)$vehicule->getTotalKm(), 0, '.', ' ') }} km
                                            </span>
                                        </td>
                                        <td>
                                            @if($vehicule->getTotalHours())
                                                <span class="text-muted">
                                                    <i class="fas fa-clock mr-1"></i>
                                                    {{ number_format((int)$vehicule->getTotalHours(), 0, '.', ' ') }} h
                                                </span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $fuelColors = [
                                                    'Essence' => 'warning',
                                                    'Diesel' => 'info',
                                                    'Eletric' => 'success'
                                                ];
                                                $fuelColor = $fuelColors[$vehicule->getFuelType()] ?? 'secondary';
                                            @endphp
                                            <span class="badge badge-soft-{{ $fuelColor }}">
                                                <i class="fas fa-gas-pump mr-1"></i>
                                                {{ $vehicule->getFuelType() }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($vehicule->getTireSize())
                                                <small class="text-muted">{{ $vehicule->getTireSize() }}</small>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($vehicule->attachments_count > 0)
                                                <span class="badge badge-success">
                                                    <i class="fas fa-file-alt mr-1"></i>
                                                    {{ $vehicule->attachments_count }}
                                                </span>
                                            @else
                                                <span class="badge badge-secondary">
                                                    <i class="fas fa-file mr-1"></i>0
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.vehicule.show', $vehicule->getId()) }}" 
                                                   class="btn btn-sm btn-info" 
                                                   data-toggle="tooltip" 
                                                   data-placement="top" 
                                                   title="{{ __('Voir') }}">
                                                    <i class="mdi mdi-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.vehicule.edit', $vehicule->getId()) }}" 
                                                   class="btn btn-sm btn-outline-primary" 
                                                   data-toggle="tooltip" 
                                                   data-placement="top" 
                                                   title="{{ __('Modifier') }}">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.vehicule.delete', $vehicule->getId()) }}" 
                                                      method="POST" 
                                                      class="d-inline"
                                                      onsubmit="return confirm('{{ __('Êtes-vous sûr de vouloir supprimer ce véhicule?') }}');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-sm btn-outline-danger" 
                                                            data-toggle="tooltip" 
                                                            data-placement="top" 
                                                            title="{{ __('Supprimer') }}">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="10" class="text-center py-5">
                                            <div class="py-4">
                                                <i class="fas fa-car font-size-48 text-muted mb-3"></i>
                                                <p class="text-muted font-size-16">{{ __('Aucun véhicule trouvé') }}</p>
                                                <a href="{{ route('admin.vehicule.create') }}" class="btn btn-primary mt-2">
                                                    <i class="fas fa-plus-circle mr-2"></i>{{ __('Ajouter le premier véhicule') }}
                                                </a>
                                            </div>
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

    <style>
        .search-box {
            position: relative;
        }
        .search-box .search-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }
        .search-box input {
            padding-right: 40px;
        }
        .table thead th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
        }
        .badge-soft-info {
            background-color: rgba(50, 138, 241, 0.1);
            color: #328af1;
        }
        .badge-soft-warning {
            background-color: rgba(241, 180, 76, 0.1);
            color: #f1b44c;
        }
        .badge-soft-success {
            background-color: rgba(16, 183, 89, 0.1);
            color: #10b759;
        }
        .avatar-sm {
            height: 3rem;
            width: 3rem;
        }
        .avatar-title {
            align-items: center;
            display: flex;
            height: 100%;
            justify-content: center;
            width: 100%;
        }
        .bg-soft-primary {
            background-color: rgba(85, 110, 230, 0.1) !important;
        }
        .bg-soft-success {
            background-color: rgba(16, 183, 89, 0.1) !important;
        }
        .bg-soft-warning {
            background-color: rgba(241, 180, 76, 0.1) !important;
        }
        .bg-soft-info {
            background-color: rgba(50, 138, 241, 0.1) !important;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Bootstrap tooltips
            $('[data-toggle="tooltip"]').tooltip();

            // Search functionality
            const searchInput = document.getElementById('searchInput');
            const table = document.querySelector('table tbody');
            
            if (searchInput && table) {
                searchInput.addEventListener('keyup', function() {
                    const filter = this.value.toLowerCase();
                    const rows = table.querySelectorAll('tr');
                    
                    rows.forEach(row => {
                        const text = row.textContent.toLowerCase();
                        row.style.display = text.includes(filter) ? '' : 'none';
                    });
                });
            }

            // Filter buttons
            const filterAll = document.getElementById('filterAll');
            const filterWithFiles = document.getElementById('filterWithFiles');
            
            if (filterAll && filterWithFiles) {
                filterAll.addEventListener('click', function() {
                    const rows = table.querySelectorAll('tr');
                    rows.forEach(row => {
                        row.style.display = '';
                    });
                    filterAll.classList.add('active');
                    filterWithFiles.classList.remove('active');
                });

                filterWithFiles.addEventListener('click', function() {
                    const rows = table.querySelectorAll('tr');
                    rows.forEach(row => {
                        const fileCount = row.querySelector('.badge-success');
                        row.style.display = fileCount ? '' : 'none';
                    });
                    filterWithFiles.classList.add('active');
                    filterAll.classList.remove('active');
                });
            }
        });
    </script>
</x-admin.app>
