<?php

namespace Modules\Auth\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Auth\App\Http\Requests\LoginRequest;
use Modules\Auth\App\Services\AuthService;

class LoginController extends Controller
{
    public function __construct(protected AuthService $authService) {}

    /**
     * Show the login form.
     */
    public function showLoginForm(): View|RedirectResponse
    {
        if (auth()->check()) {
            return redirect()->intended(config('auth-module.redirects.login', '/dashboard'));
        }

        return view('auth-module::login');
    }

    /**
     * Handle login form submission.
     *
     * If a Super Admin logs in via this route, authenticate them
     * and redirect to the admin dashboard automatically.
     */
    public function login(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');

        $userRepo = app(\Modules\Auth\App\Repositories\UserRepository::class);
        $user     = $userRepo->findByEmail($credentials['email']);

        // Super Admin → authenticate and redirect to admin dashboard
        if ($user && $user->isAdmin()) {
            $authenticatedUser = $this->authService->login($credentials, $request->boolean('remember'));
            $request->session()->regenerate();

            return redirect()->route('admin.dashboard')
                ->with('success', "Welcome back, {$authenticatedUser->first_name}! Redirected to Admin Dashboard.");
        }

        // Regular user login
        $authenticatedUser = $this->authService->login($credentials, $request->boolean('remember'));
        $request->session()->regenerate();

        return redirect()->intended(config('auth-module.redirects.login', '/dashboard'))
            ->with('success', "Welcome back, {$authenticatedUser->first_name}!");
    }
}
