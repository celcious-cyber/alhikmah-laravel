<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Services\TokenService;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Handle Admin Login
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $admin = Admin::where('username', $request->username)->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return response()->json(['message' => 'Username atau password salah.'], 401);
        }

        // Generate cryptographic token
        $token = TokenService::generate($admin->id);

        return response()->json([
            'token' => $token,
            'admin' => [
                'id' => $admin->id,
                'username' => $admin->username,
                'name' => $admin->name
            ]
        ]);
    }

    /**
     * Retrieve authenticated administrator info
     */
    public function me(Request $request)
    {
        $admin = $request->get('admin');

        return response()->json([
            'admin' => [
                'id' => $admin->id,
                'username' => $admin->username,
                'name' => $admin->name
            ]
        ]);
    }
}
