<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class PDFExportController extends Controller
{
    public function exportUserPDF($id)
    {
        // Fetch the user data by ID
        $user = User::findOrFail($id);

        // Load the view and pass the user data to it
        $pdf = PDF::loadView('pdf.user', compact('user'));

        // Download the PDF
        return $pdf->download('user_' . $user->id . '_details.pdf');
    }

    public function status()
    {
        return response()->json([
            'status' => 'PDF API is working',
        ], 200);
    }
}
