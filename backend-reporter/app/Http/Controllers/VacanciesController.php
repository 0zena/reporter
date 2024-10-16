<?php

namespace App\Http\Controllers;

use App\Models\Vacancy;
use App\Models\VacancyImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VacanciesController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'vacancy_image' => 'nullable|image|max:2048',
        ]);

        // Store the image if provided
        $vacancyImage = null;
        if ($request->hasFile('vacancy_image')) {
            $path = $request->file('vacancy_image')->store('vacancy_images', 'public');
            $vacancyImage = $path;
        }

        $image = VacancyImage::Create([
            'image_path' => $vacancyImage,
        ]);

        $imageID = $image->id;

        // Create vacancy
        $vacancy = Vacancy::create([
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'vacancy_image_id' => $imageID,
            'user_id' => Auth::id(),
        ]);

        return response()->json(['message' => 'Vacancy created successfully', 'vacancy' => $vacancy], 201);
    }

    public function index()
    {
        $vacancies = Vacancy::with('user')->get();
        return response()->json($vacancies);
    }
}