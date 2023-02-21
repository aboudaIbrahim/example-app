<?php

namespace App\Http\Controllers;

use App\Repositories\AuthRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    private AuthRepository $authRepository;

    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(Request $request)
    {
        $loginFields = $request;
        return $this->authRepository->login($loginFields);
    }

    public function register(Request $request)
    {
        $userFields = $request;
        return $this->authRepository->register($userFields);
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
