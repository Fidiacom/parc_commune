<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ordre de Mission</title>
    <style>
        @page {
            margin-top: 0cm;
            margin-bottom: 0cm;
            margin-left: 2cm;
            margin-right: 2cm;
        }
        * {
            font-family: 'Arial', 'Tahoma', 'DejaVu Sans', 'Liberation Sans', sans-serif;
        }
        body {
            font-family: 'Arial', 'Tahoma', 'DejaVu Sans', 'Liberation Sans', sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 12pt;
            line-height: 1.6;
        }
        .header {
            margin-bottom: 40px;
            width: 100%;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
        }
        .header-table td {
            padding: 2px 0;
            vertical-align: middle;
        }
        .header-left {
            text-align: left;
            font-size: 9pt;
            line-height: 1.4;
            font-family: 'Arial', 'Tahoma', 'DejaVu Sans', 'Liberation Sans', sans-serif;
            width: 50%;
        }
        .header-right {
            text-align: right;
            font-size: 10pt;
            line-height: 1.4;
            direction: rtl;
            font-family: 'Tahoma', 'Arial Unicode MS', 'Segoe UI', 'DejaVu Sans', 'Lucida Grande', sans-serif;
            unicode-bidi: embed;
            font-feature-settings: "kern" 1;
            text-rendering: optimizeLegibility;
            width: 50%;
        }
        .title-section {
            text-align: center;
            margin: 40px 0;
        }
        .title-arabic {
            font-size: 16pt;
            font-weight: bold;
            margin-bottom: 15px;
            font-family: 'Tahoma', 'Arial Unicode MS', 'Segoe UI', 'DejaVu Sans', 'Lucida Grande', sans-serif;
            direction: rtl;
            unicode-bidi: embed;
            font-feature-settings: "kern" 1;
            text-rendering: optimizeLegibility;
            text-decoration: underline;

        }
        .title-french {
            font-size: 16pt;
            font-weight: bold;
            text-decoration: underline;
            font-family: 'Arial', 'Tahoma', 'DejaVu Sans', 'Liberation Sans', sans-serif;
        }
        .form-section {
            margin: 30px 0;
        }
        .form-row {
            width: 100%;
            margin-bottom: 15px;
            border-collapse: collapse;
        }
        .form-row td {
            vertical-align: middle;
            padding: 0;
        }
        .form-label-fr {
            text-align: left;
            font-family: 'Arial', 'Tahoma', 'DejaVu Sans', 'Liberation Sans', sans-serif;
            width: 50%;
        }
        .form-label-ar {
            text-align: right;
            direction: rtl;
            font-family: 'Tahoma', 'Arial Unicode MS', 'Segoe UI', 'DejaVu Sans', 'Lucida Grande', sans-serif;
            unicode-bidi: embed;
            font-feature-settings: "kern" 1;
            text-rendering: optimizeLegibility;
            width: 50%;
        }
        .form-value {
            border-bottom: 1px dotted #000;
            min-width: 200px;
            display: inline-block;
            font-family: 'Arial', 'Tahoma', 'DejaVu Sans', 'Liberation Sans', sans-serif;
        }
        .form-value-arabic {
            border-bottom: 1px dotted #000;
            min-width: 200px;
            display: inline-block;
            font-family: 'Tahoma', 'Arial Unicode MS', 'Segoe UI', 'DejaVu Sans', 'Lucida Grande', sans-serif;
            font-feature-settings: "kern" 1;
            text-rendering: optimizeLegibility;
            direction: rtl;
            unicode-bidi: embed;
        }
        .time-table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
            font-size: 9pt;
        }
        .time-table td {
            border: 1px solid #000;
            padding: 10px;
            vertical-align: top;
            width: 50%;
        }
        .time-table div {
            font-size: 9pt;
            line-height: 1.5;
            margin-bottom: 8px;
        }
        .time-row {
            min-height: 50px;
        }
        .nota {
            margin-top: 30px;
            font-size: 10pt;
            text-align: justify;
            font-style: italic;
        }
    </style>
</head>
<body>
    <table class="header-table">
        <tr>
            <td class="header-left">ROYAUME DU MAROC</td>
            <td class="header-right">المملكة المغربية</td>
        </tr>
        <tr>
            <td class="header-left">MINISTRE DE L'INTERIEURE</td>
            <td class="header-right">وزارة الداخلية</td>
        </tr>
        <tr>
            <td class="header-left">WILAYA GHARB CHRARDA BNI HSSEN</td>
            <td class="header-right">ولاية الغرب الشراردة بني احسن</td>
        </tr>
        <tr>
            <td class="header-left">PROVINCE DE SIDI SLIMANE</td>
            <td class="header-right">عمالة اقليم سيدي سليمان</td>
        </tr>
        <tr>
            <td class="header-left">PACHALIK DE SIDI YAHIA DU GHARB</td>
            <td class="header-right">باشاوية سيدي يحيى الغرب</td>
        </tr>
        <tr>
            <td class="header-left">MUNIPALITE DE SIDI YAHIA GHARB</td>
            <td class="header-right">بلدية سيدي يحيى الغرب</td>
        </tr>
    </table>

    <div class="title-section">
        <div class="title-arabic">أمر بالقيام بمهمة</div>
        <div class="title-french">ORDRE DE MISSION</div>
    </div>

    <div class="form-section">
        <table class="form-row">
            <tr>
                <td class="form-label-fr">
                    Il est prescrit à: Mr <span class="form-value">{{ ($missionOrder->getDriver()->getFirstNameFr() ?: '') . ' ' . ($missionOrder->getDriver()->getLastNameFr() ?: '') }}</span>
                </td>
                <td class="form-label-ar">
                    يعطى امر للسيد :<span class="form-value-arabic">{{ ($missionOrder->getDriver()->getFirstNameAr() ?: '') . ' ' . ($missionOrder->getDriver()->getLastNameAr() ?: '') }}</span>
                </td>
            </tr>
        </table>

        <table class="form-row">
            <tr>
                <td class="form-label-fr">
                    Qualité : <span class="form-value">{{ $missionOrder->getDriver()->getRoleFr() ?? '................................' }}</span>
                </td>
                <td class="form-label-ar">
                    <span>صفته :</span>
                    <span class="form-value">{{ $missionOrder->getDriver()->getRoleAr() ?? '................................' }}</span>
                </td>
            </tr>
        </table>

        <table class="form-row">
            <tr>
                <td class="form-label-fr">
                    De se rendre à : <span class="form-value">{{ $missionOrder->getPlaceTogoFr() ?? '.......................' }}</span>
                </td>
                <td class="form-label-ar">
                    <span>بالتوجه الــى :</span>
                    <span class="form-value">{{ $missionOrder->getPlaceTogoAr() ?? '.......................' }}</span>
                </td>
            </tr>
        </table>

        <table class="form-row">
            <tr>
                <td class="form-label-fr">
                    Pour mission de : <span class="form-value">{{ $missionOrder->getMissionFr() ?? '.......................' }}</span>
                </td>
                <td class="form-label-ar">
                    <span>للقيام بمهمــــة :</span>
                    <span class="form-value">{{ $missionOrder->getMissionAr() ?? '.......................' }}</span>
                </td>
            </tr>
        </table>

        <table class="form-row">
            <tr>
                <td class="form-label-fr">
                    Par le moyen de locomotion : <span class="form-value">{{ $missionOrder->getVehicule()->getBrand() ?? '.........' }}</span> - <span class="form-value">{{ $missionOrder->getVehicule()->getMatricule() ?? '.........' }}</span>
                </td>
                <td class="form-label-ar">
                    <span>بوسيلة التنقل :</span>
                    <span class="form-value-arabic">{{ $missionOrder->getVehicule()->getBrand() ?? '.........' }}</span> - <span class="form-value-arabic">{{ $missionOrder->getVehicule()->getMatricule() ?? '.........' }}</span>
                </td>
            </tr>
        </table>

        <table class="form-row">
            <tr>
                <td class="form-label-fr">
                    Fait à sidi yahia du Gharb : <span class="form-value">................</span>
                </td>
                <td class="form-label-ar">
                    <span>حرر بسيدي يحيى الغرب في :</span>
                    <span class="form-value">...........................</span>
                </td>
            </tr>
        </table>
    </div>

    <table class="time-table">
        <tr>
            <td>
                <div>Vu au départ de S.Y.G.Le................A.................H</div>
                <br>
                <br>
                <br>
                <br>
                <br>
                
                <div>Vu au retour à S.Y.G.Le................A.................H</div>
            </td>
            <td>
                <div>Vu à l'arrivé à ................A.................H</div>
                <br>
                <br>
                <div>Vu au départ D....................................</div>
                <br>
                <br>
                <div>Vu à l'arrivé à ................A.................H</div>
                <br>
                <br>
                <div>Vu au départ D..................................</div>
            </td>
        </tr>
    </table>

    <div class="nota">
        <strong>Nota :</strong> cet ordre de mission doit être complété à l'arrivée et au départ par la date ; le cachet ; le nom et la fonction du responsable l'ayant visé.
    </div>
</body>
</html>