<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
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
}
