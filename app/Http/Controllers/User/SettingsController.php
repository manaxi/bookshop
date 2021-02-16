<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;

class SettingsController extends Controller
{

    public function profile()
    {
        return view('dashboard.profile.index', array('user' => Auth::user()));
    }

    /**
     * function for updating user profile
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $this->validate($request, [
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->name = $request->input('name');
        $user->surname = $request->input('surname');
        $user->email = $request->input('email');
        $user->save();
        return redirect()->route('settings.show')->with('success', 'Profile was changed.');
    }

    /**
     * Update the user's password.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);

        $data = $request->all();
        if (!\Hash::check($data['old_password'], auth()->user()->password)) {
            return back()->with('error', 'Current password is wrong.');
        } else {
            auth()->user()->update([
                'password' => Hash::make($request->password)
            ]);
            return back()->with('success', 'Password was changed.');
        }

    }
}
