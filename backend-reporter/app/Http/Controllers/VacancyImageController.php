<?php

namespace App\Http\Controllers;

use App\Models\VacancyImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VacancyImageController extends Controller
{
    /**
     * Store a new image for a vacancy.
     */
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'vacancy_id' => 'required|exists:vacancies,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validation for image file
        ]);

        // Handle the image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('vacancy_images', 'public'); // Save image to storage/app/public/vacancy_images

            // Save image information in the database
            $vacancyImage = VacancyImage::create([
                'vacancy_id' => $request->vacancy_id,
                'image_path' => $imagePath,
            ]);

            return response()->json(['message' => 'Image uploaded successfully!', 'data' => $vacancyImage], 201);
        }

        return response()->json(['message' => 'No image uploaded'], 400);
    }

    /**
     * Delete an image.
     */
    public function destroy($id)
    {
        $image = VacancyImage::find($id);

        if ($image) {
            Storage::disk('public')->delete($image->image_path); // Delete the file from storage
            $image->delete(); // Delete the record from the database

            return response()->json(['message' => 'Image deleted successfully!']);
        }

        return response()->json(['message' => 'Image not found'], 404);
    }
}
