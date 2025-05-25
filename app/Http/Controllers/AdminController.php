<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Movie;
use Illuminate\Http\Request;
use App\Models\Genre;

class AdminController extends Controller
{
  public function dashboard()
    {
        $totalUsers = User::count();
        $totalMovies = Movie::count();
        $movies = Movie::all();
        $genres = Genre::all();
        return view('admin.dashboard', [
            'totalUsers' => $totalUsers,
            'totalMovies' => $totalMovies,
            'movies' => $movies,
            'genres' => $genres
        ]);
        $movies = Movie::paginate(10);
return view('admin.dashboard'
, compact('movies'));
    }

public function createMovie()
{
    
    $genres = Genre::all(); // Fetch genres from the database
    return view('admin.movies.create', compact('genres'));
}

// try {
    public function storeMovie(Request $request)
{
    logger('Validated Data:', [$request]);
      try {
    $validated = $request->validate([
        'movie_title' => 'required|string|max:255',
        'movie_description' => 'required|string',
        'genre_id' => 'required|exists:genres,id',
        // 'rate_id' => 'nullable|exis ts:rates,id',
        'actor1' => 'required|string|max:255',
        // 'actor2' => 'nullable|string|max:255',
        'movie_poster' => 'required|url',
        // 'movie_trailer' => 'nullable|url',
        'release_date' => 'required|date',
        
    ]);
        

    // Movie::create([
    //     'movie_title' => $validated['movie_title'],
    //     'movie_description' => $validated['movie_description'],
    //     'genre_id' => $validated['genre_id'],
    //     'rate_id' => $validated['rate_id'] ?? null,
    //     'actor1' => $validated['actor1'],
    //     'actor2' => $validated['actor2'] ?? null,
    //     'movie_poster' => $validated['movie_poster'],
    //     'movie_trailer' => $validated['movie_trailer'] ?? null,
    //     'released_date' => $validated['release_date'],
    //     // 'rating' => $validated['rating'] ?? null,
    // ]);


    Movie::create($validated);
    logger('Validated Data:', $validated);
    
    return redirect()->route('admin.dashboard')->with('success', 'Movie added successfully!');
     } catch (ValidationException $e) {
          return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);
        }
}
// } catch (\Throwable $th) {
//     //throw $th;
// }


    public function editMovie($id)
    {
        $movies = Movie::findOrFail($id);
        return view('admin.movies.edit', compact('movies'));
    }

    public function updateMovie(Request $request, $id)
    {
        $movies = Movie::findOrFail($id);
        $movies->update($request->all());

        return redirect()->route('admin.dashboard')->with('success', 'Movie updated successfully.');
    }

    public function deleteMovie($id)
    {
        $movies = Movie::findOrFail($id);
        $movies->delete();

        return back()->with('success', 'Movie deleted successfully.');
    }
}
