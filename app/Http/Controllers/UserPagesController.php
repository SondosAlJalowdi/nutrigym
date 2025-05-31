<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserPagesController extends Controller
{
    public function showLandingPage(){
        return view('user.landing');
    }

    public function showProfile()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    public function showCompleteProfileForm()
    {
        $user = Auth::user();
        return view('user.completeProfile', compact('user'));
    }

    public function completeProfile(Request $request)

    {

        $request->validate([
            'phone' => ['nullable', 'regex:/^07[7-9][0-9]{7}$/'],
            'age' => 'nullable|integer|min:0',
            'gender' => 'nullable|in:male,female',
            'height' => 'nullable|numeric',
            'weight' => 'nullable|numeric',
            'location' => 'nullable|string',
        ]);

           /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->update($request->only('phone', 'age', 'gender', 'height', 'weight', 'location'));

        return redirect()->route('user.profile')->with('success', 'Profile updated successfully!');
    }
}
