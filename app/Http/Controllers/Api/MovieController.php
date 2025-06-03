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
        $query = Movie::with(['genres', 'actors']);

        // Filter by genre ID (e.g., ?genre_id=3)
        if ($genreId = $request->input('genre_id')) {
            $query->whereHas('genres', function ($q) use ($genreId) {
                $q->where('genres.id', $genreId);
            });
        }

        // Filtering popular, upcoming, most rated
        if ($request->has('popular')) {
            $query->popular();
        }

        if ($request->has('upcoming')) {
            $query->upcoming();
        }

        if ($request->has('most_rated')) {
            $query->mostRated();
        }

        // Optional search
        if ($search = $request->input('search')) {
            $query->where('title', 'like', "%$search%");
        }
        

        // Pagination
        $perPage = $request->input('per_page', 10);
        $movies = $query->paginate($perPage);

        return response()->json([
            'message' => 'Movies retrieved successfully',
            'data'    => $movies->items(),
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
    public function show(string $id)
    {
        $movie = Movie::with(['genres', 'actors', 'ratings'])->find($id);

        if (!$movie) {
            return response()->json(['message' => 'Movie not found.'], 404);
        }

        return response()->json(['message' => 'Movie detail', 'data' => $movie]);
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
