@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-xl bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-4">Add New Actor</h2>

    <form action="{{ route('actor.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Full Name </label>
            <input type="text" name="name" class="mt-1 block w-full border rounded p-2" value="{{ old('name') }}" required>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Photo</label>
            <input type="file" name="photo" class="mt-1 block w-full border rounded p-2">
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Save Actor
            </button>
        </div>
    </form>
</div>
@endsection
