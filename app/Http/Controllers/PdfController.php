<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;

class PdfController extends Controller
{
    public function generatePdf(Request $request)
    {
        $htmlContent = $request->input('html'); // Get HTML content from AJAX

        $pdf = PDF::loadHTML($htmlContent);
        return $pdf->download('digital_menu.pdf');
    }
}
