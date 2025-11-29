<x-admin.app>
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="mb-1 font-size-18">
                            <i class="fas fa-car mr-2 text-primary"></i>{{ __('Détails du véhicule') }}
                        </h4>
                        <p class="text-muted mb-0">{{ $vehicule->getBrand() }} {{ $vehicule->getModel() }} - {{ $vehicule->getMatricule() }}</p>
                    </div>
                    <div>
                        <a href="{{ route('admin.vehicule') }}" class="btn btn-outline-secondary mr-2">
                            <i class="fas fa-arrow-left mr-2"></i>{{ __('Retour') }}
                        </a>
                        <a href="{{ route('admin.vehicule.edit', $vehicule->getId()) }}" class="btn btn-primary">
                            <i class="fas fa-edit mr-2"></i>{{ __('Modifier') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <!-- Vehicle Information -->
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4"><i class="fas fa-info-circle mr-2"></i>{{ __('Informations du véhicule') }}</h5>
                        
                        <div class="mb-3">
                            <label class="text-muted">{{ __('Marque') }}</label>
                            <p class="mb-0 font-weight-semibold">{{ $vehicule->getBrand() }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="text-muted">{{ __('Modèle') }}</label>
                            <p class="mb-0 font-weight-semibold">{{ $vehicule->getModel() }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="text-muted">{{ __('Matricule') }}</label>
                            <p class="mb-0 font-weight-semibold">{{ $vehicule->getMatricule() }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="text-muted">{{ __('Numéro de châssis') }}</label>
                            <p class="mb-0 font-weight-semibold">{{ $vehicule->getNumChassis() ?? '-' }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="text-muted">{{ __('Kilométrage actuel') }}</label>
                            <p class="mb-0 font-weight-semibold">{{ number_format($vehicule->getTotalKm(), 0, ',', ' ') }} {{ __('KM') }}</p>
                        </div>
                        
                        @if($vehicule->getTotalHours())
                        <div class="mb-3">
                            <label class="text-muted">{{ __('Heures totales') }}</label>
                            <p class="mb-0 font-weight-semibold">{{ number_format($vehicule->getTotalHours(), 0, ',', ' ') }} H</p>
                        </div>
                        @endif
                        
                        <div class="mb-3">
                            <label class="text-muted">{{ __('Type de carburant') }}</label>
                            <p class="mb-0 font-weight-semibold">{{ $vehicule->getFuelType() }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="text-muted">{{ __('Puissance') }}</label>
                            <p class="mb-0 font-weight-semibold">{{ $vehicule->getHorses() }} {{ __('CV') }}</p>
                        </div>
                        
                        @if($vehicule->getMinFuelConsumption100km() && $vehicule->getMaxFuelConsumption100km())
                        <div class="mb-3">
                            <label class="text-muted">{{ __('Consommation normale (KM)') }}</label>
                            <p class="mb-0 font-weight-semibold">
                                {{ $vehicule->getMinFuelConsumption100km() }} - {{ $vehicule->getMaxFuelConsumption100km() }} L/100km
                            </p>
                        </div>
                        @endif
                        @if($vehicule->getMinFuelConsumptionHour() && $vehicule->getMaxFuelConsumptionHour())
                        <div class="mb-3">
                            <label class="text-muted">{{ __('Consommation normale (H)') }}</label>
                            <p class="mb-0 font-weight-semibold">
                                {{ $vehicule->getMinFuelConsumptionHour() }} - {{ $vehicule->getMaxFuelConsumptionHour() }} L/H
                            </p>
                        </div>
                        @endif
                        
                        <div class="mb-3">
                            <label class="text-muted">{{ __('Date d\'expiration assurance') }}</label>
                            <p class="mb-0 font-weight-semibold">
                                @if($vehicule->getInssuranceExpiration())
                                    {{ \Carbon\Carbon::parse($vehicule->getInssuranceExpiration())->format('d/m/Y') }}
                                    @php
                                        $daysUntilExpiry = \Carbon\Carbon::parse($vehicule->getInssuranceExpiration())->diffInDays(\Carbon\Carbon::now(), false);
                                    @endphp
                                    @if($daysUntilExpiry < 0)
                                        <span class="badge badge-danger ml-2">{{ __('Expirée') }}</span>
                                    @elseif($daysUntilExpiry <= 30)
                                        <span class="badge badge-warning ml-2">{{ __('Expire dans') }} {{ abs($daysUntilExpiry) }} {{ __('jours') }}</span>
                                    @endif
                                @else
                                    -
                                @endif
                            </p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="text-muted">{{ __('Date d\'expiration visite technique') }}</label>
                            <p class="mb-0 font-weight-semibold">
                                @if($vehicule->getTechnicalvisiteExpiration())
                                    {{ \Carbon\Carbon::parse($vehicule->getTechnicalvisiteExpiration())->format('d/m/Y') }}
                                    @php
                                        $daysUntilExpiry = \Carbon\Carbon::parse($vehicule->getTechnicalvisiteExpiration())->diffInDays(\Carbon\Carbon::now(), false);
                                    @endphp
                                    @if($daysUntilExpiry < 0)
                                        <span class="badge badge-danger ml-2">{{ __('Expirée') }}</span>
                                    @elseif($daysUntilExpiry <= 30)
                                        <span class="badge badge-warning ml-2">{{ __('Expire dans') }} {{ abs($daysUntilExpiry) }} {{ __('jours') }}</span>
                                    @endif
                                @else
                                    -
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Consumption Statistics -->
            <div class="col-xl-8">
                @if(isset($consumptionStats) && $fuelVouchers->count() >= 2)
                <div class="card border mb-4 {{ $consumptionStats['exceeds_max_consumption'] ? 'border-danger' : '' }}">
                    <div class="card-header bg-light">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="fas fa-chart-line text-primary mr-2"></i>{{ __('Statistiques de consommation') }}
                                @if($consumptionStats['exceeds_max_consumption'])
                                    <span class="badge badge-danger ml-2">{{ __('⚠️ Consommation élevée!') }}</span>
                                @endif
                            </h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Period Filter -->
                        <form method="GET" action="{{ route('admin.vehicule.show', $vehicule->getId()) }}" class="mb-4">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="start_date" class="form-label">{{ __('Date de début') }}</label>
                                    <input type="date" 
                                           class="form-control" 
                                           id="start_date" 
                                           name="start_date" 
                                           value="{{ $startDate ?? '' }}">
                                </div>
                                <div class="col-md-4">
                                    <label for="end_date" class="form-label">{{ __('Date de fin') }}</label>
                                    <input type="date" 
                                           class="form-control" 
                                           id="end_date" 
                                           name="end_date" 
                                           value="{{ $endDate ?? '' }}">
                                </div>
                                <div class="col-md-4 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary mr-2">
                                        <i class="fas fa-filter mr-1"></i>{{ __('Filtrer') }}
                                    </button>
                                    @if($startDate || $endDate)
                                    <a href="{{ route('admin.vehicule.show', $vehicule->getId()) }}" class="btn btn-secondary">
                                        <i class="fas fa-times mr-1"></i>{{ __('Réinitialiser') }}
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                        
                        @if($startDate || $endDate)
                        <div class="alert alert-info mb-3">
                            <i class="fas fa-info-circle mr-2"></i>
                            {{ __('Période sélectionnée') }}: 
                            <strong>
                                {{ $startDate ? \Carbon\Carbon::parse($startDate)->format('d/m/Y') : __('Début') }} 
                                - 
                                {{ $endDate ? \Carbon\Carbon::parse($endDate)->format('d/m/Y') : __('Fin') }}
                            </strong>
                        </div>
                        @endif
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <div class="text-center">
                                    <h6 class="text-muted mb-1">{{ __('Consommation moyenne') }}</h6>
                                    <h4 class="mb-0 {{ $consumptionStats['exceeds_max_consumption'] ? 'text-danger' : 'text-success' }}">
                                        {{ $consumptionStats['average_consumption_100km'] ? number_format($consumptionStats['average_consumption_100km'], 2, ',', ' ') : '-' }} L/100km
                                    </h4>
                                    @if($vehicule->getMinFuelConsumption100km() && $vehicule->getMaxFuelConsumption100km())
                                        <small class="text-muted">
                                            {{ __('Normale') }}: {{ $vehicule->getMinFuelConsumption100km() }} - {{ $vehicule->getMaxFuelConsumption100km() }} L/100km
                                        </small>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="text-center">
                                    <h6 class="text-muted mb-1">{{ __('Total carburant') }}</h6>
                                    <h4 class="mb-0 text-info">
                                        {{ number_format($consumptionStats['total_fuel_liters'], 2, ',', ' ') }} L
                                    </h4>
                                    <small class="text-muted">{{ __('Coût total') }}: {{ number_format($consumptionStats['total_fuel_cost'], 2, ',', ' ') }} {{ __('DH') }}</small>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="text-center">
                                    <h6 class="text-muted mb-1">{{ __('Distance parcourue') }}</h6>
                                    <h4 class="mb-0 text-primary">
                                        {{ number_format($consumptionStats['total_km'], 0, ',', ' ') }} {{ __('KM') }}
                                    </h4>
                                    @if($consumptionStats['total_hours'] > 0)
                                        <small class="text-muted">{{ __('Heures') }}: {{ number_format($consumptionStats['total_hours'], 0, ',', ' ') }} H</small>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="text-center">
                                    <h6 class="text-muted mb-1">{{ __('Prix moyen/Litre') }}</h6>
                                    <h4 class="mb-0 text-success">
                                        {{ $consumptionStats['average_price_per_liter'] ? number_format($consumptionStats['average_price_per_liter'], 2, ',', ' ') : '-' }} {{ __('DH/L') }}
                                    </h4>
                                    @if($consumptionStats['average_consumption_hour'])
                                        <small class="text-muted">{{ __('Consommation/heure') }}: {{ number_format($consumptionStats['average_consumption_hour'], 2, ',', ' ') }} L/H</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        @if($fuelVouchers->isNotEmpty())
                        <div class="mt-4">
                            <div id="morris-line-consumption" style="height: 300px;"></div>
                        </div>
                        @endif
                    </div>
                </div>
                @else
                <div class="card border mb-4">
                    <div class="card-body text-center">
                        <p class="text-muted mb-0">{{ __('Données de consommation insuffisantes. Au moins 2 entrées de carburant sont nécessaires.') }}</p>
                    </div>
                </div>
                @endif

                <!-- Costs by Category -->
                <div class="card border mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">
                            <i class="fas fa-money-bill-wave text-success mr-2"></i>{{ __('Coûts par catégorie') }}
                            @if($startDate || $endDate)
                                <small class="text-muted">({{ __('Filtré par période') }})</small>
                            @endif
                        </h5>
                    </div>
                    <div class="card-body">
                        @if(count($costsByCategory) > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>{{ __('Catégorie') }}</th>
                                        <th class="text-right">{{ __('Montant total') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $categoryLabels = [
                                            'carburant' => __('Bon pour Carburant'),
                                            'entretien' => __('Entretien'),
                                            'lavage' => __('Lavage'),
                                            'lubrifiant' => __('Lubrifiant'),
                                            'reparation' => __('Reparation'),
                                            'achat_pieces_recharges' => __('Achat pieces de recharges'),
                                            'rechange_pneu' => __('Rechange pneu'),
                                            'frais_immatriculation' => __('Frais d\'immatriculation'),
                                            'visite_technique' => __('Visite technique'),
                                            'insurance' => __('Assurance'),
                                            'other' => __('Autre'),
                                        ];
                                        $totalCost = array_sum($costsByCategory);
                                    @endphp
                                    @foreach($costsByCategory as $category => $cost)
                                    <tr>
                                        <td>{{ $categoryLabels[$category] ?? $category }}</td>
                                        <td class="text-right font-weight-semibold">{{ number_format($cost, 2, ',', ' ') }} {{ __('DH') }}</td>
                                    </tr>
                                    @endforeach
                                    <tr class="table-primary">
                                        <td class="font-weight-bold">{{ __('Total') }}</td>
                                        <td class="text-right font-weight-bold">{{ number_format($totalCost, 2, ',', ' ') }} {{ __('DH') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        @else
                        <p class="text-muted mb-0">{{ __('Aucun bon de paiement enregistré pour ce véhicule.') }}</p>
                        @endif
                    </div>
                </div>

                <!-- Latest Insurance & Technical Visit -->
                <div class="row">
                    @if($latestInsurance)
                    <div class="col-md-6">
                        <div class="card border">
                            <div class="card-header bg-light">
                                <h6 class="mb-0"><i class="fas fa-shield-alt text-info mr-2"></i>{{ __('Dernière assurance') }}</h6>
                            </div>
                            <div class="card-body">
                                <p class="mb-1"><strong>{{ __('Date d\'expiration') }}:</strong> {{ \Carbon\Carbon::parse($latestInsurance->getInsuranceExpirationDate())->format('d/m/Y') }}</p>
                                <p class="mb-1"><strong>{{ __('Montant') }}:</strong> {{ number_format($latestInsurance->getAmount(), 2, ',', ' ') }} {{ __('DH') }}</p>
                                <p class="mb-0"><strong>{{ __('Date de facture') }}:</strong> {{ \Carbon\Carbon::parse($latestInsurance->getInvoiceDate())->format('d/m/Y') }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($latestTechnicalVisit)
                    <div class="col-md-6">
                        <div class="card border">
                            <div class="card-header bg-light">
                                <h6 class="mb-0"><i class="fas fa-clipboard-check text-warning mr-2"></i>{{ __('Dernière visite technique') }}</h6>
                            </div>
                            <div class="card-body">
                                <p class="mb-1"><strong>{{ __('Date d\'expiration') }}:</strong> {{ \Carbon\Carbon::parse($latestTechnicalVisit->getTechnicalVisitExpirationDate())->format('d/m/Y') }}</p>
                                <p class="mb-1"><strong>{{ __('Montant') }}:</strong> {{ number_format($latestTechnicalVisit->getAmount(), 2, ',', ' ') }} {{ __('DH') }}</p>
                                <p class="mb-0"><strong>{{ __('Date de facture') }}:</strong> {{ \Carbon\Carbon::parse($latestTechnicalVisit->getInvoiceDate())->format('d/m/Y') }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Payment Vouchers List -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">
                            <i class="fas fa-receipt mr-2"></i>{{ __('Bons de paiement') }}
                            @if($startDate || $endDate)
                                <small class="text-muted">({{ __('Filtré par période') }})</small>
                            @endif
                        </h5>
                        
                        @if($allVouchers->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>{{ __('Numéro de bon') }}</th>
                                        <th>{{ __('Catégorie') }}</th>
                                        <th>{{ __('Date de facture') }}</th>
                                        <th>{{ __('Montant') }}</th>
                                        <th>{{ __('KM') }}</th>
                                        <th>{{ __('Fournisseur') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $categoryLabels = [
                                            'carburant' => __('Bon pour Carburant'),
                                            'entretien' => __('Entretien'),
                                            'lavage' => __('Lavage'),
                                            'lubrifiant' => __('Lubrifiant'),
                                            'reparation' => __('Reparation'),
                                            'achat_pieces_recharges' => __('Achat pieces de recharges'),
                                            'rechange_pneu' => __('Rechange pneu'),
                                            'frais_immatriculation' => __('Frais d\'immatriculation'),
                                            'visite_technique' => __('Visite technique'),
                                            'insurance' => __('Assurance'),
                                            'other' => __('Autre'),
                                        ];
                                    @endphp
                                    @foreach($allVouchers as $voucher)
                                    <tr>
                                        <td>{{ $voucher->getVoucherNumber() }}</td>
                                        <td>
                                            <span class="badge badge-info">{{ $categoryLabels[$voucher->getCategory()] ?? $voucher->getCategory() }}</span>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($voucher->getInvoiceDate())->format('d/m/Y') }}</td>
                                        <td class="font-weight-semibold">{{ number_format($voucher->getAmount(), 2, ',', ' ') }} {{ __('DH') }}</td>
                                        <td>{{ number_format($voucher->getVehicleKm(), 0, ',', ' ') }} {{ __('KM') }}</td>
                                        <td>{{ $voucher->getSupplier() ?? '-' }}</td>
                                        <td>
                                            <a href="{{ route('admin.payment_voucher.show', $voucher->getId()) }}" class="btn btn-sm btn-info" title="{{ __('Voir') }}">
                                                <i class="mdi mdi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <p class="text-muted mb-0">{{ __('Aucun bon de paiement enregistré pour ce véhicule.') }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($fuelVouchers->isNotEmpty() && isset($consumptionStats))
    <script src="{{ asset('assets/plugins/morris/morris.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/raphael/raphael.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var consumptionData = [
                @foreach($fuelVouchers as $voucher)
                {
                    date: '{{ \Carbon\Carbon::parse($voucher->getInvoiceDate())->format('Y-m-d') }}',
                    consumption: {{ $voucher->getFuelLiters() ? $voucher->getFuelLiters() : 0 }},
                    km: {{ $voucher->getVehicleKm() }},
                    amount: {{ $voucher->getAmount() }}
                }@if(!$loop->last),@endif
                @endforeach
            ];

            if (typeof Morris !== 'undefined' && consumptionData.length > 0) {
                new Morris.Line({
                    element: 'morris-line-consumption',
                    data: consumptionData.map(function(item, index) {
                        if (index === 0) return null;
                        var prevItem = consumptionData[index - 1];
                        var kmDiff = item.km - prevItem.km;
                        var consumption = kmDiff > 0 ? ((item.consumption / kmDiff) * 100) : 0;
                        return {
                            date: item.date,
                            consumption: parseFloat(consumption.toFixed(2))
                        };
                    }).filter(function(item) { return item !== null; }),
                    xkey: 'date',
                    ykeys: ['consumption'],
                    labels: ['{{ __('Consommation (L/100km)') }}'],
                    lineColors: ['#4a81d4'],
                    pointSize: 3,
                    hideHover: 'auto',
                    resize: true,
                    xLabelFormat: function(x) {
                        return new Date(x).toLocaleDateString('fr-FR');
                    }
                });
            }
        });
    </script>
    @endif
</x-admin.app>

