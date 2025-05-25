<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    // List all users with pagination
    public function index(Request $request)
    {
        $users = User::withCount(['ratings', 'watchlists'])
            ->when(
                $request->search,
                fn($query, $search) =>
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
            )
            ->paginate(10);

        return response()->json([
            'message' => 'Users retrieved successfully',
            'data'    => $users->items(),
            'meta'    => [
                'page'        => $users->currentPage(),
                'totalItems'  => $users->total(),
                'totalPages'  => $users->lastPage(),
            ],
        ]);
    }

    // Create new user
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name'     => 'required|string|max:255',
                'email'    => 'required|email|unique:users,email',
                'password' => 'required|string|min:6',
                'role'     => 'required|in:user,admin',
            ]);

            $validated['password'] = Hash::make($validated['password']);

            $user = User::create($validated);

            return response()->json(['message' => 'User created successfully.', 'data' => $user], 201);
        } catch (ValidationException $e) {
            // Log::error('User creation error: ' . $e->getMessage());
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 500);
        }
    }

    // Show user by ID
    public function show($id)
    {
        try {
            $user = User::with(['ratings', 'watchlists'])->findOrFail($id);
            return response()->json(['message' => 'User retrieved.', 'data' => $user]);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'User not found.'], 404);
        }
    }

    // Update user
    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            $validated = $request->validate([
                'name'     => 'sometimes|string|max:255',
                'email'    => 'sometimes|email|unique:users,email,' . $id,
                'password' => 'nullable|string|min:6',
                'role'     => 'sometimes|in:user,admin',
            ]);

            if (isset($validated['password'])) {
                $validated['password'] = Hash::make($validated['password']);
            }

            $user->update($validated);

            return response()->json(['message' => 'User updated.', 'data' => $user]);
        } catch (\Throwable $e) {
            Log::error('User update error: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to update user.'], 500);
        }
    }

    // Delete user
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return response()->json(['message' => 'User deleted successfully.']);
        } catch (\Throwable $e) {
            Log::error('User deletion error: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to delete user.'], 500);
        }
    }
}
