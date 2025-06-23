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
            'name' => 'required|string|min:3',
            'phone' => ['nullable', 'regex:/^07[7-9][0-9]{7}$/'],
            'age' => 'nullable|integer|min:0',
            'gender' => 'nullable|in:male,female',
            'height' => 'nullable|numeric',
            'weight' => 'nullable|numeric',
            'location' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = Auth::user();

        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->age = $request->age;
        $user->gender = $request->gender;
        $user->height = $request->height;
        $user->weight = $request->weight;
        $user->location = $request->location;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('profiles', 'public');
            $user->image = $imagePath;
        }

        $user->save();

        return redirect()->route('user.profile')->with('success', 'Profile updated successfully!');
    }

}
