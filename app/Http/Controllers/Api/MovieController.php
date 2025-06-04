<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $userId = $request->input('user_id');
        $query = Movie::with(['genres', 'actors'])->withAvg('ratings', 'rating');

        // Filter by genre ID
        if ($genreId = $request->input('genre_id')) {
            $query->whereHas('genres', function ($q) use ($genreId) {
                $q->where('genres.id', $genreId);
            });
        }

        // Filter by popular
        if ($request->filled('popular') && $request->input('popular') == 1) {
            $query->popular();
        }

        // Filter by upcoming
        if ($request->filled('upcoming') && $request->input('upcoming') == 1) {
            $query->upcoming();
        }

        // Most rated
        if ($request->has('most_rated')) {
            $query->mostRated();
        }

        // Search
        if ($search = $request->input('search')) {
            $query->where('title', 'like', "%$search%");
        }

        // Pagination
        $perPage = $request->input('per_page', 10);
        $movies = $query->paginate($perPage);

        // Transform each movie to add user_rate and is_watchlisted
        $transformed = collect($movies->items())->map(function ($movie) use ($userId) {
            $userRate = 0;
            $isWatchlisted = false;

            if ($userId) {
                // Get the rating
                $rating = $movie->ratings()->where('user_id', $userId)->first();
                $userRate = $rating ? $rating->rating : 0;

                // Check watchlist
                $isWatchlisted = $movie->watchlists()->where('user_id', $userId)->exists();
            }

            return [
                'id' => $movie->id,
                'title' => $movie->title,
                'description' => $movie->description,
                'average_rating' => round($movie->ratings_avg_rating, 1),
                'release_date' => $movie->release_date,
                'poster' => $movie->poster,
                'trailer' => $movie->trailer,
                'genres' => $movie->genres,
                'actors' => $movie->actors,
                'user_rate' => $userRate,
                'is_watchlisted' => $isWatchlisted,
            ];
        });

        return response()->json([
            'message' => 'Movies retrieved successfully',
            'data'    => $transformed,
            'meta'    => [
                'page'        => $movies->currentPage(),
                'perPage'     => $movies->perPage(),
                'totalItems'  => $movies->total(),
                'totalPages'  => $movies->lastPage(),
            ],
        ]);
    }




    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'         => 'required|string',
            'description'   => 'nullable|string',
            'release_date'  => 'required|date',
            'poster' => 'sometimes|nullable|string',
            'trailer' => 'sometimes|nullable|string',
            'genre_ids'     => 'array',
            'actor_ids'     => 'array',
        ]);

        $movie = Movie::create($validated);
        $movie->genres()->sync($request->genre_ids ?? []);
        $movie->actors()->sync($request->actor_ids ?? []);

        return response()->json(['message' => 'Movie created.', 'data' => $movie], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $userId = $request->input('user_id');

        $movie = Movie::with(['genres', 'actors'])
            ->withAvg('ratings', 'rating')
            ->find($id);

        if (!$movie) {
            return response()->json(['message' => 'Movie not found.'], 404);
        }

        // Default values
        $userRate = 0;
        $isWatchlisted = false;

        if ($userId) {
            // Check rating by the user
            $rating = $movie->ratings()->where('user_id', $userId)->first();
            $userRate = $rating ? $rating->rating : 0;

            // Check if movie is in user's watchlist
            $isWatchlisted = $movie->watchlists()->where('user_id', $userId)->exists();
        }

        return response()->json([
            'message' => 'Movie detail',
            'data' => [
                'id'              => $movie->id,
                'title'           => $movie->title,
                'description'     => $movie->description,
                'average_rating'  => round($movie->ratings_avg_rating, 1),
                'release_date'    => $movie->release_date,
                'poster'          => $movie->poster,
                'trailer'         => $movie->trailer,
                'genres'          => $movie->genres,
                'actors'          => $movie->actors,
                'user_rate'       => $userRate,
                'is_watchlisted'  => $isWatchlisted,
            ]
        ]);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $movie = Movie::find($id);

        if (!$movie) {
            return response()->json(['message' => 'Movie not found.'], 404);
        }

        $validated = $request->validate([
            'title'        => 'sometimes|string',
            'description'  => 'sometimes|string',
            'release_date' => 'sometimes|date',
            'rating'       => 'sometimes|numeric|min:0|max:10',
            'poster' => 'sometimes|nullable|string',
            'trailer' => 'sometimes|nullable|string',
            'genre_ids'    => 'sometimes|array',
            'actor_ids'    => 'sometimes|array',
        ]);

        $movie->update($validated);
        if ($request->has('genre_ids')) {
            $movie->genres()->sync($request->genre_ids);
        }
        if ($request->has('actor_ids')) {
            $movie->actors()->sync($request->actor_ids);
        }

        return response()->json(['message' => 'Movie updated.', 'data' => $movie]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $movie = Movie::find($id);

        if (!$movie) {
            return response()->json(['message' => 'Movie not found.'], 404);
        }

        $movie->delete();
        return response()->json(['message' => 'Movie deleted.']);
    }
}
