<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Vacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoritesController extends Controller
{
    public function isFavorited($vacancyId)
    {
        $isFavorited = Favorite::where('user_id', Auth::id())
            ->where('vacancy_id', $vacancyId)
            ->exists();

        return response()->json(['isFavorited' => $isFavorited]);
    }

    public function toggleFavorite(Request $request, $vacancyId)
    {
        $favorite = Favorite::where('user_id', Auth::id())
            ->where('vacancy_id', $vacancyId)
            ->first();

        if ($favorite) {
            $favorite->delete();
            return response()->json(['message' => 'Removed from favorites']);
        } else {
            Favorite::create([
                'user_id' => Auth::id(),
                'vacancy_id' => $vacancyId,
            ]);
            return response()->json(['message' => 'Added to favorites']);
        }
    }

    public function getFavoritedVacancies()
    {
        $userId = Auth::id(); // Get the authenticated user's ID
        $favorites = Favorite::where('user_id', $userId)->pluck('vacancy_id'); // Get the IDs of favorited vacancies

        // Fetch vacancies based on the favorited IDs
        $vacancies = Vacancy::with(['user', 'vacancyImage', 'category', 'speciality'])
            ->whereIn('id', $favorites)
            ->get();

        // Transform the data to include names instead of ids
        $vacancies->transform(function ($vacancy) {
            return [
                'id' => $vacancy->id,
                'title' => $vacancy->title,
                'description' => $vacancy->description,
                'vacancy_image' => $vacancy->vacancyImage,
                'category' => $vacancy->category->name, // Keep category name
                'category_id' => $vacancy->category->id, // Include category ID
                'speciality' => $vacancy->speciality ? $vacancy->speciality->name : null, // Keep speciality name if it exists
                'speciality_id' => $vacancy->speciality ? $vacancy->speciality->id : null, // Include speciality ID if it exists
            ];
        });

        return response()->json($vacancies);
    }
}
