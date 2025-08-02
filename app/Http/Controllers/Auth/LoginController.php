<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showCustomerLogin()
    {
        if (auth()->check() && auth()->user()->role === 'user') {
            return redirect()->route('user.dashboard');
        }
        $user = (object)[];
        if(config('app.env') === 'local'){
            $user->email = 'user@gmail.com';
            $user->password = '123456';
        }
        return view('auth.customer-login', compact('user'));
    }

    public function userLogout()
    {
        Auth::logout();
        return redirect()->route('user.login')->with('success', 'You have been logged out.');
    }

    public function customerLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            if (Auth::user()->role === 'user') {
                return redirect()->intended('/user/dashboard');
            }

            Auth::logout();
            return back()->withErrors(['email' => 'Not a customer']);
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }
    public function loginForm()
    {
        $user = (object)[];
        if(config('app.env') === 'local'){
            $user->email = 'test@gmail.com';
            $user->password = '123456';
        }
        return view('auth.login', compact('user'));
    }

    /**
     * Handle an authentication attempt.
     */
    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('admin/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'You have been logged out.');
    }
}
