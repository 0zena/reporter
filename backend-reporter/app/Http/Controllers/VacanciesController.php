<?php

namespace App\Http\Controllers;

use App\Models\Vacancy;
use App\Models\VacancyImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class VacanciesController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'speciality_id' => 'nullable|exists:specialities,id',
            'vacancy_image' => 'nullable|image|max:2048',
        ]);

        DB::beginTransaction();

        try {
            $vacancyImage = null;
            $image = null;
            $imageID = null;

            if ($request->hasFile('vacancy_image')) {
                $path = $request->file('vacancy_image')->store('vacancy_images', 'public');
                $vacancyImage = $path;

                $image = VacancyImage::create([
                    'image_path' => $vacancyImage,
                ]);

                $imageID = $image->id;
            }

            $vacancy = Vacancy::create([
                'title' => $request->title,
                'description' => $request->description,
                'category_id' => $request->category_id, // Store category_id as a foreign key
                'speciality_id' => $request->speciality_id, // Store speciality_id as a foreign key
                'vacancy_image_id' => $imageID,
                'user_id' => Auth::id(),
            ]);

            DB::commit();

            return response()->json(['message' => 'Vacancy created successfully', 'vacancy' => $vacancy], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            if ($vacancyImage && Storage::disk('public')->exists($vacancyImage)) {
                Storage::disk('public')->delete($vacancyImage);
            }

            if (isset($image)) {
                $image->delete();
            }

            return response()->json(['error' => 'Failed to create vacancy', 'message' => $e->getMessage()], 500);
        }
    }

    public function index()
    {
        $vacancies = Vacancy::with(['user', 'vacancyImage', 'category', 'speciality'])->get();

        // Transform the data to include names instead of ids
        $vacancies->transform(function ($vacancy) {
            return [
                'id' => $vacancy->id,
                'title' => $vacancy->title,
                'description' => $vacancy->description,
                'vacancy_image' => $vacancy->vacancyImage,
                'category' => $vacancy->category->name, // Get category name
                'speciality' => $vacancy->speciality ? $vacancy->speciality->name : null, // Get speciality name if it exists
            ];
        });

        return response()->json($vacancies);
    }

    public function show($id)
    {
        $vacancy = Vacancy::with(['vacancyImage', 'category', 'speciality'])->find($id);

        if (!$vacancy) {
            return response()->json(['error' => 'Vacancy not found'], 404);
        }

        $vacancy->vacancy_image_url = $vacancy->vacancyImage ? Storage::url($vacancy->vacancyImage->image_path) : null;

        return response()->json([
            'title' => $vacancy->title,
            'description' => $vacancy->description,
            'category' => $vacancy->category->name, // Get category name
            'speciality' => $vacancy->speciality ? $vacancy->speciality->name : null, // Get speciality name if it exists
            'image' => $vacancy->vacancy_image_url,
        ], 200);
    }
}