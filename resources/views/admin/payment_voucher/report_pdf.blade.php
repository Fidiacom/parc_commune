@php
    $lang = ($lang ?? 'fr') === 'ar' ? 'ar' : 'fr';
    $isAr = $lang === 'ar';
    $start = $isAr ? 'right' : 'left';
    $end = $isAr ? 'left' : 'right';
    $total = $vouchers->sum(fn ($voucher) => (float) $voucher->getAmount());
    // Keeps numbers, dates and Latin names in left-to-right order inside Arabic text
    $ltr = fn ($value) => $isAr ? '<bdo dir="ltr">' . e($value) . '</bdo>' : e($value);
    $date = fn ($value) => $value ? $ltr(\Carbon\Carbon::parse($value)->format('d/m/Y')) : '-';
    $money = fn ($value) => $ltr(number_format((float) $value, 2, ',', ' ')) . ' ' . e(__('DH'));
@endphp
<!DOCTYPE html>
<html lang="{{ $lang }}" dir="{{ $isAr ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <title>{{ __('Rapport des bons de paiement') }}</title>
    <style>
        body {
            font-family: {{ $isAr ? 'xbriyaz, dejavusans' : 'dejavusans' }};
            font-size: {{ $isAr ? '12pt' : '10pt' }};
            color: #1f2937;
            text-align: {{ $start }};
        }
        .title {
            text-align: center;
            margin: 14px 0 16px;
            font-size: {{ $isAr ? '17pt' : '15pt' }};
            font-weight: bold;
            text-decoration: underline;
        }
        .meta {
            margin-bottom: 12px;
        }
        .meta div {
            margin-bottom: 2px;
        }
        table.data {
            width: 100%;
            border-collapse: collapse;
        }
        table.data th, table.data td {
            border: 1px solid #9ca3af;
            padding: 5px 7px;
            vertical-align: top;
            text-align: {{ $start }};
        }
        table.data th {
            background: #f3f4f6;
        }
        .amount {
            text-align: {{ $end }} !important;
            white-space: nowrap;
        }
        .total td {
            font-weight: bold;
            background: #f9fafb;
        }
    </style>
</head>
<body>
    @include('pdf.partials.header', ['mode' => $lang])

    <div class="title">{{ __('Rapport des bons de paiement') }}</div>

    <div class="meta">
        <div>
            {{ __('Véhicule') }} :
            <strong>
                {!! $selectedVehicule ? $ltr($selectedVehicule->getBrand() . ' - ' . $selectedVehicule->getModel() . ' (' . $selectedVehicule->getMatricule() . ')') : e(__('Tous')) !!}
            </strong>
        </div>
        <div>
            {{ __('Catégorie') }} :
            <strong>{{ $selectedCategory ? __($categories[$selectedCategory] ?? $selectedCategory) : __('Toutes') }}</strong>
        </div>
        <div>
            {{ __('Période') }} :
            <strong>
                {!! $date($dateFrom) !!}
                {{ __('au') }}
                {!! $date($dateTo) !!}
            </strong>
        </div>
    </div>

    <table class="data">
        <thead>
            <tr>
                <th>{{ __('Num de bon') }}</th>
                <th>{{ __('Date du bon') }}</th>
                <th>{{ __('Montant') }}</th>
                <th>{{ __('KM') }}</th>
                <th>{{ __('Fournisseur') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($vouchers as $voucher)
                <tr>
                    <td>{!! $ltr($voucher->getVoucherNumber()) !!}</td>
                    <td>{!! $date($voucher->getVoucherDate()) !!}</td>
                    <td class="amount">{!! $money($voucher->getAmount()) !!}</td>
                    <td>{!! $voucher->getVehicleKm() ? $ltr(number_format($voucher->getVehicleKm(), 0, ',', ' ')) : '-' !!}</td>
                    <td>{{ $voucher->getSupplier() ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">{{ __('Aucun résultat trouvé') }}</td>
                </tr>
            @endforelse
            @if($vouchers->count() > 0)
                <tr class="total">
                    <td colspan="2">{{ __('Total') }}</td>
                    <td class="amount">{!! $money($total) !!}</td>
                    <td colspan="2"></td>
                </tr>
            @endif
        </tbody>
    </table>
</body>
</html>
