<?php

namespace App\Http\Controllers;

use App\Repositories\AuthRepository;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request, AuthRepository $authRepository)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        $result = $authRepository->register($data);

        return response()->json($result, 200); //what we can do to improve this is that we can create an base controller where our return methods are defined lets say handleError and HandleResponse/Success so using that dependecy we can direct return that doing $this->handleError($message,code) same for login;
    }

    public function login(Request $request, AuthRepository $authRepository)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $result = $authRepository->login($data['email'], $data['password']);

        if (! $result) {
            return response()->json(['message' => 'Invalid email or password.'], 401);
        }//same here we use that handle error method here so that a standard response goes accross the whole project

        return response()->json($result);
    }
}
