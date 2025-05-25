@extends('layouts.app')

@section('content')
<div class="container my-4">
    <h1 class="mb-4">Admin Dashboard</h1>

    <!-- Stats Cards -->
    <div class="row mb-4">
         <div class="col-md-6">
            <div class="card text-white bg-success mb-3 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Total Movies</h5>
                    <p class="card-text fs-4">{{ $totalMovies }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card text-white bg-primary mb-3 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Total Users</h5>
                    <p class="card-text fs-4">{{ $totalUsers }}</p>
                </div>
            </div>
        </div>

       
    </div>

    <!-- Add New Movie Button -->
    <div class="mb-4">
        <a href="{{ route('admin.movies.create') }}" class="btn btn-primary">➕ Add New Movie</a>
    </div>

    <!-- Movies Table -->
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">Movies List</h5>
            @include('admin.movies._movie-search')
        </div>
        <div class="card-body p-0">
            
            <table class="table table-striped table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Title</th>
                        <th>Genre</th>
                        <th>Rating</th>
                        <th>Description</th>
                        <th class="text-end me-6">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($movies->isEmpty())
                        <tr>
                            <td colspan="3" class="text-center text-muted">No movies found.</td>
                        </tr>
                    @else
                        @foreach ($movies as $movie)
                            <tr>
                                
                                <td>{{ $movie->movie_title }}</td>
                                <td>{{ $movie->genres->name ?? 'N/A' }}</td>
                                <td>{{ $movie->rating->name ?? 'N/A' }}</td>
                                <td>{{ $movie->movie_description }}</td>
                                <td class="text-end">
                                     <a href="{{ route('admin.movies.show', $movie->id) }}"
                                                       class="btn btn-sm btn-circle btn-outline-info" title="Show">
                                                        View
                                                    </a>
                                    <a href="{{ route('admin.movies.edit', $movie->id) }}" class="btn btn-sm btn-warning " title="Edit">
                                         Edit
                                    </a>
                                    
                                    <form action="{{ route('admin.movies.delete', $movie->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this movie?')" title="Delete">
                                            Delete
                                        </button>
                                    </form>
                               
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
               <nav class="mt-4">
                                <ul class="pagination justify-content-center">
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">Next</a>
                                    </li>
                                </ul>
                            </nav>
        </div>

    </div>
</div>
@endsection
