<?php

namespace App\Http\Controllers;

use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = Validator::make($request->all(), [
            'name' => 'required|string|max:225',
            'username' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', 'string', Password::min(8)->mixedCase()->numbers()->symbols()],
            'phone' => 'required|numeric',
            'role' => 'in:admin,patient'
        ]);
        if ($data->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid field',
                'errors' => $data->errors()
            ], 422);
        }
        $user = User::create($data->validated());
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'User registered successfully',
            'data' => array_merge($user->toArray(), ['token' => $token])
        ], 201);
    }
    public function login(Request $request)
    {
        $data = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string',
        ]);
        if ($data->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid field',
                'errors' => $data->errors()
            ], 422);
        }
        $user = User::where('email', $request->email)->first();
        // if (!$user || !hash_equals($user->password, hash('sha256', $request->password)))

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email or password incorrect'
            ], 401);
        }
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Login successfully',
            'data' => array_merge($user->toArray(), ['token' => $token])
        ], 200);
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Logout successfully'
        ], 200);
    }
    public function profile(Request $request)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Get profile successfully',
            'data' => $request->user()
        ], 200);
    }
}
