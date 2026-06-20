<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * Manage staff/superadmin accounts.
 *
 * Every route that points here is protected by 'auth:sanctum' + 'superadmin'
 * (see routes/api.php), so by the time these methods run we already know the
 * caller is a logged-in superadmin.
 */
class UserController extends Controller
{
    /**
     * User.index
     *
     * List all users. Useful for an admin screen.
     */
    public function index()
    {
        return User::all();
    }

    /**
     * User.store
     *
     * Create a new user and assign their role.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            // unique:users,email stops two accounts sharing an email.
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            // Only these two roles are allowed — anything else is rejected.
            'role'     => ['required', Rule::in(['staff', 'superadmin'])],
        ]);

        // The User model casts 'password' => 'hashed', so the plain password
        // we pass here is automatically bcrypt-hashed before it's saved.
        $user = User::create($validated);

        return response()->json($user, 201);
    }
}
