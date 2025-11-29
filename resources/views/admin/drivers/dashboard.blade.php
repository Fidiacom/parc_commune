<x-admin.app>
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="mb-1 font-size-18">
                            <i class="fas fa-tachometer-alt mr-2 text-primary"></i>{{ __('Tableau de bord - Conducteur') }}
                        </h4>
                        <p class="text-muted mb-0">{{ $driver->getFirstNameFr() }} {{ $driver->getLastNameFr() }}</p>
                    </div>
                    <div>
                        <a href="{{ route('admin.driver.edit', $driver->getId()) }}" class="btn btn-outline-info mr-2">
                            <i class="fas fa-edit mr-2"></i>{{ __('Modifier') }}
                        </a>
                        <a href="{{ route('admin.drivers') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left mr-2"></i>{{ __('Retour') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <!-- Statistics Cards -->
        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <i class="bx bx-list-check float-right m-0 h2 text-primary"></i>
                        <h6 class="text-muted text-uppercase mt-0">{{ __('Total missions') }}</h6>
                        <h3 class="mb-3 text-primary">{{ $totalMissions }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <i class="bx bx-time float-right m-0 h2 text-warning"></i>
                        <h6 class="text-muted text-uppercase mt-0">{{ __('Missions actives') }}</h6>
                        <h3 class="mb-3 text-warning">{{ $activeMissionsCount }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <i class="bx bx-check-circle float-right m-0 h2 text-success"></i>
                        <h6 class="text-muted text-uppercase mt-0">{{ __('Missions terminées') }}</h6>
                        <h3 class="mb-3 text-success">{{ $completedMissionsCount }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <i class="bx bx-car float-right m-0 h2 text-info"></i>
                        <h6 class="text-muted text-uppercase mt-0">{{ __('Véhicules utilisés') }}</h6>
                        <h3 class="mb-3 text-info">{{ $vehiclesUsed->count() }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Driver Information -->
        <div class="row">
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4"><i class="fas fa-user mr-2"></i>{{ __('Informations du conducteur') }}</h5>
                        
                        <div class="mb-3">
                            <label class="text-muted">{{ __('Prénom') }}</label>
                            <p class="mb-0 font-weight-semibold">{{ $driver->getFirstNameFr() ?: $driver->getFirstNameAr() ?: '-' }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="text-muted">{{ __('Nom') }}</label>
                            <p class="mb-0 font-weight-semibold">{{ $driver->getLastNameFr() ?: $driver->getLastNameAr() ?: '-' }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="text-muted">{{ __('Rôle') }}</label>
                            <p class="mb-0 font-weight-semibold">{{ $driver->getRoleFr() ?: $driver->getRoleAr() ?: '-' }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="text-muted">{{ __('CIN') }}</label>
                            <p class="mb-0 font-weight-semibold">{{ $driver->getCin() ?: '-' }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="text-muted">{{ __('Téléphone') }}</label>
                            <p class="mb-0 font-weight-semibold">{{ $driver->getPhone() ?: '-' }}</p>
                        </div>

                        @if($driver->permis->count() > 0)
                        <div class="mb-3">
                            <label class="text-muted">{{ __('Catégories de permis') }}</label>
                            <div>
                                @foreach($driver->permis as $permi)
                                    <span class="badge badge-primary mr-1">{{ $permi->getLabel() }}</span>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Active Missions -->
            @if($activeMissionOrders->count() > 0)
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"><i class="fas fa-tasks mr-2"></i>{{ __('Missions actives') }}</h4>
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th>{{ __('Véhicule') }}</th>
                                        <th>{{ __('Mission') }}</th>
                                        <th>{{ __('Lieu') }}</th>
                                        <th>{{ __('Date début') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($activeMissionOrders as $order)
                                    <tr>
                                        <td>
                                            @if($order->vehicule)
                                                <strong>{{ $order->vehicule->getBrand() }} {{ $order->vehicule->getModel() }}</strong><br>
                                                <small class="text-muted">{{ $order->vehicule->getMatricule() }}</small>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>{{ $order->getMissionFr() ?: $order->getMissionAr() }}</td>
                                        <td>{{ $order->getPlaceTogoFr() ?: $order->getPlaceTogoAr() ?: '-' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($order->getStart())->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <a href="{{ route('admin.mission_order.edit', $order->getId()) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Recent Activity -->
        <div class="row">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"><i class="fas fa-history mr-2"></i>{{ __('Dernières missions') }}</h4>
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th>{{ __('Véhicule') }}</th>
                                        <th>{{ __('Mission') }}</th>
                                        <th>{{ __('Date début') }}</th>
                                        <th>{{ __('Statut') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentMissionOrders as $order)
                                    <tr>
                                        <td>
                                            @if($order->vehicule)
                                                {{ $order->vehicule->getBrand() }} {{ $order->vehicule->getModel() }}
                                                <br><small class="text-muted">{{ $order->vehicule->getMatricule() }}</small>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>{{ $order->getMissionFr() ?: $order->getMissionAr() }}</td>
                                        <td>{{ \Carbon\Carbon::parse($order->getStart())->format('d/m/Y') }}</td>
                                        <td>
                                            @if($order->getDoneAt())
                                                <span class="badge badge-success">{{ __('Terminée') }}</span>
                                            @else
                                                <span class="badge badge-warning">{{ __('Active') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.mission_order.edit', $order->getId()) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Vehicles Used -->
            @if($vehiclesUsed->count() > 0)
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"><i class="fas fa-car mr-2"></i>{{ __('Véhicules utilisés') }}</h4>
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th>{{ __('Marque') }}</th>
                                        <th>{{ __('Modèle') }}</th>
                                        <th>{{ __('Matricule') }}</th>
                                        <th>{{ __('Type carburant') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($vehiclesUsed as $vehicule)
                                    <tr>
                                        <td>{{ $vehicule->getBrand() }}</td>
                                        <td>{{ $vehicule->getModel() }}</td>
                                        <td>{{ $vehicule->getMatricule() }}</td>
                                        <td>{{ $vehicule->getFuelType() }}</td>
                                        <td>
                                            <a href="{{ route('admin.vehicule.show', $vehicule->getId()) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>

    </div>
</x-admin.app>

