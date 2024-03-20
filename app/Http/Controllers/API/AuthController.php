<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegister;
use App\Repositories\UserRepository;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function register(UserRegister $request){
        $payload = $request->all();
        $register = UserRepository::register($payload);

        if(!$register){
            return $this->apiResponseErrors("Register Failed!!", [
                "Failed to create user!!"
            ], 500);
        }

        return $this->apiResponseSuccess(message: "Register Success!!", data: $payload);
    }

    public function login()
    {
        $credentials = request(['email', 'password']);

        $token = auth()->attempt($credentials);
        if(!$token)
            return $this->apiResponseErrors("Email or Password is incorrect", $credentials, 401);
        
        $user = auth()->user();
        return $this->apiResponseSuccess("Successfully Login!!",
            [
                'token' => $token,
                'type' => 'bearer',
                'user' => $user
            ]
        );
    }

    public function refresh()
    {
        try{
            $token = auth()->refresh();
        }catch(TokenInvalidException $err){
            return $this->apiResponseErrors('Failed to Refresh Token', [
                "error" => $err->getMessage()
            ], 401);
        }

        return $this->apiResponseSuccess(
            'Refresh Token',
                [
                    'token' => $token,
                    'type' => 'bearer',
                    'user' => auth()->user()
                ]
            );
    }

    public function me()
    {
        return $this->apiResponseSuccess("User Detail", auth()->user());
    }

    public function logout()
    {
        auth()->logout();

        return $this->apiResponseSuccess('Successfully logged out!');
    }
}