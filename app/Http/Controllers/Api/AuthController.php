<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'id_number' => 'required|numeric',
            'password' => 'required',
        ]);
        $user = User::with('role')->where('id_number', $request->id_number)->first();
        if(!$user|| !Hash::check($request->password, $user->password)){

            throw ValidationException::withMessages([
                'id_number' => 'The credentials you entered do not match'
            ]);
        }

        return response()->json([
            'token' => $user->createToken('laravel_api_token')->plainTextToken,
            'user' => $user
        ],200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
    }

}
