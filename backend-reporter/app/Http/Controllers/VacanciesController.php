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
        // Validate the request
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'vacancy_image' => 'nullable|image|max:2048',
        ]);

        // Use a transaction to ensure consistency
        DB::beginTransaction();

        try {
            // Store the image if provided
            $vacancyImage = null;
            if ($request->hasFile('vacancy_image')) {
                $path = $request->file('vacancy_image')->store('vacancy_images', 'public');
                $vacancyImage = $path;
            }

            // Create the vacancy image record
            $image = VacancyImage::create([
                'image_path' => $vacancyImage,
            ]);

            // Create the vacancy
            $vacancy = Vacancy::create([
                'title' => $request->title,
                'description' => $request->description,
                'category' => $request->category,
                'vacancy_image_id' => $image->id,
                'user_id' => Auth::id(),
            ]);

            // If everything is successful, commit the transaction
            DB::commit();

            return response()->json(['message' => 'Vacancy created successfully', 'vacancy' => $vacancy], 201);

        } catch (\Exception $e) {
            // If any error occurs, rollback the transaction
            DB::rollBack();

            // Delete the uploaded image file if it exists
            if ($vacancyImage && Storage::disk('public')->exists($vacancyImage)) {
                Storage::disk('public')->delete($vacancyImage);
            }

            // Optionally, delete the image record (if it was created)
            if (isset($image)) {
                $image->delete();
            }

            // Return an error response
            return response()->json(['error' => 'Failed to create vacancy', 'message' => $e->getMessage()], 500);
        }
    }

    public function index()
    {
        $vacancies = Vacancy::with('user', 'vacancyImage')->get();
        return response()->json($vacancies);
    }
}