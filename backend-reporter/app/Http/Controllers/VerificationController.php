<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Notifications\VerifyEmail;

class VerificationController extends Controller
{
    public function sendVerificationEmail(Request $request)
{
    $user = Auth::user();
    $user->notify(new VerifyEmail);
    
    return response()->json([
        'status' => 'success',
        'message' => 'Verification email sent.'
    ]);
}
}