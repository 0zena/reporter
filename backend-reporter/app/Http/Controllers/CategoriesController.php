<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Category::create([
            'name' => $request->input('name'),
        ]);

        return response()->json($category, 201);
    }

    public function index()
    {
        return response()->json(Category::all());
    }

    public function checkIfExists(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $exists = Category::where('name', $request->name)->exists();

        return response()->json(['exists' => $exists]);
    }
    
}
