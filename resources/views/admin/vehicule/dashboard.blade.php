<x-admin.app>
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="mb-1 font-size-18">
                            <i class="fas fa-tachometer-alt mr-2 text-primary"></i>{{ __('Tableau de bord - Véhicule') }}
                        </h4>
                        <p class="text-muted mb-0">{{ $vehicule->getBrand() }} {{ $vehicule->getModel() }} - {{ $vehicule->getMatricule() }}</p>
                    </div>
                    <div>
                        <a href="{{ route('admin.vehicule.show', $vehicule->getId()) }}" class="btn btn-outline-info mr-2">
                            <i class="fas fa-eye mr-2"></i>{{ __('Détails') }}
                        </a>
                        <a href="{{ route('admin.vehicule') }}" class="btn btn-outline-secondary">
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
                        <i class="bx bx-line-chart float-right m-0 h2 text-primary"></i>
                        <h6 class="text-muted text-uppercase mt-0">{{ __('Kilométrage total') }}</h6>
                        <h3 class="mb-3 text-primary">{{ number_format($vehicule->getTotalKm(), 0, ',', ' ') }} {{ __('KM') }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <i class="bx bx-money float-right m-0 h2 text-success"></i>
                        <h6 class="text-muted text-uppercase mt-0">{{ __('Coûts totaux') }}</h6>
                        <h3 class="mb-3 text-success">{{ number_format(array_sum($costsByCategory), 2, ',', ' ') }} {{ __('MAD') }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <i class="bx bx-gas-pump float-right m-0 h2 text-warning"></i>
                        <h6 class="text-muted text-uppercase mt-0">{{ __('Coûts carburant') }}</h6>
                        <h3 class="mb-3 text-warning">{{ number_format($costsByCategory['carburant'] ?? 0, 2, ',', ' ') }} {{ __('MAD') }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <i class="bx bx-analyse float-right m-0 h2 text-info"></i>
                        <h6 class="text-muted text-uppercase mt-0">{{ __('Missions actives') }}</h6>
                        <h3 class="mb-3 text-info">{{ $activeMissionOrders->count() }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Consumption Statistics -->
        @if($consumptionStats['average_consumption_100km'] || $consumptionStats['average_consumption_hour'])
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4"><i class="fas fa-chart-line mr-2"></i>{{ __('Statistiques de consommation') }}</h4>
                        <div class="row">
                            @if($consumptionStats['average_consumption_100km'])
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h6 class="text-muted">{{ __('Consommation moyenne') }}</h6>
                                    <h3 class="text-primary">{{ number_format($consumptionStats['average_consumption_100km'], 2, ',', ' ') }} L/100km</h3>
                                </div>
                            </div>
                            @endif
                            @if($consumptionStats['average_consumption_hour'])
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h6 class="text-muted">{{ __('Consommation moyenne (heures)') }}</h6>
                                    <h3 class="text-primary">{{ number_format($consumptionStats['average_consumption_hour'], 2, ',', ' ') }} L/H</h3>
                                </div>
                            </div>
                            @endif
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h6 class="text-muted">{{ __('Total carburant') }}</h6>
                                    <h3 class="text-info">{{ number_format($consumptionStats['total_fuel_liters'], 2, ',', ' ') }} L</h3>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h6 class="text-muted">{{ __('Prix moyen par litre') }}</h6>
                                    <h3 class="text-success">{{ number_format($consumptionStats['average_price_per_liter'] ?? 0, 2, ',', ' ') }} {{ __('MAD') }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Alerts Section -->
        @if(count($maintenanceAlerts) > 0)
        <div class="row">
            <div class="col-12">
                <div class="card border-warning">
                    <div class="card-header bg-warning text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-exclamation-triangle mr-2"></i>{{ __('Alertes de maintenance') }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>{{ __('Type de maintenance') }}</th>
                                        <th>{{ __('KM actuel') }}</th>
                                        <th>{{ __('Seuil') }}</th>
                                        <th>{{ __('Dépassement') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($maintenanceAlerts as $alert)
                                    <tr>
                                        <td><span class="badge badge-warning">{{ $alert['message'] }}</span></td>
                                        <td>{{ number_format($alert['current_km'], 0, ',', ' ') }} {{ __('KM') }}</td>
                                        <td>{{ number_format($alert['threshold_km'], 0, ',', ' ') }} {{ __('KM') }}</td>
                                        <td><span class="text-danger font-weight-bold">+{{ number_format($alert['overdue_km'], 0, ',', ' ') }} {{ __('KM') }}</span></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Insurance and Technical Visit -->
        <div class="row">
            @if($latestInsurance)
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-shield-alt mr-2"></i>{{ __('Assurance') }}</h5>
                        <p class="mb-1"><strong>{{ __('Date d\'expiration') }}:</strong></p>
                        <p class="text-{{ \Carbon\Carbon::parse($latestInsurance->getInsuranceExpirationDate())->isPast() ? 'danger' : 'success' }}">
                            {{ \Carbon\Carbon::parse($latestInsurance->getInsuranceExpirationDate())->format('d/m/Y') }}
                        </p>
                        @if(\Carbon\Carbon::parse($latestInsurance->getInsuranceExpirationDate())->isPast())
                            <span class="badge badge-danger">{{ __('Expiré') }}</span>
                        @else
                            <span class="badge badge-success">{{ __('Valide') }}</span>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            @if($latestTechnicalVisit)
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-clipboard-check mr-2"></i>{{ __('Visite technique') }}</h5>
                        <p class="mb-1"><strong>{{ __('Date d\'expiration') }}:</strong></p>
                        <p class="text-{{ \Carbon\Carbon::parse($latestTechnicalVisit->getTechnicalVisitExpirationDate())->isPast() ? 'danger' : 'success' }}">
                            {{ \Carbon\Carbon::parse($latestTechnicalVisit->getTechnicalVisitExpirationDate())->format('d/m/Y') }}
                        </p>
                        @if(\Carbon\Carbon::parse($latestTechnicalVisit->getTechnicalVisitExpirationDate())->isPast())
                            <span class="badge badge-danger">{{ __('Expiré') }}</span>
                        @else
                            <span class="badge badge-success">{{ __('Valide') }}</span>
                        @endif
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Active Missions and Recent Activity -->
        <div class="row">
            @if($activeMissionOrders->count() > 0)
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ __('Missions actives') }}</h4>
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th>{{ __('Conducteur') }}</th>
                                        <th>{{ __('Mission') }}</th>
                                        <th>{{ __('Date début') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($activeMissionOrders as $order)
                                    <tr>
                                        <td>
                                            @if($order->driver)
                                                {{ $order->driver->getFirstNameFr() }} {{ $order->driver->getLastNameFr() }}
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>{{ $order->getMissionFr() }}</td>
                                        <td>{{ \Carbon\Carbon::parse($order->getStart())->format('d/m/Y') }}</td>
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

            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ __('Derniers bons de paiement') }}</h4>
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th>{{ __('N° bon') }}</th>
                                        <th>{{ __('Catégorie') }}</th>
                                        <th>{{ __('Montant') }}</th>
                                        <th>{{ __('Date') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentVouchers as $voucher)
                                    <tr>
                                        <td>{{ $voucher->getVoucherNumber() }}</td>
                                        <td><span class="badge badge-info">{{ ucfirst($voucher->getCategory()) }}</span></td>
                                        <td>{{ number_format($voucher->getAmount(), 2, ',', ' ') }} {{ __('MAD') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($voucher->getInvoiceDate())->format('d/m/Y') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Costs by Category -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ __('Coûts par catégorie') }}</h4>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>{{ __('Catégorie') }}</th>
                                        <th>{{ __('Montant total') }}</th>
                                        <th>{{ __('Nombre de bons') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($costsByCategory as $category => $amount)
                                    <tr>
                                        <td><span class="badge badge-primary">{{ ucfirst($category) }}</span></td>
                                        <td><strong>{{ number_format($amount, 2, ',', ' ') }} {{ __('MAD') }}</strong></td>
                                        <td>{{ $vouchersByCategory[$category]->count() }}</td>
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
</x-admin.app>

