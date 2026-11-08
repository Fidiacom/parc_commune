<?php

namespace App\Services;

use App\Support\PdfHeader;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Mpdf\Mpdf;

/**
 * Renders a Blade view to PDF with mPDF, in French or Arabic (RTL).
 */
class PdfService
{
    /**
     * @param  string  $lang  "fr" or "ar". Texts using __() are rendered in this language.
     * @param  array  $options  Extra mPDF options (margins, orientation...).
     * @return string Raw PDF content.
     */
    public function render(string $view, array $data, string $lang = 'fr', array $options = []): string
    {
        $lang = PdfHeader::normalize($lang);
        $previousLocale = App::getLocale();

        try {
            App::setLocale($lang);

            $html = View::make($view, array_merge($data, ['lang' => $lang]))->render();

            $mpdf = new Mpdf(array_merge([
                'mode' => 'utf-8',
                'format' => 'A4',
                'orientation' => 'P',
                'margin_left' => 15,
                'margin_right' => 15,
                'margin_top' => 10,
                'margin_bottom' => 15,
                'margin_header' => 0,
                'margin_footer' => 9,
                'tempDir' => storage_path('app/temp'),
            ], $options));

            $mpdf->autoScriptToLang = true;
            $mpdf->autoLangToFont = true;

            if ($lang === 'ar') {
                $mpdf->SetDirectionality('rtl');
            }

            $mpdf->WriteHTML($html);

            return $mpdf->Output('', 'S');
        } finally {
            App::setLocale($previousLocale);
        }
    }
}
