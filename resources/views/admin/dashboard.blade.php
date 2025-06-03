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
    {{-- <div lass="row mb-4"> --}}
        {{-- <div class="col-md-6">
            <a href="{{ route('movies.create') }}" class="btn btn-primary">➕ Add New Movie</a>
        </div> --}}
       <div class="col-mb-6 pb-2">
            <div class="input-group-append">
                <form method="GET" action="{{ route('admin.dashboard') }}">
                    <div class="flex gap-2 items-center">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search by title"
                            class="border rounded px-3 py-2" />
                            <button class="btn btn-outline-secondary" type="submit" id="button-addon2">
                            <i class="bi bi-search-heart"></i>
                    </button>
                        @if(request('search'))
                        <a href="{{ route('admin.dashboard') }}" class="text-sm text-blue-600 hover:underline">Clear</a>
                        @endif
                    </div>
                </form>
            </div>   
        </div>        
 
    {{-- </div> --}}


    <!-- Movies Table -->
    <div class="card shadow-sm">
        <div class="card-header bg-[#1D1616] text-white">
            <h1 class="mb-0">Movies List</h1>
            {{-- @include('admin.movies._movie-search') --}}
        </div>
        <div class="card-body p-0">
            
            <table class="table table-striped table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th>Title</th>
                        <th>Genres</th>
                        <th>Rating</th>
                        <th>Description</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($movies->isEmpty())
                        <tr>
                            <td colspan="5" class="text-center text-muted">No movies found.</td>
                        </tr>
                    @else
                        @foreach ($movies as $movie)
                            <tr>
                                <td>{{ $movie->title }}</td>

                                <td>
                                    @if ($movie->genres->isNotEmpty())
                                        {{ $movie->genres->pluck('name')->join(', ') }}
                                    @else
                                        N/A
                                    @endif
                                </td>

                                <td>{{ $movie->average_rating ?? 'N/A' }}</td>
                                <td>{{ Str::limit($movie->description, 50) }}</td>

                                <td class="text-end">
                                    {{-- Future actions --}}
                                    <a href="{{ route('movies.show', $movie->id) }}" class="btn btn-sm btn-info">View</a>
                                    {{-- <a href="{{ route('movies.edit', $movie->id) }}" class="btn btn-sm btn-warning">Edit</a> --}}
                                    <form action="{{ route('movies.destroy', $movie->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this movie?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            {{-- Pagination links --}}
            {{-- <div class="mt-3">
                {{ $movies->links() }}
            </div> --}}
            <nav class="mt-4">
                <ul class="pagination justify-content-center">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">Next</a>
                    </li>
                </ul>
            </nav>
        </div>

    </div>
</div>
@endsection
