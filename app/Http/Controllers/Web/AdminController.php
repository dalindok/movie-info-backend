<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        $totalUsers = User::count();
        $totalMovies = Movie::count();
        $genres = Genre::all();
        // $movies = Movie::with('genres')->paginate(10);
        $query = Movie::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('title', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%');
        }

    $movies = $query->with(['genres', 'actors'])->paginate(10); // or ->get()
        return view('admin.dashboard', [
            'totalUsers' => $totalUsers,
            'totalMovies' => $totalMovies,
            'movies' => $movies,
            'genres' => $genres
        ]);
       

    // return view('movies.', compact('movies'));
    }
}
