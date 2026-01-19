<x-admin.app>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">
                        <i class="mdi mdi-file-document-outline mr-2"></i>{{ __('Rapport des bons de paiement') }}
                    </h4>
                    <div class="page-title-right">
                        <a href="{{ route('admin.payment_voucher.report.pdf', $reportQuery) }}" class="btn btn-primary waves-effect waves-light">
                            <i class="mdi mdi-download mr-2"></i>{{ __('Télécharger PDF') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form method="GET" action="{{ route('admin.payment_voucher.report') }}" class="form-inline">
                            <div class="form-group mb-2 mr-2">
                                <label for="vehicule_id" class="mr-1">{{ __('Véhicule') }}</label>
                                <select name="vehicule_id" id="vehicule_id" class="form-control form-control-sm">
                                    <option value="">{{ __('Tous') }}</option>
                                    @foreach($vehicules as $vehicule)
                                        <option value="{{ $vehicule->getId() }}" {{ (string) $selectedVehiculeId === (string) $vehicule->getId() ? 'selected' : '' }}>
                                            {{ $vehicule->getBrand() }} - {{ $vehicule->getModel() }} ({{ $vehicule->getMatricule() }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-2 mr-2">
                                <label for="category" class="mr-1">{{ __('Catégorie') }}</label>
                                <select name="category" id="category" class="form-control form-control-sm">
                                    <option value="">{{ __('Toutes') }}</option>
                                    @foreach($categories as $key => $label)
                                        <option value="{{ $key }}" {{ $selectedCategory === $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-2 mr-2">
                                <label for="date_from" class="mr-1">{{ __('Du') }}</label>
                                <input type="date" name="date_from" id="date_from" class="form-control form-control-sm" value="{{ $dateFrom }}">
                            </div>
                            <div class="form-group mb-2 mr-2">
                                <label for="date_to" class="mr-1">{{ __('Au') }}</label>
                                <input type="date" name="date_to" id="date_to" class="form-control form-control-sm" value="{{ $dateTo }}">
                            </div>
                            <button type="submit" class="btn btn-sm btn-primary mb-2 mr-2">
                                <i class="mdi mdi-filter mr-1"></i>{{ __('Filtrer') }}
                            </button>
                            <a href="{{ route('admin.payment_voucher.report') }}" class="btn btn-sm btn-secondary mb-2">
                                <i class="mdi mdi-refresh mr-1"></i>{{ __('Réinitialiser') }}
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="mb-3">{{ __('Résultat du rapport') }}</h5>
                        <div class="mb-3 text-muted">
                            {{ __('Véhicule') }}:
                            <strong>
                                {{ $selectedVehicule ? $selectedVehicule->getBrand() . ' - ' . $selectedVehicule->getModel() . ' (' . $selectedVehicule->getMatricule() . ')' : __('Tous') }}
                            </strong>
                            <span class="mx-2">|</span>
                            {{ __('Catégorie') }}:
                            <strong>
                                {{ $selectedCategory ? ($categories[$selectedCategory] ?? $selectedCategory) : __('Toutes') }}
                            </strong>
                            <span class="mx-2">|</span>
                            {{ __('Période') }}:
                            <strong>
                                {{ $dateFrom ? \Carbon\Carbon::parse($dateFrom)->format('d/m/Y') : '-' }}
                                {{ __('au') }}
                                {{ $dateTo ? \Carbon\Carbon::parse($dateTo)->format('d/m/Y') : '-' }}
                            </strong>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{ __('Num de bon') }}</th>
                                        <th>{{ __('Date du bon') }}</th>
                                        <th>{{ __('Num de facture') }}</th>
                                        <th>{{ __('Date de facture') }}</th>
                                        <th>{{ __('Montant') }}</th>
                                        <th>{{ __('Véhicule') }}</th>
                                        <th>{{ __('KM') }}</th>
                                        <th>{{ __('Fournisseur') }}</th>
                                        <th>{{ __('Catégorie') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($vouchers as $voucher)
                                        <tr>
                                            <td><strong>{{ $voucher->getVoucherNumber() }}</strong></td>
                                            <td>{{ $voucher->getVoucherDate() ? \Carbon\Carbon::parse($voucher->getVoucherDate())->format('d/m/Y') : '-' }}</td>
                                            <td>{{ $voucher->getInvoiceNumber() ?? '-' }}</td>
                                            <td>
                                                @if($voucher->getInvoiceDate())
                                                    {{ \Carbon\Carbon::parse($voucher->getInvoiceDate())->format('d/m/Y') }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                <strong class="text-success">{{ number_format($voucher->getAmount(), 2, ',', ' ') }} {{ __('DH') }}</strong>
                                            </td>
                                            <td>
                                                @if($voucher->vehicule)
                                                    {{ $voucher->vehicule->getBrand() }} - {{ $voucher->vehicule->getModel() }}
                                                    <br>
                                                    <small class="text-muted">{{ $voucher->vehicule->getMatricule() }}</small>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>{{ $voucher->getVehicleKm() ? number_format($voucher->getVehicleKm(), 0, ',', ' ') . ' ' . __('KM') : '-' }}</td>
                                            <td>{{ $voucher->getSupplier() ?? '-' }}</td>
                                            <td>
                                                <span class="badge badge-info">
                                                    {{ $categories[$voucher->getCategory()] ?? $voucher->getCategory() }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center text-muted">{{ __('Aucun résultat trouvé') }}</td>
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
