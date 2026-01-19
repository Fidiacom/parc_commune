<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>{{ __('Gestion de parc-auto') }}</title>
    <style>
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 12px;
            color: #1f2937;
        }
        .header {
            text-align: center;
            margin-bottom: 16px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
        }
        .meta {
            margin-bottom: 12px;
            font-size: 12px;
        }
        .meta strong {
            font-weight: 600;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #e5e7eb;
            padding: 6px 8px;
            vertical-align: top;
        }
        th {
            background: #f3f4f6;
            text-align: left;
        }
        .amount {
            text-align: right;
            white-space: nowrap;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ __('Gestion de parc-auto') }}</h1>
    </div>

    <div class="meta">
        <div>
            {{ __('Véhicule') }}:
            <strong>
                {{ $selectedVehicule ? $selectedVehicule->getBrand() . ' - ' . $selectedVehicule->getModel() . ' (' . $selectedVehicule->getMatricule() . ')' : __('Tous') }}
            </strong>
        </div>
        <div>
            {{ __('Catégorie') }}:
            <strong>
                {{ $selectedCategory ? ($categories[$selectedCategory] ?? $selectedCategory) : __('Toutes') }}
            </strong>
        </div>
        <div>
            {{ __('Période') }}:
            <strong>
                {{ $dateFrom ? \Carbon\Carbon::parse($dateFrom)->format('d/m/Y') : '-' }}
                {{ __('au') }}
                {{ $dateTo ? \Carbon\Carbon::parse($dateTo)->format('d/m/Y') : '-' }}
            </strong>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>{{ __('Num de bon') }}</th>
                <th>{{ __('Date du bon') }}</th>
                <!-- <th>{{ __('Num de facture') }}</th>
                <th>{{ __('Date de facture') }}</th> -->
                <th>{{ __('Montant') }}</th>
                <!-- <th>{{ __('Véhicule') }}</th> -->
                <th>{{ __('KM') }}</th>
                <th>{{ __('Fournisseur') }}</th>
                <!-- <th>{{ __('Catégorie') }}</th> -->
            </tr>
        </thead>
        <tbody>
            @forelse($vouchers as $voucher)
                <tr>
                    <td>{{ $voucher->getVoucherNumber() }}</td>
                    <td>{{ $voucher->getVoucherDate() ? \Carbon\Carbon::parse($voucher->getVoucherDate())->format('d/m/Y') : '-' }}</td>
                    <!-- <td>{{ $voucher->getInvoiceNumber() ?? '-' }}</td>
                    <td>{{ $voucher->getInvoiceDate() ? \Carbon\Carbon::parse($voucher->getInvoiceDate())->format('d/m/Y') : '-' }}</td> -->
                    <td class="amount">{{ number_format($voucher->getAmount(), 2, ',', ' ') }} {{ __('DH') }}</td>
                    <!-- <td>
                        @if($voucher->vehicule)
                            {{ $voucher->vehicule->getBrand() }} - {{ $voucher->vehicule->getModel() }}
                            ({{ $voucher->vehicule->getMatricule() }})
                        @else
                            -
                        @endif
                    </td> -->
                    <td>{{ $voucher->getVehicleKm() ? number_format($voucher->getVehicleKm(), 0, ',', ' ') : '-' }}</td>
                    <td>{{ $voucher->getSupplier() ?? '-' }}</td>
                    <!-- <td>{{ $categories[$voucher->getCategory()] ?? $voucher->getCategory() }}</td> -->
                </tr>
            @empty
                <tr>
                    <td colspan="9" style="text-align: center;">{{ __('Aucun résultat trouvé') }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
