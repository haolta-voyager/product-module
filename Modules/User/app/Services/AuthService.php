<?php

namespace Modules\User\Services;

use Modules\User\Models\User;
use Modules\User\DTOs\RegisterData;
use Modules\User\DTOs\LoginData;
use Modules\User\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function __construct(
        private UserRepository $userRepository
    ) {}

    public function register(RegisterData $data): User
    {
        $userData = $data->toArray();
        $userData['password'] = Hash::make($data->password);
        
        return $this->userRepository->create($userData);
    }

    public function login(LoginData $data): bool
    {
        return Auth::attempt(
            $data->toArray(),
            $data->remember
        );
    }

    public function logout(): void
    {
        Auth::logout();
    }

    public function user(): ?User
    {
        /** @var User|null $user */
        $user = Auth::user();
        return $user;
    }
}
