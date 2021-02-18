<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserUpdatePasswordRequest;
use App\Http\Requests\UserUpdateProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;

class SettingsController extends Controller
{

    public function profile()
    {
        return view('dashboard.profile.profile');
    }

    /**
     * function for updating user profile
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateProfile(UserUpdateProfileRequest $request)
    {
        auth()->user()->update($request->validated());
        return redirect()->route('settings.profile')->with('success', 'Profile was changed.');
    }

    /**
     * Update the user's password.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(UserUpdatePasswordRequest $request)
    {
        if (!\Hash::check($request->input('old_password'), auth()->user()->password)) {
            return redirect()->route('settings.profile')->with('error', 'Current password is wrong.');
        } else {
            auth()->user()->update([
                'password' => Hash::make($request->password)
            ]);
            return redirect()->route('settings.profile')->with('success', 'Password was changed.');
        }

    }
}
