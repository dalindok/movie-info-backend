@extends('layouts.app')
@section('content')
<main class="py-5">
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header card-title">
                        <strong>Movie Details</strong>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">

                                <div class="mb-2 row">
                                    <label class="col-md-3 col-form-label">Title</label>
                                    <div class="col-md-9">
                                        <p class="form-control-plaintext text-muted">{{ $movie->movie_title }}</p>
                                    </div>
                                </div>

                                <div class="mb-2 row">
                                    <label class="col-md-3 col-form-label">Description</label>
                                    <div class="col-md-9">
                                        <p class="form-control-plaintext text-muted">{{ $movie->description }}</p>
                                    </div>
                                </div>

                                <div class="mb-2 row">
                                    <label class="col-md-3 col-form-label">Genre</label>
                                    <div class="col-md-9">
                                        <p class="form-control-plaintext text-muted">{{ $movie->genre->name ?? 'N/A' }}</p>
                                    </div>
                                </div>

                                <div class="mb-2 row">
                                    <label class="col-md-3 col-form-label">Rating</label>
                                    <div class="col-md-9">
                                        <p class="form-control-plaintext text-muted">{{ $movie->rating->name ?? 'N/A' }}</p>
                                    </div>
                                </div>

                                <div class="mb-2 row">
                                    <label class="col-md-3 col-form-label">Released Date</label>
                                    <div class="col-md-9">
                                        <p class="form-control-plaintext text-muted">{{ $movie->released_date }}</p>
                                    </div>
                                </div>

                                <div class="mb-2 row">
                                    <label class="col-md-3 col-form-label">Cast</label>
                                    <div class="col-md-9">
                                        <p class="form-control-plaintext text-muted">
                                            {{ $movie->actor1 }}{{ $movie->actor2 ? ', ' . $movie->actor2 : '' }}
                                        </p>
                                    </div>
                                </div>

                                <div class="mb-2 row">
                                    <label class="col-md-3 col-form-label">Poster</label>
                                    <div class="col-md-9">
                                        <img src="{{ $movie->poster_url }}" alt="Poster" class="img-fluid" style="max-height: 300px;">
                                    </div>
                                </div>

                                <div class="mb-2 row">
                                    <label class="col-md-3 col-form-label">Trailer</label>
                                    <div class="col-md-9">
                                        <a href="{{ $movie->trailer_url }}" target="_blank" class="btn btn-outline-primary">Watch Trailer</a>
                                    </div>
                                </div>

                                <hr>
                                <div class="mb-2 row">
                                    <div class="col-md-9 offset-md-3">
                                        <a href="{{ route('admin.movies.edit', $movie->id) }}" class="btn btn-info">Edit</a>
                                        <form action="{{ route('admin.movies.delete', $movie->id) }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to delete this movie?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Delete">
                                                Delete
                                            </button>
                                        </form>
                                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">Back</a>
                                    </div>
                                </div>

                            </div> <!-- col-md-12 -->
                        </div> <!-- row -->
                    </div> <!-- card-body -->
                </div> <!-- card -->
            </div>
        </div>
    </div>
</main>
@endsection
