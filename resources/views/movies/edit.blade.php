@extends('layouts.app')

@section('content')
    <h1>Edit Movie</h1>

    <form action="{{ route('movies.update', $movie->id) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="text" name="movie_title" value="{{ $movie->movie_title }}" required>
        <textarea name="movie_description" required>{{ $movie->movie_description }}</textarea>
        <input type="date" name="released_date" value="{{ $movie->released_date }}" required>
        <button type="submit">Update Movie</button>
    </form>
@endsection
