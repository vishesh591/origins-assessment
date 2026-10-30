<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthRepository
{
    public function register($data)
    {
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);

        return [
            'user' => $user,
            'token' => $this->createToken($user),
        ];
    }

    public function login($email, $password)
    {
        $user = User::where('email', $email)->first();

        if (! $user || ! Hash::check($password, $user->password)) {
            return null;
        }

        return [
            'user' => $user,
            'token' => $this->createToken($user),
        ];
    }

    public function userFromToken($token)
    {
        if (! $token) {
            return null;
        }

        return User::where('api_token', hash('sha256', $token))->first();
    }

    private function createToken($user)
    {
        $token = Str::random(64);

        $user->api_token = hash('sha256', $token);
        $user->save();

        return $token;
    }
}
