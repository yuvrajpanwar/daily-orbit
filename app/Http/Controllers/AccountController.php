<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    public function index()
    {
        return view('auth.my-account');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email,' . $user->id,
            'mobile_number' => 'nullable|string|max:20',
            'about'         => 'nullable|string',
            'address'       => 'nullable|string|max:500',
            'gender'        => 'nullable|in:male,female',
            'age'           => 'nullable|integer|min:1|max:120',
        ]);

        DB::transaction(function () use ($user, $validated) {
            // update user main table
            $user->update([
                'name'          => $validated['name'],
                'email'         => $validated['email'],
                'mobile_number' => $validated['mobile_number'] ?? null,
            ]);

            // update or create user details
            $user->detail()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'about'   => $validated['about'] ?? null,
                    'address' => $validated['address'] ?? null,
                    'gender'  => $validated['gender'] ?? null,
                    'age'     => $validated['age'] ?? null,
                ]
            );
        });

        return redirect()->route('account.index')->with('success', 'Account updated successfully!');
    }

    public function destroy(Request $request)
    {
        $user = Auth::user();  

        // set google_id null remember_token null 

        $user->update([
            'is_deleted' => 1,
            'deleted_at' => now(),
            'is_deactive' => 1,
            'deactivated_at' => now(),
            'email' => 'deleted-account-' . $user->id . '-' . $user->email,
            'google_id' => null,
            'remember_token' => null,
        ]);

        Auth::logout();

        return redirect('/')->with('success', 'Your account has been permanently deleted.');
    }
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
            'avatar' => 'required|image|mimes:jpg,jpeg,png,gif|max:1024',
        ]);

        $user = Auth::user();

        // save profile_picture
        $profilePath = $request->file('profile_picture')->store('uploads/users', 'public');
        // save avatar
        $avatarPath = $request->file('avatar')->store('uploads/users', 'public');

        $user->update([
            'profile_picture' => "storage/" . $profilePath,
            'avatar' => "storage/" . $avatarPath,
        ]);

        return response()->json(['success' => true]);
    }
}
