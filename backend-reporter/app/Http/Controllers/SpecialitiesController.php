<?php

namespace App\Http\Controllers;

use App\Models\Speciality; // Import the Speciality model
use Illuminate\Http\Request;

class SpecialitiesController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255', // Validate speciality name
            'category_id' => 'required|exists:categories,id', // Validate category ID
        ]);

        $speciality = Speciality::create([
            'name' => $request->input('name'),
            'category_id' => $request->input('category_id'),
        ]);

        return response()->json($speciality, 201); // Return the created speciality with a 201 status code
    }

    public function getByCategory($categoryId)
    {
        $specialities = Speciality::where('category_id', $categoryId)->get();

        if ($specialities->isEmpty()) {
            return response()->json(['message' => 'No specialities found for this category'], 404);
        }

        return response()->json($specialities, 200);
    }
}
