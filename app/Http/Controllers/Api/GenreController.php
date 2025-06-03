<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $genres = Genre::all();
            return response()->json([
                'message' => 'Genres retrieved successfully.',
                'data' => $genres
            ]);
        } catch (\Throwable $e) {
            Log::error('Genre index error: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to fetch genres.'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|unique:genres,name',
            ]);

            $genre = Genre::create($validated);

            return response()->json([
                'message' => 'Genre created successfully.',
                'data' => $genre
            ], 201);
        } catch (\Throwable $e) {
            Log::error('Genre store error: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to create genre.'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $genre = Genre::findOrFail($id);
            return response()->json([
                'message' => 'Genre retrieved successfully.',
                'data' => $genre
            ]);
        } catch (\Throwable $e) {
            Log::error('Genre show error: ' . $e->getMessage());
            return response()->json(['message' => 'Genre not found.'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $genre = Genre::findOrFail($id);

            $validated = $request->validate([
                'name' => 'required|string|unique:genres,name,' . $id,
            ]);

            $genre->update($validated);

            return response()->json([
                'message' => 'Genre updated successfully.',
                'data' => $genre
            ]);
        } catch (\Throwable $e) {
            Log::error('Genre update error: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to update genre.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $genre = Genre::findOrFail($id);
            $genre->delete();

            return response()->json(['message' => 'Genre deleted successfully.']);
        } catch (\Throwable $e) {
            Log::error('Genre delete error: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to delete genre.'], 500);
        }
    }
}
