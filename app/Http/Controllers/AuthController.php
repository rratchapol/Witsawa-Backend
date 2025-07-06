<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
// ...existing code...
public function register(Request $request) {
    $validator = Validator::make($request->all(), [
        'role' => 'required|array',
        'role.*' => 'in:Investor,Entrepreneur', // Validate each role in the array
        'title_name' => 'required|in:Mr.,Mrs.,Miss',
        'name' => 'required|string',
        'surname' => 'required|string', 
        'date_of_birth' => 'required|date',
        'phone_number' => 'nullable|string',
        'email' => 'required|email|unique:users',
        'password' => 'required|string|min:6|confirmed'
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    $user = User::create([
        'role' => $request->role, // Convert array to JSON for storage
        'title_name' => $request->title_name,
        'name' => $request->name,
        'surname' => $request->surname,
        'date_of_birth' => $request->date_of_birth,
        'phone_number' => $request->phone_number,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    $token = JWTAuth::fromUser($user);
    return response()->json(compact('user', 'token'));
}
// ...existing code...

public function login(Request $request) {
    $credentials = $request->only('email', 'password');
    if (!$token = JWTAuth::attempt($credentials)) {
        return response()->json(['error' => 'Invalid credentials'], 401);
    }
    
    // Get the authenticated user
    $user = auth()->user();
    
    return response()->json(compact('user', 'token'));
}

    public function me() {
        return response()->json(auth()->user());
    }

    public function logout() {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }
}
