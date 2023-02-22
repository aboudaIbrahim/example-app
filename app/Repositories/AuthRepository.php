<?php

namespace App\Repositories;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignUpRequest;
use App\Http\Requests\TodoRequest;
use App\Models\User;
use http\Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Traits\JsonResponseTrait;
use Illuminate\Support\Facades\Validator;

class AuthRepository
{
    use JsonResponseTrait;

    /**
     * @param $userFields
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(SignUpRequest $userFields)
    {
        try {
            $user = User::create([
                'name' => $userFields->input('name'),
                'email' => $userFields->input('email'),
                'password' => Hash::make($userFields->input('password')),
            ]);
            $token = Auth::login($user);
            $data = [$user, $token];
            return $this->successRequest('User created Successfully', 200, $data);
        } catch (\Exception $exception) {
            return $this->failedRequest($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @param $loginFields
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $loginFields)
    {
        try {
            $credentials = $loginFields->only('email', 'password');
            $token = Auth::attempt($credentials);
            if (!$token) {
                return $this->failedRequest('Unauthorized', 401);
            }
            $user = Auth::user();
            $data = [$user, $token];
        } catch (Exception $exception) {
            return $this->failedRequest($exception->getMessage(), $exception->getCode());
        }
        return $this->successRequest('logged in successfully', 200, $data);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        try {
            Auth::logout();
        } catch (\Exception $exception) {
            return $this->failedRequest($exception->getMessage(), $exception->getCode());
        }
        return $this->successRequest('logged out successfully', 200);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        try {
            $token = Auth::refresh();
            $user = Auth::user();
            $data = [$user, $token];
        } catch (\Exception $exception) {
            return $this->failedRequest($exception->getMessage(), $exception->getCode());
        }
        return $this->successRequest('token refreshed ', 200, $data);
    }
}
