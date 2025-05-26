<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Web\AdminController as WebAdminController;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\MovieController;

// Route::get('/admin/movies/create', [AdminController::class, 'createMovie'])->name('admin.movies.create');
// // Route::post('/admin/movies/store', [AdminController::class, 'storeMovie'])->name('admin.movies.store');
// Route::post('/admin/movies/show', [AdminController::class, 'showMovie'])->name('admin.movies.show');
// Route::get('/admin/movies/{id}/edit', [AdminController::class, 'editMovie'])->name('admin.movies.edit');
// Route::put('/admin/movies/{id}', [AdminController::class, 'updateMovie'])->name('admin.movies.update');
// Route::delete('/admin/movies/{id}', [AdminController::class, 'deleteMovie'])->name('admin.movies.delete');

Route::get('/', function () {
    return view('login');
})->name('login');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', [WebAdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::resource('/admin/movies', MovieController::class);
});

// Static admin login route
// Route::post('/login', function (Request $request) {
//     $adminEmail = 'admin@gmail.com';
//     $adminPassword = '12345678';

//     if ($request->email === $adminEmail && $request->password === $adminPassword) {
//         session(['is_admin' => true]);
//         return redirect('/admin/dashboard');
//     }

//     return back()->withErrors(['email' => 'Invalid email or password.']);
// })->name('login.post');

// Route::get('/dashboard', function () {
//     if (!session('is_admin')) {
//         return redirect('/');
//     }

//     return view('admin.dashboard');
// })->name('dashboard');

// Route::post('/logout', function () {
//     session()->forget('is_admin');
//     return redirect('/');
// })->name('logout');
