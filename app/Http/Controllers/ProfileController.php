<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function showProfile()
    {
        $user = Auth::user()->load('userProfile');
        // Nanti kita akan membuat view ini
        return view('pages.user.profile.show', compact('user'));
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();

            User::update([
                'name' => $validated['name'],
                'email' => $validated['email'],
            ]);

            User::profile()->updateOrCreate(
                ['user_id' => $validated['id']],
                [
                    'fullname' => $validated['fullname'],
                    'age' => $validated['age'],
                    'phone_number' => $validated['phone_number'],
                ]
            );

            DB::commit();

            return back()->with('success', 'Profile updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            // Sebaiknya log error ini
            // Log::error('Profile update failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to update profile. Please try again.');
        }
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $validated = $request->validated();

        User::update([
            'password' => Hash::make($validated['new_password']),
        ]);
        return back()->with('success', 'Password changed successfully!');
    }
}
