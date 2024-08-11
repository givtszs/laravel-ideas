<?php

namespace App\Http\Controllers;

use App\Enums\RolesEnum;
use App\Http\Requests\AuthenticateUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Mail\WelcomeMail;
use App\Models\User;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function register()
    {
        return view('auth.registration');
    }

    public function store(RegisterUserRequest $request)
    {
        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password'])
        ]);
        $user->assignRole(RolesEnum::User);

        Mail::to($user)->queue(new WelcomeMail($user));

        return redirect()->route('dashboard')->with('success', 'Registered successfully');
    }

    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(AuthenticateUserRequest $request)
    {
        $validated = $request->validated();

        if (Auth::attempt($validated)) {
            $request->session()->regenerate();

            return redirect()->route('dashboard')->with('success', 'Authenticated successfully');
        }

        return back()
            ->withErrors([
                'email' => __('auth.failed')
            ])
            ->withInput($request->only('email'));
    }

    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('dashboard')->with('success', 'Logged out successfully');
    }
}
