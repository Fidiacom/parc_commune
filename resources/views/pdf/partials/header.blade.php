{{--
    Official PDF header. Values come from .env (config/settings.php) via App\Support\PdfHeader.
    Usage: @include('pdf.partials.header', ['mode' => 'fr' | 'ar' | 'bilingual'])
--}}
@php
    $mode = $mode ?? 'fr';
    $logo = \App\Support\PdfHeader::logoPath();
    $frStyle = 'text-align:left; font-size:9pt; font-weight:bold; line-height:1.4; font-family:dejavusanscondensed, sans-serif;';
    $arStyle = 'text-align:right; font-size:10pt; font-weight:bold; line-height:1.5; direction:rtl; font-family:xbriyaz, dejavusans, sans-serif;';
@endphp

<table style="width:100%; border-collapse:collapse; margin-bottom:10px;">
    <tr>
        @if($mode === 'bilingual')
            <td style="{{ $frStyle }} width:42%; vertical-align:top;">
                @foreach(\App\Support\PdfHeader::bilingualLines() as $line)
                    <div>{{ $line['fr'] }}</div>
                @endforeach
            </td>
            <td style="width:16%; text-align:center; vertical-align:middle;">
                @if($logo)
                    <img src="{{ $logo }}" style="max-height:70px; max-width:90px;">
                @endif
            </td>
            <td style="{{ $arStyle }} width:42%; vertical-align:top;" dir="rtl">
                @foreach(\App\Support\PdfHeader::bilingualLines() as $line)
                    <div>{{ $line['ar'] }}</div>
                @endforeach
            </td>
        @else
            {{-- In RTL documents mPDF mirrors table columns, so the text cell stays on the reading side. --}}
            <td style="{{ $mode === 'ar' ? $arStyle : $frStyle }} width:60%; vertical-align:top;" @if($mode === 'ar') dir="rtl" @endif>
                @foreach(\App\Support\PdfHeader::lines($mode) as $line)
                    <div>{{ $line }}</div>
                @endforeach
            </td>
            <td style="width:40%; text-align:{{ $mode === 'ar' ? 'left' : 'right' }}; vertical-align:top;">
                @if($logo)
                    <img src="{{ $logo }}" style="max-height:70px; max-width:90px;">
                @endif
            </td>
        @endif
    </tr>
</table>
