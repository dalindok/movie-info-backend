@extends('layouts.app')

@section('content')
<main>
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

                            <!-- Genre Dropdown -->
                            <div class="mb-3">
                                <label for="genre_id" class="form-label">Genre</label>
                                <select name="genre_id[]" id="genre_id" class="form-select" required>
                                    <option value="">Select Genre</option>
                                    @foreach ($genres as $genre)
                                        <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Actor Dropdowns -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="actor_1" class="form-label">Actor 1</label>
                                    <select name="actor_id[]" id="actor_1" class="form-select" required>
                                        <option value="">Select Actor</option>
                                        @foreach ($actors as $actor)
                                            <option value="{{ $actor->id }}">{{ $actor->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="actor_2" class="form-label">Actor 2</label>
                                    <select name="actor_id[]" id="actor_2" class="form-select" required>
                                        <option value="">Select Actor</option>
                                        @foreach ($actors as $actor)
                                            <option value="{{ $actor->id }}">{{ $actor->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <a href="{{ route('actor.create') }}" class="btn btn-primary">Add New Actor</a>
                            </div>

                            <div class="mb-3">
                                <label for="poster" class="form-label">Poster Image URL</label>
                                <input type="string" name="poster" id="poster" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="trailer" class="form-label">Trailer Link (YouTube)</label>
                                <input type="url" name="trailer" id="trailer" class="form-control">
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
