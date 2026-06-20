<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Auth.login
     *
     * Log a staff member in and hand back an API token.
     *
     * The client sends email + password. If they match a user, we create a
     * Sanctum token and return it. The client stores that token and sends it
     * on future requests as: Authorization: Bearer <token>
     */
    public function login(Request $request)
    {
        // 1. Make sure the request actually contains an email and password.
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        // 2. Look the user up by email.
        $user = User::where('email', $credentials['email'])->first();

        // 3. If there's no such user, OR the password doesn't match the stored
        //    (hashed) one, reject with a 401. We use the same message for both
        //    cases so we don't reveal which emails exist.
        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ])->status(401);
        }

        // 4. Credentials are good — issue a token. 'staff' is just a label for
        //    this token; you can revoke it later by name if you want.
        $token = $user->createToken('staff')->plainTextToken;

        return response()->json([
            'user'  => $user,
            'token' => $token,
        ]);
    }

    /**
     * Auth.logout
     *
     * Log out by deleting the token used for THIS request.
     *
     * Other tokens the user has (e.g. on another device) stay valid.
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out.']);
    }

    /**
     * Auth.me
     *
     * Return the currently authenticated user. Handy for testing that a token
     * works, and for the frontend to know who is logged in.
     */
    public function me(Request $request)
    {
        return $request->user();
    }
}
