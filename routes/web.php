<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;

Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
// Route::get('/admin/movies/create', [AdminController::class, 'createMovie'])->name('admin.movies.create');
// // Route::post('/admin/movies/store', [AdminController::class, 'storeMovie'])->name('admin.movies.store');
// Route::post('/admin/movies/show', [AdminController::class, 'showMovie'])->name('admin.movies.show');
// Route::get('/admin/movies/{id}/edit', [AdminController::class, 'editMovie'])->name('admin.movies.edit');
// Route::put('/admin/movies/{id}', [AdminController::class, 'updateMovie'])->name('admin.movies.update');
// Route::delete('/admin/movies/{id}', [AdminController::class, 'deleteMovie'])->name('admin.movies.delete');

Route::resource('movies', AdminController::class);
Route::get('/', function () {
    return view('login');
})->name('login');

// Static admin login route
Route::post('/login', function (Request $request) {
    $adminEmail = 'admin@gmail.com';
    $adminPassword = '12345678';

    if ($request->email === $adminEmail && $request->password === $adminPassword) {
        session(['is_admin' => true]);
        return redirect('/admin/dashboard');
    }

    return back()->withErrors(['email' => 'Invalid email or password.']);
})->name('login.post');

Route::get('/dashboard', function () {
    if (!session('is_admin')) {
        return redirect('/');
    }

    return view('admin.dashboard');
})->name('dashboard');

Route::post('/logout', function () {
    session()->forget('is_admin');
    return redirect('/');
})->name('logout');
