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
                        <i class="bx bx-user float-right m-0 h2 text-muted"></i>
                        <h6 class="text-muted text-uppercase mt-0">{{ __('Conducteurs') }}</h6>
                        <h3 class="mb-3"><span data-plugin="counterup">{{ $driverCount }}</span></h3>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <i class="bx bx-analyse float-right m-0 h2 text-muted"></i>
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

        <!-- Cost Statistics Row -->
        @if(isset($totalCosts))
        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <i class="bx bx-money float-right m-0 h2 text-success"></i>
                        <h6 class="text-muted text-uppercase mt-0">{{ __('Coûts totaux') }}</h6>
                        <h3 class="mb-3 text-success">{{ number_format($totalCosts['total_all_time'], 2, ',', ' ') }} {{ __('MAD') }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <i class="bx bx-calendar float-right m-0 h2 text-info"></i>
                        <h6 class="text-muted text-uppercase mt-0">{{ __('Ce mois') }}</h6>
                        <h3 class="mb-3 text-info">{{ number_format($totalCosts['total_this_month'], 2, ',', ' ') }} {{ __('MAD') }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <i class="bx bx-gas-pump float-right m-0 h2 text-warning"></i>
                        <h6 class="text-muted text-uppercase mt-0">{{ __('Coûts carburant') }}</h6>
                        <h3 class="mb-3 text-warning">{{ number_format($totalCosts['fuel_costs'], 2, ',', ' ') }} {{ __('MAD') }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <i class="bx bx-trending-up float-right m-0 h2 text-primary"></i>
                        <h6 class="text-muted text-uppercase mt-0">{{ __('Cette année') }}</h6>
                        <h3 class="mb-3 text-primary">{{ number_format($totalCosts['total_this_year'], 2, ',', ' ') }} {{ __('MAD') }}</h3>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <!-- end row -->

        <!-- Alerts Section -->
        <div class="row">
            <!-- High Consumption Alert -->
            @if(isset($vehiclesExceedingConsumption) && count($vehiclesExceedingConsumption) > 0)
            <div class="col-12 mb-3">
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
            @endif

            <!-- Expiring Insurance Alert -->
            @if(isset($vehiclesExpiringInsurance) && count($vehiclesExpiringInsurance) > 0)
            <div class="col-12 mb-3">
                <div class="card border-warning">
                    <div class="card-header bg-warning text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-shield-alt mr-2"></i>{{ __('Alertes - Assurance expirant') }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-warning mb-0">
                            <h6 class="alert-heading"><i class="fas fa-calendar-alt mr-2"></i>{{ __('Véhicules avec assurance expirant dans les 30 prochains jours') }}</h6>
                            <hr>
                            <div class="table-responsive">
                                <table class="table table-sm table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Véhicule') }}</th>
                                            <th>{{ __('Date d\'expiration') }}</th>
                                            <th>{{ __('Jours restants') }}</th>
                                            <th>{{ __('Actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($vehiclesExpiringInsurance as $item)
                                        <tr>
                                            <td>
                                                <strong>{{ $item['vehicule']->getBrand() }} {{ $item['vehicule']->getModel() }}</strong><br>
                                                <small class="text-muted">{{ $item['vehicule']->getMatricule() }}</small>
                                            </td>
                                            <td>
                                                <span class="badge {{ $item['is_expired'] ? 'badge-danger' : 'badge-warning' }}">
                                                    {{ $item['expiration_date'] }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($item['is_expired'])
                                                    <span class="text-danger font-weight-bold">{{ __('Expiré') }}</span>
                                                @else
                                                    <span class="text-warning font-weight-bold">{{ $item['days_until_expiration'] }} {{ __('jours') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.vehicule.show', $item['vehicule']->getId()) }}" class="btn btn-sm btn-warning">
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
            @endif

            <!-- Expiring Technical Visit Alert -->
            @if(isset($vehiclesExpiringTechnicalVisit) && count($vehiclesExpiringTechnicalVisit) > 0)
            <div class="col-12 mb-3">
                <div class="card border-info">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-clipboard-check mr-2"></i>{{ __('Alertes - Visite technique expirant') }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info mb-0">
                            <h6 class="alert-heading"><i class="fas fa-calendar-alt mr-2"></i>{{ __('Véhicules avec visite technique expirant dans les 30 prochains jours') }}</h6>
                            <hr>
                            <div class="table-responsive">
                                <table class="table table-sm table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Véhicule') }}</th>
                                            <th>{{ __('Date d\'expiration') }}</th>
                                            <th>{{ __('Jours restants') }}</th>
                                            <th>{{ __('Actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($vehiclesExpiringTechnicalVisit as $item)
                                        <tr>
                                            <td>
                                                <strong>{{ $item['vehicule']->getBrand() }} {{ $item['vehicule']->getModel() }}</strong><br>
                                                <small class="text-muted">{{ $item['vehicule']->getMatricule() }}</small>
                                            </td>
                                            <td>
                                                <span class="badge {{ $item['is_expired'] ? 'badge-danger' : 'badge-info' }}">
                                                    {{ $item['expiration_date'] }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($item['is_expired'])
                                                    <span class="text-danger font-weight-bold">{{ __('Expiré') }}</span>
                                                @else
                                                    <span class="text-info font-weight-bold">{{ $item['days_until_expiration'] }} {{ __('jours') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.vehicule.show', $item['vehicule']->getId()) }}" class="btn btn-sm btn-info">
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
            @endif

            <!-- Maintenance Needed Alert -->
            @if(isset($vehiclesNeedingMaintenance) && count($vehiclesNeedingMaintenance) > 0)
            <div class="col-12 mb-3">
                <div class="card border-primary">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-tools mr-2"></i>{{ __('Alertes - Maintenance nécessaire') }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-primary mb-0">
                            <h6 class="alert-heading"><i class="fas fa-wrench mr-2"></i>{{ __('Véhicules nécessitant une maintenance') }}</h6>
                            <hr>
                            <div class="table-responsive">
                                <table class="table table-sm table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Véhicule') }}</th>
                                            <th>{{ __('Type de maintenance') }}</th>
                                            <th>{{ __('KM actuel') }}</th>
                                            <th>{{ __('Seuil') }}</th>
                                            <th>{{ __('Actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($vehiclesNeedingMaintenance as $item)
                                        @foreach($item['maintenance_items'] as $maintenance)
                                        <tr>
                                            <td>
                                                <strong>{{ $item['vehicule']->getBrand() }} {{ $item['vehicule']->getModel() }}</strong><br>
                                                <small class="text-muted">{{ $item['vehicule']->getMatricule() }}</small>
                                            </td>
                                            <td>
                                                <span class="badge badge-primary">{{ $maintenance['message'] }}</span>
                                            </td>
                                            <td>{{ number_format($maintenance['current_km'], 0, ',', ' ') }} {{ __('KM') }}</td>
                                            <td>{{ number_format($maintenance['threshold_km'], 0, ',', ' ') }} {{ __('KM') }}</td>
                                            <td>
                                                <a href="{{ route('admin.vehicule.show', $item['vehicule']->getId()) }}" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-eye mr-1"></i>{{ __('Voir détails') }}
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Data Tables Row -->
        <div class="row">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ __('Derniers véhicules') }}</h4>
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
                                    <td>{{ number_format($vehicule->getTotalKm(), 0, ',', ' ') }}</td>
                                    <td>{{ $vehicule->getFuelType() }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">{{ __('Résumé des activités') }}</h4>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avatar-sm rounded-circle bg-soft-primary text-primary d-flex align-items-center justify-content-center">
                                            <i class="bx bx-car font-size-20"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1 text-muted">{{ __('Véhicules actifs') }}</h6>
                                        <h4 class="mb-0">{{ $vehiculesCount }}</h4>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avatar-sm rounded-circle bg-soft-info text-info d-flex align-items-center justify-content-center">
                                            <i class="bx bx-user font-size-20"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1 text-muted">{{ __('Conducteurs') }}</h6>
                                        <h4 class="mb-0">{{ $driverCount }}</h4>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avatar-sm rounded-circle bg-soft-warning text-warning d-flex align-items-center justify-content-center">
                                            <i class="bx bx-analyse font-size-20"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1 text-muted">{{ __('Missions actives') }}</h6>
                                        <h4 class="mb-0">{{ isset($activeMissionOrders) ? count($activeMissionOrders) : 0 }}</h4>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avatar-sm rounded-circle bg-soft-success text-success d-flex align-items-center justify-content-center">
                                            <i class="bx bx-receipt font-size-20"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1 text-muted">{{ __('Bons de paiement') }}</h6>
                                        <h4 class="mb-0">{{ isset($recentPaymentVouchers) ? count($recentPaymentVouchers) : 0 }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        @if(isset($totalCosts))
                        <hr>
                        <div class="row mt-3">
                            <div class="col-12">
                                <h6 class="text-muted mb-3">{{ __('Coûts ce mois') }}</h6>
                                <h3 class="text-primary mb-0">
                                    {{ number_format($totalCosts['total_this_month'], 2, ',', ' ') }} {{ __('MAD') }}
                                </h3>
                                <p class="text-muted mb-0 mt-2">
                                    <small>{{ __('Total cette année') }}: {{ number_format($totalCosts['total_this_year'], 2, ',', ' ') }} {{ __('MAD') }}</small>
                                </p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Missions and Recent Payments Row -->
        <div class="row">
            @if(isset($activeMissionOrders) && count($activeMissionOrders) > 0)
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ __('Missions actives') }}</h4>
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th>{{ __('Conducteur') }}</th>
                                        <th>{{ __('Véhicule') }}</th>
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
                                        <td>
                                            @if($order->vehicule)
                                                {{ $order->vehicule->getBrand() }} {{ $order->vehicule->getModel() }}
                                                <br><small class="text-muted">{{ $order->vehicule->getMatricule() }}</small>
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

            @if(isset($recentPaymentVouchers) && count($recentPaymentVouchers) > 0)
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ __('Derniers bons de paiement') }}</h4>
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th>{{ __('N° bon') }}</th>
                                        <th>{{ __('Véhicule') }}</th>
                                        <th>{{ __('Catégorie') }}</th>
                                        <th>{{ __('Montant') }}</th>
                                        <th>{{ __('Date') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentPaymentVouchers as $voucher)
                                    <tr>
                                        <td>{{ $voucher->getVoucherNumber() }}</td>
                                        <td>
                                            @if($voucher->vehicule)
                                                {{ $voucher->vehicule->getBrand() }} {{ $voucher->vehicule->getModel() }}
                                                <br><small class="text-muted">{{ $voucher->vehicule->getMatricule() }}</small>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
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
            @endif
        </div>

    </div> <!-- container-fluid -->

    <style>
        .avatar-sm {
            width: 48px;
            height: 48px;
        }
        .bg-soft-primary {
            background-color: rgba(52, 86, 122, 0.1);
        }
        .bg-soft-info {
            background-color: rgba(23, 162, 184, 0.1);
        }
        .bg-soft-warning {
            background-color: rgba(255, 193, 7, 0.1);
        }
        .bg-soft-success {
            background-color: rgba(40, 167, 69, 0.1);
        }
    </style>

    <script>
        $(document).ready(function() {
            // DataTables language configuration based on current locale
            var locale = '{{ app()->getLocale() }}';
            var dtLanguage = {};
            
            if (locale === 'ar') {
                dtLanguage = {
                    "sEmptyTable": "لا توجد بيانات متاحة في الجدول",
                    "sLoadingRecords": "جارٍ التحميل...",
                    "sProcessing": "جارٍ المعالجة...",
                    "sLengthMenu": "أظهر _MENU_ مدخلات",
                    "sZeroRecords": "لم يعثر على أية سجلات",
                    "sInfo": "إظهار _START_ إلى _END_ من أصل _TOTAL_ مدخل",
                    "sInfoEmpty": "يعرض 0 إلى 0 من أصل 0 سجل",
                    "sInfoFiltered": "(منتقاة من مجموع _MAX_ مُدخل)",
                    "sInfoPostFix": "",
                    "sSearch": "ابحث:",
                    "sUrl": "",
                    "oPaginate": {
                        "sFirst": "الأول",
                        "sPrevious": "السابق",
                        "sNext": "التالي",
                        "sLast": "الأخير"
                    },
                    "oAria": {
                        "sSortAscending": ": تفعيل لترتيب العمود تصاعدياً",
                        "sSortDescending": ": تفعيل لترتيب العمود تنازلياً"
                    }
                };
            } else if (locale === 'en') {
                dtLanguage = {
                    "sEmptyTable": "No data available in table",
                    "sLoadingRecords": "Loading...",
                    "sProcessing": "Processing...",
                    "sLengthMenu": "Show _MENU_ entries",
                    "sZeroRecords": "No matching records found",
                    "sInfo": "Showing _START_ to _END_ of _TOTAL_ entries",
                    "sInfoEmpty": "Showing 0 to 0 of 0 entries",
                    "sInfoFiltered": "(filtered from _MAX_ total entries)",
                    "sInfoPostFix": "",
                    "sSearch": "Search:",
                    "sUrl": "",
                    "oPaginate": {
                        "sFirst": "First",
                        "sPrevious": "Previous",
                        "sNext": "Next",
                        "sLast": "Last"
                    },
                    "oAria": {
                        "sSortAscending": ": activate to sort column ascending",
                        "sSortDescending": ": activate to sort column descending"
                    }
                };
            } else {
                // French (default)
                dtLanguage = {
                    "sEmptyTable": "Aucune donnée disponible dans le tableau",
                    "sLoadingRecords": "Chargement...",
                    "sProcessing": "Traitement en cours...",
                    "sLengthMenu": "Afficher _MENU_ entrées",
                    "sZeroRecords": "Aucun enregistrement correspondant trouvé",
                    "sInfo": "Affichage de l'élément _START_ à _END_ sur _TOTAL_ éléments",
                    "sInfoEmpty": "Affichage de l'élément 0 à 0 sur 0 élément",
                    "sInfoFiltered": "(filtré de _MAX_ éléments au total)",
                    "sInfoPostFix": "",
                    "sSearch": "Rechercher :",
                    "sUrl": "",
                    "oPaginate": {
                        "sFirst": "Premier",
                        "sPrevious": "Précédent",
                        "sNext": "Suivant",
                        "sLast": "Dernier"
                    },
                    "oAria": {
                        "sSortAscending": ": activer pour trier la colonne par ordre croissant",
                        "sSortDescending": ": activer pour trier la colonne par ordre décroissant"
                    }
                };
            }

            // Initialize basic-datatable
            var table1 = $('#basic-datatable').DataTable({
                "language": dtLanguage,
                "drawCallback": function () {
                    $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
                    // Apply RTL styles for Arabic
                    if (locale === 'ar') {
                        applyRTLStyles('#basic-datatable');
                    }
                }
            });
            
            // Apply RTL styles immediately for Arabic
            if (locale === 'ar') {
                setTimeout(function() {
                    applyRTLStyles('#basic-datatable');
                }, 100);
            }
            
            
            // Function to apply RTL styles to DataTables
            function applyRTLStyles(tableId) {
                var wrapper = $(tableId + '_wrapper');
                var filter = $(tableId + '_filter');
                var length = $(tableId + '_length');
                var info = $(tableId + '_info');
                
                wrapper.addClass('rtl-datatable');
                
                if (filter.length) {
                    filter.addClass('text-right');
                    filter.find('label').css({
                        'text-align': 'right',
                        'direction': 'rtl',
                        'float': 'right'
                    });
                    filter.find('input').css({
                        'margin-right': '0.5em',
                        'margin-left': '0',
                        'direction': 'rtl',
                        'text-align': 'right'
                    });
                }
                
                if (length.length) {
                    length.addClass('text-left');
                    length.find('label').css({
                        'text-align': 'left',
                        'direction': 'rtl'
                    });
                    length.find('select').css('direction', 'rtl');
                }
                
                if (info.length) {
                    info.css({
                        'direction': 'rtl',
                        'text-align': 'right'
                    });
                }
            }
        });
    </script>

</x-admin.app>
