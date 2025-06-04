<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Watchlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WatchlistController extends Controller
{
    // GET /api/watchlist
    public function index(Request $request)
    {
        try {
            $user = $request->user();

            $watchlist = $user->watchlists()
                ->with(['movie' => function ($q) {
                    $q->withAvg('ratings', 'rating');
                }])
                ->latest()
                ->paginate(10);

            $data = $watchlist->map(function ($item) {
                return [
                    'movie' => [
                        'id'             => $item->movie->id,
                        'title'          => $item->movie->title,
                        'poster'         => $item->movie->poster,
                        'average_rating' => round($item->movie->ratings_avg_rating, 1),
                    ],
                    'added_at' => $item->created_at,
                ];
            });

            return response()->json([
                'message' => 'Watchlist successfully',
                'data' => $data,
                'pagination' => [
                    'current_page' => $watchlist->currentPage(),
                    'last_page'    => $watchlist->lastPage(),
                    'per_page'     => $watchlist->perPage(),
                    'total'        => $watchlist->total(),
                ]
            ]);
        } catch (\Throwable $e) {
            Log::error('Fetch watchlist error: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to fetch watchlist.'], 500);
        }
    }


    // POST /api/watchlist
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'movie_id' => 'required|exists:movies,id',
            ]);

            $user = $request->user();

            // Prevent duplicate entry
            $exists = Watchlist::where('user_id', $user->id)
                ->where('movie_id', $validated['movie_id'])
                ->exists();

            if ($exists) {
                return response()->json(['message' => 'Movie already in watchlist.'], 409);
            }

            $watchlist = Watchlist::create([
                'user_id'  => $user->id,
                'movie_id' => $validated['movie_id'],
            ]);

            return response()->json(['message' => 'Movie added to watchlist.', 'data' => $watchlist], 201);
        } catch (\Throwable $e) {
            Log::error('Add to watchlist error: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to add movie to watchlist.'], 500);
        }
    }

    // DELETE /api/watchlist/{movie_id}
    public function destroy(Request $request, $movie_id)
    {
        try {
            $user = $request->user();

            $deleted = Watchlist::where('user_id', $user->id)
                ->where('movie_id', $movie_id)
                ->delete();

            if (!$deleted) {
                return response()->json(['message' => 'Movie not found in watchlist.'], 404);
            }

            return response()->json(['message' => 'Movie removed from watchlist.']);
        } catch (\Throwable $e) {
            Log::error('Remove from watchlist error: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to remove movie from watchlist.'], 500);
        }
    }
}
