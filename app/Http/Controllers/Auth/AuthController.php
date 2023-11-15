<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        if (!auth()->attempt($request->only(['id_number', 'password']))) {
            throw ValidationException::withMessages([
                'id_number' => ['The credentials you entered are incorrect.']
            ]);
        }

    }

    public function logout(Request $request)
    {
        auth()->guard('web')->logout();
    }

}
