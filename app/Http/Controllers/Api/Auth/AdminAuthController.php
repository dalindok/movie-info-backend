<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AdminAuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $validated = $request->validate([
                'email' => 'required|email',
                'password' => 'required|string',
            ]);

            $admin = User::where('email', $validated['email'])->where('role', 'admin')->first();

            if (!$admin) {
                return response()->json(['message' => 'This admin has not create yet!.'], 401);
            }

            if (!Hash::check($validated['password'], $admin->password)) {
                return response()->json(['message' => 'Icorrect password.'], 401);
            }

            $token = $admin->createToken('admin-token')->plainTextToken;

            return response()->json([
                'message' => 'Admin logged in successfully.',
                'token' => $token,
                'data' => $admin,
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 500);
        }
    }

    public function profile(Request $request)
    {
        try {
            $admin = $request->user();

            if ($admin->role !== 'admin') {
                return response()->json(['message' => 'Unauthorized'], 403);
            }

            return response()->json([
                'message' => 'Admin profile retrieved successfully.',
                'data' => $admin,
            ]);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'Failed to retrieve admin profile.'], 500);
        }
    }
}
