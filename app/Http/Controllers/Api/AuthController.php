<?php

namespace App\Http\Controllers\Api;


use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignUpRequest;
use App\Http\Requests\TodoRequest;
use App\Repositories\AuthRepository;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private AuthRepository $authRepository;

    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    public function login(LoginRequest $request)
    {
        return $this->authRepository->login($request);
    }
    public function register(SignUpRequest $request)
    {
        return $this->authRepository->register($request);
    }
    public function logout()
    {
        return $this->authRepository->logout();
    }
    public function refresh()
    {
        return $this->authRepository->refresh();
    }
}
