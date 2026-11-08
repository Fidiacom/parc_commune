@php
    $lang = ($lang ?? 'fr') === 'ar' ? 'ar' : 'fr';
    $isAr = $lang === 'ar';
    $commune = \App\Support\PdfHeader::communeName($lang);
    $vehicule = $missionOrder->getVehicule();
    $brand = $vehicule?->getBrand() ?: 'N/A';
    $matricule = $vehicule?->getMatricule() ?: 'N/A';
    $year = date('Y', strtotime($missionOrder->getStart()));
    $nameKey = $isAr ? 'name_ar' : 'name_fr';
    $name = ($subject[$nameKey] ?? '') !== '' ? $subject[$nameKey] : 'N/A';
@endphp
<!DOCTYPE html>
<html lang="{{ $lang }}" dir="{{ $isAr ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <title>{{ $isAr ? 'أمر بمهمة دائم' : 'Ordre de Mission Permanent' }} - {{ $missionOrder->getId() }}</title>
    <style>
        @page {
            margin-top: 0.5cm;
            margin-bottom: 0.5cm;
            margin-left: 2cm;
            margin-right: 2cm;
        }
        body {
            font-family: {{ $isAr ? 'xbriyaz, dejavusans' : "'Times New Roman', serif" }};
            margin: 0;
            padding: 0;
            font-size: {{ $isAr ? '14pt' : '12pt' }};
            line-height: 1.5;
            text-align: {{ $isAr ? 'right' : 'left' }};
        }
        .title-section {
            text-align: center;
            margin: 30px 0;
        }
        .main-title {
            font-size: {{ $isAr ? '17pt' : '14pt' }};
            font-weight: bold;
            margin-bottom: 10px;
            text-transform: uppercase;
        }
        .number-date {
            margin-top: 10px;
            font-size: 15pt;
            text-align: center;
        }
        .preamble {
            margin: 25px 0;
            text-align: justify;
        }
        .preamble-line {
            margin: 8px 0;
        }
        .decision {
            text-align: center;
            margin: 25px 0;
            font-weight: bold;
        }
        .article-section {
            margin: 25px 0;
        }
        .article-title {
            font-weight: bold;
            margin-bottom: 10px;
        }
        .article-content {
            text-align: justify;
        }
        .info-line {
            margin: 5px 0;
        }
        .signature {
            margin-top: 80px;
            text-align: {{ $isAr ? 'left' : 'right' }};
        }
        .signature-text {
            font-weight: bold;
            font-size: {{ $isAr ? '14pt' : '11pt' }};
        }
    </style>
</head>
<body>
    @include('pdf.partials.header', ['mode' => $lang])

    @if($isAr)
        <div class="title-section">
            <div class="main-title">أمر بمهمة دائم برسم سنة {{ $year }}</div>
            <div class="number-date">رقم .... بتاريخ ........................</div>
        </div>

        <div class="preamble">
            <div class="preamble-line"><strong>إن رئيس {{ $commune }}،</strong></div>
            <div class="preamble-line">
                بناء على الظهير الشريف رقم 1.15.85 الصادر في 20 من رمضان 1436 (7 يوليو 2015) بتنفيذ القانون التنظيمي رقم 113.14 المتعلق بالجماعات؛
            </div>
            <div class="preamble-line">
                ونظرا لكون المعني بالأمر يتحمل مسؤوليات ب{{ $commune }}؛
            </div>
        </div>

        <div class="decision">يقرر ما يلي :</div>

        <div class="article-section">
            <div class="article-title">مادة فريدة :</div>
            <div class="article-content">
                يؤمر السيد : <strong>{{ $name }}</strong>، بالتنقل إلى جميع الاتجاهات بواسطة سيارة المصلحة <strong>{{ $brand }}</strong> المسجلة تحت رقم <strong>{{ $matricule }}</strong>.
            </div>
            @if($missionOrder->getRegistrationDatetime())
                <div class="article-content" style="margin-top: 15px;">
                    <div class="info-line">
                        <strong>تاريخ وساعة التسجيل :</strong> {{ date('d/m/Y H:i', strtotime($missionOrder->getRegistrationDatetime())) }}
                    </div>
                </div>
            @endif
        </div>

        <div class="signature">
            <div class="signature-text">الرئيس</div>
        </div>
    @else
        <div class="title-section">
            <div class="main-title">ORDRE DE MISSION PERMANENT POUR ANNEE {{ $year }}</div>
            <div class="number-date">N° .... DU ........................</div>
        </div>

        <div class="preamble">
            <div class="preamble-line"><strong>Le président de la {{ $commune }}.</strong></div>
            <div class="preamble-line">
                Vu le dahir N°1.15.85 du 20 Ramadan 1436 (07 juillet 2015) portant promulgation de la loi organique N°113.14 relative aux collectivités territoriales.
            </div>
            <div class="preamble-line">
                Etant donné que l'intéressé assure des responsabilités à la {{ $commune }}.
            </div>
        </div>

        <div class="decision">Décide :</div>

        <div class="article-section">
            <div class="article-title">Article unique :</div>
            <div class="article-content">
                Il est prescrit à Mr : <strong>{{ $name }}</strong>, de se rendre à toutes les directions moyennant la voiture de service <strong>{{ $brand }}</strong> immatriculée sous N° <strong>{{ $matricule }}</strong>.
            </div>
            @if($missionOrder->getRegistrationDatetime())
                <div class="article-content" style="margin-top: 15px;">
                    <div class="info-line">
                        <strong>Date et heure d'enregistrement :</strong> {{ date('d/m/Y à H:i', strtotime($missionOrder->getRegistrationDatetime())) }}
                    </div>
                </div>
            @endif
        </div>

        <div class="signature">
            <div class="signature-text">LE PRESIDENT</div>
        </div>
    @endif
</body>
</html>
