<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session as FacadesSession;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Role;



class AuthManager extends Controller
{
    function login()
    {
        return view('login');
    }

    function registration()
    {
        return view('registration');
    }
    function loginPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } else if ($user->role === 'service_provider') {
                return redirect()->route('provider.dashboard');
            } else if ($user->role === 'user') {
                return redirect()->intended();
            } else {
                return redirect()->route('user.home');
            }
        }
        return redirect(route('login'))->with('error', 'Invalid login details');
    }

    function registrationPost(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:4',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        // Assign default role (user)

        Auth::login($user);

        return redirect()->route('user.completeProfile')->with('success', 'Registration successful! Please complete your profile.');
    }




    function logout()
    {
        Auth::logout();
        FacadesSession::flush();
        return redirect(route('login'));
    }

}
