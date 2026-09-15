<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;

class DocumentationController extends Controller
{
    public function pdf(): Response
    {
        return Pdf::loadView('documentation.pdf')
            ->setPaper('a4')
            ->setOption('isRemoteEnabled', true)
            ->download('dokumentasi-novelku.pdf');
    }
}