<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ordre de Mission Permanent - {{ $missionOrder->getId() }}</title>
    <style>
        @page {
            margin-top: 0.5cm;
            margin-bottom: 0.5cm;
            margin-left: 2cm;
            margin-right: 2cm;
        }
        body {
            font-family: 'Times New Roman', serif;
            margin: 0;
            padding: 0;
            font-size: 12pt;
            line-height: 1.5;
        }
        .header {
            margin-top: 0px;
        }
        .header-line {
            margin: 0px 0;
            font-weight: bold;
            font-size: 8pt;
        }
        .title-section {
            text-align: center;
            margin: 30px 0;
        }
        .main-title {
            font-size: 14pt;
            font-weight: bold;
            margin-bottom: 10px;
            text-transform: uppercase;
        }
        .number-date {
            margin-top: 10px;
            font-size: 15pt;
            text-align: center;
            margin-left: 0;
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
            font-size: 12pt;
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
            margin-left: 0;
        }
        .info-line {
            margin: 5px 0;
        }
        .signature {
            margin-top: 80px;
            text-align: right;
        }
        .signature-text {
            font-weight: bold;
            font-size: 11pt;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-line">{{ config('settings.royaume_fr') }}</div>
        <div class="header-line">{{ config('settings.ministere_fr') }}</div>
        <div class="header-line">REGION DE {{ strtoupper(config('settings.region_name_fr')) }}</div>
        <div class="header-line">PROVINCE DE {{ strtoupper(config('settings.province_name_fr')) }}</div>
        <div class="header-line">PACHALIKE DE {{ strtoupper(config('settings.pachalike_name_fr')) }}</div>
        <div class="header-line">COMMUNE DE {{ strtoupper(config('settings.commune_name_fr')) }}</div>
    </div>

    <div class="title-section">
        <div class="main-title">
            ORDRE DE MISSION PERMANENT POUR ANNEE {{ date('Y', strtotime($missionOrder->getStart())) }}
        </div>
        
        <div class="number-date">
            N° .... DU ........................
        </div>
    </div>

    <div class="preamble">
        <div class="preamble-line">
            <strong>
                Le président de la commune
                @if($settings && $settings->getCommuneNameFr())
                de {{ $settings->getCommuneNameFr() }}
                @endif
                .
            </strong>
        </div>
        <div class="preamble-line">
            Vu le dahir N°1.15.85 du 20 Ramadan 1436(07 juillet) portant promulgation de la loi organique N°113.14 relative aux collectivités territoriales.
        </div>
        <div class="preamble-line">
            Etant donné que l'intéressé assure des responsabilités à la commune
            @if($settings && $settings->getCommuneNameFr())
            de {{ $settings->getCommuneNameFr() }}
            @endif
            .
        </div>
    </div>

    <div class="decision">
        Décide :
    </div>

    <div class="article-section">
        <div class="article-title">
            Article unique :
        </div>
        <div class="article-content">
            Il est prescrit à Mr : <strong>{{ ($missionOrder->getDriver()->getFirstNameFr() ?: $missionOrder->getDriver()->getFirstNameAr() ?: '') . ' ' . ($missionOrder->getDriver()->getLastNameFr() ?: $missionOrder->getDriver()->getLastNameAr() ?: '') }}</strong>, de se rendre à toutes les directions moyennant la voiture de service <strong>{{ $missionOrder->getVehicule()->getBrand() ?? 'N/A' }}</strong> immatriculée sous N° <strong>{{ $missionOrder->getVehicule()->getMatricule() ?? 'N/A' }}</strong>.
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
</body>
</html>

