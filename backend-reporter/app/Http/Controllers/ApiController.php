<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    // Simple test call to check if API is available
    public function status()
    {
        return response()->json([
            'status' => 'API is working',
        ], 200);
    }

}
