<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Mail\VerificationCodeMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use PhpParser\Node\Stmt\TryCatch;

use function Pest\Laravel\call;

class UserAuthController extends Controller
{
    // Sign-up
    public function signup(Request $request)
    {
        try {
            $validated = $request->validate(
                [
                    'name'     => 'required|string|max:255',
                    'email'    => 'required|email|unique:users,email',
                    'password' => 'required|string|min:6|confirmed',
                ],
                [
                    'name.required'     => 'The name field is required.',

                    'email.required'    => 'The email field is required.',
                    'email.email'       => 'The email field must be a valid email address, e.g. "email@example.com".',
                    'email.unique'      => 'This email is already used by another user.',

                    'password.required' => 'The password field is required.',
                    'password.string'   => 'The password must be a valid string.',
                    'password.min'      => 'The password must be at least 6 characters.',
                    'password.confirmed' => 'The password confirmation does not match.',
                ]
            );
            // $code = random_int(1000, 9999);

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'user',
                // 'email_verification_code' => "$code",
            ]);

            // Send email (use queue in real app)
            // Mail::to($user->email)->send(new VerificationCodeMail($code));
            $token = $user->createToken('user-token')->plainTextToken;

            return response()->json([
                'message' => 'User Register successfully.',
                'token' => $token,
                'data' => $user,
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 500);
        }
    }

    // Verify
    public function verify(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|exists:users,email',
            'code' => 'required|digits:4',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if ($user->email_verification_code !== $validated['code']) {
            return response()->json(['message' => 'Invalid verification code.'], 422);
        }

        $user->email_verified_at = now();
        $user->email_verification_code = null;
        $user->save();

        return response()->json(['message' => 'Email verified successfully.']);
    }

    // Sign-in
    public function login(Request $request)
    {
        try {
            $validated = $request->validate([
                'email' => 'required|email',
                'password' => 'required|string',
            ]);

            $user = User::where('email', $validated['email'])->where('role', 'user')->first();

            if (!$user) {
                return response()->json(['message' => 'This email has not benn register yet!.'], 401);
            }
            if (!Hash::check($validated['password'], $user->password)) {
                return response()->json(['message' => 'Icorrect password.'], 401);
            }

            // if (!$user->email_verified_at) {
            //     return response()->json(['message' => 'Please verify your email.'], 403);
            // }

            $token = $user->createToken('user-token')->plainTextToken;

            return response()->json([
                'message' => 'User logged in successfully.',
                'token' => $token,
                'data' => $user,
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
            $user = $request->user();

            if ($user->role !== 'user') {
                return response()->json(['message' => 'Unauthorized'], 403);
            }

            return response()->json([
                'message' => 'User profile retrieved successfully.',
                'data' => $user,
            ]);
        } catch (\Throwable $e) {
            // Log::error('User profile error: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to retrieve user profile.'], 500);
        }
    }
}
