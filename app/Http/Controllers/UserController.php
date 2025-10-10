<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return view('pages.my-account');
    }

    public function updateAccount(Request $request)
    {
        try {
            $request->validate([
                'username' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . Auth::id(),
                'phone' => 'nullable|string|max:20'
            ]);

            $user = Auth::user();

            $user->update([
                'username' => $request->username,
                'email' => $request->email,
                'phone' => $request->phone
            ]);

            return back()->with('success', 'Update account successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'currentPassword' => 'required',
            'newPassword' => 'required|min:8',
            'confirmPassword' => 'required|same:newPassword',
        ], [
            'required' => 'Please enter :attribute.',
            'min' => ':attribute requires at least :min characters.',
            'same' => ':attribute does not match.',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->currentPassword, $user->password)) {
            return back()->withErrors(['currentPassword' => 'Current password is incorrect.']);
        }

        $user->password = Hash::make($request->newPassword);
        $user->save();

        return back()->with('success', 'Change password successfully!');
    }
}
