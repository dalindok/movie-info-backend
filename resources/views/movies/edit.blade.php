@extends('layouts.app')

@section('content')
<main class="py-5">
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-md-8">

                <div class="card">
                    <div class="card-header">
                        <h4>Edit Movie</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('movies.update', $movie->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Movie Title -->
                            <div class="mb-3">
                                <label for="movie_title" class="form-label">Movie Title</label>
                                <input type="text" class="form-control" name="movie_title" id="movie_title"
                                    value="{{ old('movie_title', $movie->movie_title) }}" required>
                            </div>

                            <!-- Description -->
                            <div class="mb-3">
                                <label for="movie_description" class="form-label">Description</label>
                                <textarea class="form-control" name="movie_description" id="movie_description" rows="4"
                                    required>{{ old('movie_description', $movie->description) }}</textarea>
                            </div>

                            <!-- Released Date -->
                            <div class="mb-3">
                                <label for="released_date" class="form-label">Released Date</label>
                                <input type="date" class="form-control" name="released_date" id="released_date"
                                    value="{{ old('released_date', $movie->released_date) }}" required>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">Update Movie</button>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</main>
@endsection
