<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalMovies = Movie::count();
        $genres = Genre::all();
        $movies = Movie::with('genres')->paginate(10);

        return view('admin.dashboard', [
            'totalUsers' => $totalUsers,
            'totalMovies' => $totalMovies,
            'movies' => $movies,
            'genres' => $genres
        ]);
    }
}
