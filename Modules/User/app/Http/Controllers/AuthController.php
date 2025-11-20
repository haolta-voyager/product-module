<?php

namespace Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\User\DTOs\LoginData;
use Modules\User\DTOs\RegisterData;
use Modules\User\Http\Requests\LoginRequest;
use Modules\User\Http\Requests\RegisterRequest;
use Modules\User\Services\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class AuthController extends Controller
{
    public function __construct(
        private AuthService $authService
    ) {}

    public function showLogin(): View
    {
        return view('user::auth.login');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $loginData = LoginData::fromArray($request->validated());
        
        if (!$this->authService->login($loginData)) {
            return back()->withErrors([
                'Email or password is incorrect.',
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('products.index'))
            ->with('success', 'Welcome back!');
    }

    public function showRegister(): View
    {
        return view('user::auth.register');
    }

    public function register(RegisterRequest $request): RedirectResponse
    {
        $registerData = RegisterData::fromArray($request->validated());
        $user = $this->authService->register($registerData);

        $loginData = LoginData::fromArray([
            'email' => $registerData->email,
            'password' => $registerData->password,
        ]);
        
        $this->authService->login($loginData);

        return redirect()->route('products.index')
            ->with('success', 'Registration successful! Welcome!');
    }

    public function logout(Request $request): RedirectResponse
    {
        $this->authService->logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'You have been logged out.');
    }
}
