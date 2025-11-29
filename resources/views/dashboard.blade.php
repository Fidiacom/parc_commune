<x-admin.app>

    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">{{ __('Tableau de bord') }}</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item active">{{ __('Tableau de bord') }}</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <i class="bx bx-layer float-right m-0 h2 text-muted"></i>
                        <h6 class="text-muted text-uppercase mt-0">{{ __('Vehicules') }}</h6>
                        <h3 class="mb-3" data-plugin="counterup">{{ $vehiculesCount }}</h3>

                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <i class="bx bx-dollar-circle float-right m-0 h2 text-muted"></i>
                        <h6 class="text-muted text-uppercase mt-0">{{ __('Conducteurs') }}</h6>
                        <h3 class="mb-3"><span data-plugin="counterup">{{ $driverCount }}</span></h3>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <i class="bx bx-bx bx-analyse float-right m-0 h2 text-muted"></i>
                        <h6 class="text-muted text-uppercase mt-0">{{ __('Orders de mission') }}</h6>
                        <h3 class="mb-3"><span data-plugin="counterup">{{ $missionOrderCount }}</span></h3>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <i class="bx bx-basket float-right m-0 h2 text-muted"></i>
                        <h6 class="text-muted text-uppercase mt-0">{{ __('Historiques des echanges') }}</h6>
                        <h3 class="mb-3" data-plugin="counterup">{{ $stockHistoriqueCount }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->

        <!-- Alerts Section -->
        @if(isset($vehiclesExceedingConsumption) && count($vehiclesExceedingConsumption) > 0)
        <div class="row">
            <div class="col-12">
                <div class="card border-danger">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-exclamation-triangle mr-2"></i>{{ __('Alertes - Consommation élevée') }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-danger mb-0">
                            <h6 class="alert-heading"><i class="fas fa-gas-pump mr-2"></i>{{ __('Véhicules dépassant la consommation maximale') }}</h6>
                            <hr>
                            <div class="table-responsive">
                                <table class="table table-sm table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Véhicule') }}</th>
                                            <th>{{ __('Consommation moyenne') }}</th>
                                            <th>{{ __('Consommation max') }}</th>
                                            <th>{{ __('Dépassement') }}</th>
                                            <th>{{ __('Actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($vehiclesExceedingConsumption as $item)
                                        <tr>
                                            <td>
                                                <strong>{{ $item['vehicule']->getBrand() }} {{ $item['vehicule']->getModel() }}</strong><br>
                                                <small class="text-muted">{{ $item['vehicule']->getMatricule() }}</small>
                                            </td>
                                            <td>
                                                @if($item['exceeds_km'])
                                                    <span class="badge badge-danger">
                                                        {{ number_format($item['average_consumption_km'], 2, ',', ' ') }} L/100km
                                                    </span>
                                                @elseif($item['exceeds_hour'])
                                                    <span class="badge badge-danger">
                                                        {{ number_format($item['average_consumption_hour'], 2, ',', ' ') }} L/H
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($item['exceeds_km'])
                                                    {{ number_format($item['max_consumption_km'], 2, ',', ' ') }} L/100km
                                                @elseif($item['exceeds_hour'])
                                                    {{ number_format($item['max_consumption_hour'], 2, ',', ' ') }} L/H
                                                @endif
                                            </td>
                                            <td>
                                                @if($item['excess_km'])
                                                    <span class="text-danger font-weight-bold">
                                                        +{{ number_format($item['excess_km'], 2, ',', ' ') }} L/100km
                                                    </span>
                                                @elseif($item['excess_hour'])
                                                    <span class="text-danger font-weight-bold">
                                                        +{{ number_format($item['excess_hour'], 2, ',', ' ') }} L/H
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.vehicule.show', $item['vehicule']->getId()) }}" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-eye mr-1"></i>{{ __('Voir détails') }}
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
            </div>
        </div>
        @endif

        <div class="row">


            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"> {{ __('Vehicules') }} </h4>

                        <table id="basic-datatable" class="table dt-responsive nowrap">
                            <thead>
                                <tr>
                                    <th>{{ __('marque') }}</th>
                                    <th>{{ __('model') }}</th>
                                    <th>{{ __('matricule') }}</th>
                                    <th>{{ __('total KM') }}</th>

                                    <th>{{ __('fuel type') }}</th>
                                </tr>
                            </thead>


                            <tbody>
                                @foreach ($vehicules as $vehicule)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.vehicule.show', $vehicule->getId()) }}">
                                            {{ $vehicule->getBrand() }}
                                        </a>
                                    </td>
                                    <td>{{ $vehicule->getModel() }}</td>
                                    <td>{{ $vehicule->getMatricule() }}</td>
                                    <td>{{ $vehicule->getTotalKm() }}</td>

                                    <td>{{ $vehicule->getFuelType() }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div> <!-- end col -->

            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ __('Historique De stock') }}</h4>


                        <table id="basic-datatable2" class="table dt-responsive nowrap">
                            <thead>
                                <tr>
                                    <th>{{ __('Stock') }}</th>
                                    <th>{{ __('Type') }}</th>
                                    <th>{{ __('Quantite') }}</th>
                                    <th>{{ __('Qte actuel') }}</th>
                                    <th>{{ __('Cree le') }}</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($historiques as $h)
                                <tr>
                                    <td>{{ isset($h->stock) ? $h->stock->name : 'deleted' }}</td>
                                    <td>
                                        {{ $h->type }}
                                        @if ($h->type == 'sortie')
                                        <a href="{{ route('admin.vehicule.edit', $h->vehicule_id) }}">
                                            {{ '('.$h->matricule.')' }}
                                        </a>
                                        @endif
                                    </td>
                                    <td>{{ $h->quantite }}</td>
                                    <td>{{ isset($h->stock) ? $h->stock->stock_actuel : '-----' }}</td>
                                    <td>{{ $h->created_at }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div> <!-- end col -->
        </div>

    </div> <!-- container-fluid -->

</x-admin.app>
