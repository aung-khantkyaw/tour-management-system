<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;

class LoginController extends Controller
{
    #[Validate]
    public function login($email, $password, $remember = false)
    {
        $this->ensureIsNotRateLimited($email);

        if (!Auth::attempt(['email' => $email, 'password' => $password], $remember)) {
            RateLimiter::hit($this->throttleKey($email));

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey($email));

        Session::regenerate();

        $user = Auth::user();
        $isAdmin = $user->role === 'admin';

        $targetRoute = $isAdmin ? route('dashboard', absolute: false) : route('welcome');

        return redirect()->to($targetRoute);
    }

    protected function ensureIsNotRateLimited($email)
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey($email), 5)) {
            return;
        }

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => RateLimiter::availableIn($this->throttleKey($email)),
                'minutes' => ceil(RateLimiter::availableIn($this->throttleKey($email)) / 60),
            ]),
        ]);
    }

    public function throttleKey($email)
    {
        return strtolower($email) . '|' . request()->ip();
    }
}