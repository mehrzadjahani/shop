<?php


namespace App\Http\Requests;


class AuthRequest
{


    public static function otpTokenRequest(): array
    {
        return ['phone_number' => 'required|exists:users,phone_number'];
    }

    public static function otpLogin()
    {
        return ['token' => 'required|string',
            'phone_number' => 'required|exists:users,phone_number'
        ];
    }

    public static function login()
    {
        return [
            'password' => 'required|string',
            'phone_number' => 'required|exists:users,phone_number'
        ];
    }
}
