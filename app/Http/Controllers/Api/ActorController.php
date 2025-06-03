<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Actor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ActorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $actors = Actor::all();
            return response()->json([
                'message' => 'Actors retrieved successfully.',
                'data' => $actors
            ]);
        } catch (\Throwable $e) {
            Log::error('Actor index error: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to fetch actors.'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
            ]);

            $actor = Actor::create($validated);

            return response()->json([
                'message' => 'Actor created successfully.',
                'data' => $actor
            ], 201);
        } catch (\Throwable $e) {
            Log::error('Actor store error: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to create actor.'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $actor = Actor::findOrFail($id);
            return response()->json([
                'message' => 'Actor retrieved successfully.',
                'data' => $actor
            ]);
        } catch (\Throwable $e) {
            Log::error('Actor show error: ' . $e->getMessage());
            return response()->json(['message' => 'Actor not found.'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $actor = Actor::findOrFail($id);

            $validated = $request->validate([
                'name' => 'required|string|max:255',
            ]);

            $actor->update($validated);

            return response()->json([
                'message' => 'Actor updated successfully.',
                'data' => $actor
            ]);
        } catch (\Throwable $e) {
            Log::error('Actor update error: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to update actor.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $actor = Actor::findOrFail($id);
            $actor->delete();

            return response()->json(['message' => 'Actor deleted successfully.']);
        } catch (\Throwable $e) {
            Log::error('Actor delete error: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to delete actor.'], 500);
        }
    }
}
