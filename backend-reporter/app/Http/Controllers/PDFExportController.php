<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Vacancy;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class PDFExportController extends Controller
{
    public function exportUserPDF($id)
    {
        $user = User::findOrFail($id);

        $pdf = PDF::loadView('pdf.user', compact('user'));
        return $pdf->download('user_' . $user->id . '_details.pdf');
    }

    public function exportVacancyPDF($id)
    {
        $vacancy = Vacancy::findOrFail($id);

        $pdf = PDF::loadView('pdf.vacancy', compact('vacancy'));
        return $pdf->download('vacancy_' . $vacancy->id . '.pdf');
    }

    public function status()
    {
        return response()->json([
            'status' => 'PDF API is working',
        ], 200);
    }
}
