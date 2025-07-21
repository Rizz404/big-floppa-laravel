<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('pages.shared.auth.register');
    }

    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            UserProfile::create(['user_id' => $user->id]);
            Cart::create(['user_id' => $user->id]);

            DB::commit();

            $remember = isset($validated['remember_me']) && $validated['remember_me'];
            Auth::login($user, $remember);

            toast('Registration successful! Welcome.', 'success');
            return redirect()->route('landing');
        } catch (\Exception $e) {
            DB::rollBack();

            toast('Registration failed, please try again.', 'error');
            return back()->withInput();
        }
    }

    public function showLoginForm()
    {
        return view('pages.shared.auth.login');
    }

    public function login(LoginRequest $request)
    {
        $validated = $request->validated();
        $credentials = [
            'email' => $validated['email'],
            'password' => $validated['password']
        ];
        $remember = isset($validated['remember_me']) && $validated['remember_me'];

        if (Auth::attempt($credentials, $remember)) {
            request()->session()->regenerate();

            if (Auth::user()->role === 'admin') {
                return redirect()->intended('/admin');
            }

            toast('Welcome back!', 'success');
            return redirect()->intended();
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput(['email' => $validated['email']]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        toast('You have been successfully logged out.', 'success');
        return redirect()->route('login.form');
    }
}
