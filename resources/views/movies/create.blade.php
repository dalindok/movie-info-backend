@extends('layouts.app')
@section('content')
<main class="py-5">
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-md-10">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <strong>Add New Movie</strong>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('movies.store') }}" method="POST">
                            @csrf

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="title" class="form-label">Movie Title</label>
                                    <input type="text" name="title" id="title" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="description" class="form-label">Description</label>
                                    <input type="text" name="description" id="description" class="form-control" required>
                                </div>
                            </div>

                          <div class="mb-3">
    <label for="genre_id" class="form-label">Genre</label>
    <select name="genre_id" id="genre_id" class="form-select" required>
        <option value="">-- Select Genre --</option>
        @foreach ($genres as $genre)
            <option value="{{ $genre->id }}">{{ $genre->name }}</option>
        @endforeach
    </select>
</div>


                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="actor1" class="form-label">Main Actor</label>
                                    <input type="text" name="actor1" id="actor1" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="actor2" class="form-label">Supporting Actor</label>
                                    <input type="text" name="actor2" id="actor2" class="form-control">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="poster_url" class="form-label">Poster Image URL</label>
                                <input type="url" name="poster_url" id="poster_url" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="trailer_url" class="form-label">Trailer Link (YouTube)</label>
                                <input type="url" name="trailer_url" id="trailer_url" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label for="release_date" class="form-label">Release Date</label>
                                <input type="date" name="release_date" id="release_date" class="form-control" required>
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Create</button>
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
