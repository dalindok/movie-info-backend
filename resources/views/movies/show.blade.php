@extends('layouts.app')

@section('content')
<main class="py-5">
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <strong>Movie Details</strong>
                    </div>

                    <div class="card-body">
                        <!-- Title -->
                        <div class="mb-3 row">
                            <label class="col-md-3 col-form-label">Title</label>
                            <div class="col-md-9">
                                <p class="form-control-plaintext text-muted">{{ $movie->title }}</p>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mb-3 row">
                            <label class="col-md-3 col-form-label">Description</label>
                            <div class="col-md-9">
                                <p class="form-control-plaintext text-muted">{{ $movie->description }}</p>
                            </div>
                        </div>

                        <!-- Genre -->
                        <div class="mb-3 row">
                            <label class="col-md-3 col-form-label">Genre</label>
                            <div class="col-md-9">
                                <p class="form-control-plaintext text-muted">
                                    {{ $movie->genres->pluck('name')->join(', ') ?: 'N/A' }}
                                </p>
                            </div>
                        </div>

                        <!-- Rating -->
                        <div class="mb-3 row">
                            <label class="col-md-3 col-form-label">Rating</label>
                            <div class="col-md-9">
                                <p class="form-control-plaintext text-muted">
                                    {{ $movie->rating->name ?? 'N/A' }}
                                </p>
                            </div>
                        </div>

                        <!-- Release Date -->
                        <div class="mb-3 row">
                            <label class="col-md-3 col-form-label">Release Date</label>
                            <div class="col-md-9">
                                <p class="form-control-plaintext text-muted">
                                    {{ \Carbon\Carbon::parse($movie->released_date)->format('F d, Y') }}
                                </p>
                            </div>
                        </div>

                        <!-- Actors -->
                        <div class="mb-3 row">
                            <label class="col-md-3 col-form-label">Actors</label>
                            <div class="col-md-9">
                                <p class="form-control-plaintext text-muted">
                                    {{ $movie->actors->pluck('name')->join(', ') ?: 'N/A' }}
                                </p>
                            </div>
                        </div>

                        
                        <!-- Poster -->
                        <div class="mb-3 row">
                                           <label class="col-md-3 col-form-label">Poster</label>
                            <div class="col-md-9">
                                <img src="{{ $movie->poster}}" alt="Poster" class="img-fluid rounded shadow-sm" style="max-height: 300px;">
                            </div>
                        </div>
                                 <!-- Trailer -->
                                 <div class="mb-3 row">
                            <label class="col-md-3 col-form-label">Trailer</label>
                            <div class="col-md-9">
                                <a href="{{ $movie->trailer}}" target="_blank" class="btn btn-outline-primary">Watch Trailer</a>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <hr>
                        <div class="text-end mt-4">
                            <a href="{{ route('movies.edit', $movie->id) }}" class="btn btn-info">Edit</a>
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
