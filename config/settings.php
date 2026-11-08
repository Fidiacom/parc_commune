<?php

/*
|--------------------------------------------------------------------------
| PDF header
|--------------------------------------------------------------------------
|
| Every line of the official header printed on PDFs (mission orders,
| reports). Set them in .env, then run `php artisan config:clear`.
| Each value is the full line as printed. Leave a value empty to hide it.
|
| The commune line uses the name saved in the "Paramètres" page first,
| and falls back to PDF_COMMUNE_FR / PDF_COMMUNE_AR.
|
*/

return [
    'royaume_fr' => env('PDF_ROYAUME_FR', 'ROYAUME DU MAROC'),
    'royaume_ar' => env('PDF_ROYAUME_AR', 'المملكة المغربية'),

    'ministere_fr' => env('PDF_MINISTERE_FR', "MINISTERE DE L'INTERIEUR"),
    'ministere_ar' => env('PDF_MINISTERE_AR', 'وزارة الداخلية'),

    'wilaya_fr' => env('PDF_WILAYA_FR', 'WILAYA GHARB CHRARDA BNI HSSEN'),
    'wilaya_ar' => env('PDF_WILAYA_AR', 'ولاية الغرب الشراردة بني احسن'),

    'region_fr' => env('PDF_REGION_FR', ''),
    'region_ar' => env('PDF_REGION_AR', ''),

    'province_fr' => env('PDF_PROVINCE_FR', 'PROVINCE DE SIDI SLIMANE'),
    'province_ar' => env('PDF_PROVINCE_AR', 'عمالة اقليم سيدي سليمان'),

    'pachalik_fr' => env('PDF_PACHALIK_FR', 'PACHALIK DE SIDI YAHIA DU GHARB'),
    'pachalik_ar' => env('PDF_PACHALIK_AR', 'باشاوية سيدي يحيى الغرب'),

    'commune_fr' => env('PDF_COMMUNE_FR', 'MUNICIPALITE DE SIDI YAHIA GHARB'),
    'commune_ar' => env('PDF_COMMUNE_AR', 'بلدية سيدي يحيى الغرب'),

    // City used in "Fait à ..." / "حرر ب..." and its short form ("Vu au départ de S.Y.G.")
    'city_fr' => env('PDF_CITY_FR', 'Sidi Yahia du Gharb'),
    'city_ar' => env('PDF_CITY_AR', 'سيدي يحيى الغرب'),
    'city_short_fr' => env('PDF_CITY_SHORT_FR', 'S.Y.G.'),

    // Optional logo, path relative to public/ (e.g. "assets/images/logo.png")
    'logo' => env('PDF_LOGO', ''),
];
