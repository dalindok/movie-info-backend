<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class RatingController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'movie_id' => 'required|exists:movies,id',
                'rating'   => 'required|integer|min:1|max:5',
            ]);

            $user = $request->user();

            // If already rated, update it
            $rating = Rating::updateOrCreate(
                ['user_id' => $user->id, 'movie_id' => $validated['movie_id']],
                ['rating' => $validated['rating']]
            );

            return response()->json([
                'message' => 'Rating saved successfully.',
                'data' => $rating,
            ], 201);
        } catch (ValidationException $e) {
            Log::error('Rating store error: ' . $e->getMessage());
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 500);
        }
    }

    public function userRatedMovies(Request $request)
    {
        try {
            $user = $request->user();

            $movies = $user->ratings()
                ->with('movie') // eager-load movie details
                ->latest()
                ->paginate(10); // change per-page if needed

            // Return only the movies, with their ratings
            $data = $movies->map(function ($rating) {
                return [
                    'movie' => $rating->movie,
                    'rating' => $rating->rating,
                    'rated_at' => $rating->created_at,
                ];
            });

            return response()->json([
                'data' => $data,
                'pagination' => [
                    'current_page' => $movies->currentPage(),
                    'last_page'    => $movies->lastPage(),
                    'per_page'     => $movies->perPage(),
                    'total'        => $movies->total(),
                ]
            ]);
        } catch (\Throwable $e) {
            // Log::error('Fetch user rated movies error: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to fetch rated movies.'], 500);
        }
    }


    // public function index(Movie $movie)
    // {
    //     try {
    //         $ratings = $movie->ratings()->with('user')->get();

    //         return response()->json(['data' => $ratings]);
    //     } catch (\Throwable $e) {
    //         Log::error('Fetch ratings error: ' . $e->getMessage());
    //         return response()->json(['message' => 'Failed to fetch ratings.'], 500);
    //     }
    // }

    // public function userRating(Request $request)
    // {
    //     try {
    //         $request->validate([
    //             'movie_id' => 'required|exists:movies,id',
    //         ]);

    //         $rating = Rating::where('movie_id', $request->movie_id)
    //             ->where('user_id', $request->user()->id)
    //             ->first();

    //         return response()->json(['data' => $rating]);
    //     } catch (\Throwable $e) {
    //         Log::error('Fetch user rating error: ' . $e->getMessage());
    //         return response()->json(['message' => 'Failed to fetch rating.'], 500);
    //     }
    // }
}
