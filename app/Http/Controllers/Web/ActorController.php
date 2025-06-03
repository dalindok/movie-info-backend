<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Actor;
use Illuminate\Http\Request;

class ActorController extends Controller
{
    public function create()
    {
        return view('actor.create_actor');
    }

    public function store(Request $request)
    {
        // Validate and store the actor data
        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'image_url' => 'nullable|string',
        ]);
        Actor::create($validate);

        // Logic to store the actor in the database

        return redirect()->route('movies.create')->with('success', 'Actor created successfully.');
    }
    // public function show_actor($id)
    // {
    //     // Logic to retrieve and show the actor details
    //     return view('admin.actors.show', compact('id'));
    // }
}
