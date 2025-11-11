<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Mail\WelcomMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email|max:255',
            'password' => 'required|min:8|string|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        Mail::to($user->email)->send(new WelcomMail($user));
        return response()->json([
            'message' => 'User Registered Successfully',
            'User' => $user,
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(
                [
                    'message' => 'Invalid'
                ],
                401
            );
        }

        $user = User::where('email', $request->email)->firstOrFail();
        $token = $user->createToken('auth_Token')->plainTextToken;
        return response()->json(
            [
                'message' => 'Login Successful',
                'User' => $user,
                'Token' => $token
            ],
            201
        );
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logout Successful']);
    }

    public function AllRole()
    {
        $TheRole = Post::all();
        return response()->json($TheRole, 200);
    }

    public function userInfo()
    {
        // $userId = Auth::user()->id;
        $userInfo = User::with('profile')->findOrFail(Auth::user()->id);
        return new UserResource($userInfo);
    }
}
