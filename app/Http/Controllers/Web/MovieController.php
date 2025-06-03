<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Actor;
use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MovieController extends Controller
{
    public function index(Request $request)
    {
        $movies = Movie::with(['genres', 'actors'])->paginate(10);
        return view('admin.dashboard', compact('movies'));
        
    }

    public function create()
    {
        $genres = Genre::all();
        $actors = Actor::all();
        return view('movies.create', compact('genres', 'actors'));
    }

//     public function store(Request $request)
//     {
//   Log::info('Creating a new movie', ['genre_id' => $request->genre_id]);
//   Log::info('Creating a new movie', ['actor_id' => $request->genre_id]);
//         $validated = $request->validate([
//         //     'title'         => 'required|string|max:255',
//         //     'description'   => 'nullable|string',
//         //     'release_date'  => 'required|date',
//         //     'poster'        => 'nullable|url',
//         //     'trailer'       => 'nullable|url',
//         //     'genre_id'     => 'array',
//         'genre_id' => 'required|array',
//         'actor_id' => 'required|array',
//         //     'actor_id'     => 'array',
//         ]);
        

//         // $movie = Movie::create($validated);
//         // $movie->genres()->sync($request->genre_ids ?? []);
//         // $movie->actors()->sync($request->actor_ids ?? []);

//         // return redirect()->route('admin.dashboard')->with('success', 'Movie created successfully.');
    // }

public function store(Request $request)
{
    Log::info('Creating a new movie', ['genre_id' => $request->genre_id]);
    Log::info('Creating a new movie', ['actor_id' => $request->actor_id]);

    $validated = $request->validate([
        'title'         => 'required|string|max:255',
        'description'   => 'nullable|string',
        'release_date'  => 'required|date',
        'poster'        => 'nullable|url',
        'trailer'       => 'nullable|url',
        'genre_id'      => 'required|array',
        'genre_id.*'    => 'integer|exists:genres,id',
        'actor_id'      => 'required|array',
        'actor_id.*'    => 'integer|exists:actors,id',
    ]);

    $movie = Movie::create([
        'title' => $request->title,
        'description' => $request->description,
        'release_date' => $request->release_date,
        'poster' => $request->poster,
        'trailer' => $request->trailer,
    ]);

    $movie->genres()->sync($request->genre_id);
    $movie->actors()->sync($request->actor_id);

    return redirect()->route('admin.dashboard')->with('success', 'Movie created successfully.');
}


    public function show($id)
    {
        $movie = Movie::with(['genres', 'actors'])->findOrFail($id);
        return view('movies.show', compact('movie'));
    }

    public function edit(Movie $movie)
    {
        $genres = Genre::all();
        $actors = Actor::all();
        return view('movies.edit', compact('movie', 'genres', 'actors'));
    }

    public function update(Request $request, Movie $movie)
    {
        $validated = $request->validate([
            'title'         => 'required|string|max:255',
            'description'   => 'nullable|string',
            'release_date'  => 'required|date',
            'poster'        => 'nullable|url',
            'trailer'       => 'nullable|url',
            'genre_ids'     => 'array',
            'actor_ids'     => 'array',
        ]);

        $movie->update($validated);
        $movie->genres()->sync($request->genre_ids ?? []);
        $movie->actors()->sync($request->actor_ids ?? []);

        return redirect()->route('admin.dashboard')->with('success', 'Movie updated successfully.');
    }


    public function destroy(Movie $movie)
    {
        $movie->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Movie deleted successfully.');
    }
}
