<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Picture;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
    public function pictures()
    {
        $pictures = Picture::cursorPaginate(2);
        return response()->json([
            'data' => $pictures->items(),
            'next_cursor' => $pictures->nextCursor()?->encode()
        ]);
    }

    public function likePicture(Picture $picture)
    {
        /** @var User|null $user */
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $user->likedPictures()->syncWithoutDetaching([$picture->id]);
        return response()->json(['message' => 'Picture liked successfully']);
    }

    public function categories()
    {
        $categories = Category::all();
        return response()->json([
            'data' => $categories
        ]);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:6']
        ]);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ];

        $user = User::create($data);

        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'token' => $token,
            'user' => $user,
            'message' => 'Registered successfully'
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email',],
            'password' => ['required', 'min:6']
        ]);
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Incorrect credentials'
            ], 401);
        }
        $user = $request->user();
        $user->tokens()->delete();
        $token = $user->createToken('auth_token')->plainTokenText;
        return response()->json([
            'message' => 'Logged in successfully',
            'user' => $user,
            'token' => $token
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully']);
    }

    public function show(Picture $picture)
    {
        $picture->load('variants');
        return response()->json([
            'picture' => $picture
        ]);
    }
}
