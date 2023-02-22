<?php

namespace App\Repositories;

use App\Models\User;
use http\Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Traits\JsonResponseTrait;
use Illuminate\Support\Facades\Validator;

class AuthRepository
{
    use JsonResponseTrait;

    public function register($userFields)
    {
        try {
            $validator = Validator::Make($userFields->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6'
            ]);
            if ($validator->fails()) {
                return $this->failedRequest('something wrong with the entered data', 400, $validator->errors());
            }
            $user = User::create([
                'name' => $userFields->name,
                'email' => $userFields->email,
                'password' => Hash::make($userFields->password),
            ]);
            $token = Auth::login($user);

            $data = [$user, $token];

        } catch (Exception $e) {
            return $this->failedRequest($e->getMessage(), $e->getCode());
        }
        return $this->successRequest('User created Successfully', 200, $data);
    }

    public function login($loginFields)
    {
        try {
            $validator = Validator::make($loginFields->all(), [
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);
            if ($validator->fails()) {
                return $this->failedRequest('invalid inputs', 400, $validator->errors());
            }
            $credentials = $loginFields->only('email', 'password');
            $token = Auth::attempt($credentials);
            if (!$token) {
                return $this->failedRequest('Unauthorized', 401);
            }
            $user = Auth::user();
            $data = [$user, $token];
        } catch (Exception $e) {
            return $this->failedRequest($e->getMessage(), $e->getCode());
        }
        return $this->successRequest('logged in successfully', 200, $data);
    }

    public function logout()
    {
        try {
            Auth::logout();
        } catch (\Exception $e) {
            return $this->failedRequest($e->getMessage(), $e->getCode());
        }
        return $this->successRequest('logged out successfully', 200);
    }

    public function refresh()
    {
        try {
            $token = Auth::refresh();
            $user = Auth::user();
            $data = [$user, $token];
        } catch (\Exception $e) {
            return $this->failedRequest($e->getMessage(), $e->getCode());
        }
        return $this->successRequest('token refreshed ', 200, $data);
    }
}
