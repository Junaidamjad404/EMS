<?php

namespace App\Http\Controllers\Attendee;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
     public function showResetForm(Request $request, $token = null): View
    {
        return view('Attendees.Auth.password.reset', ['token' => $token, 'email' => $request->email]);
    }

    /**
     * Reset the password for the user.
     */
    public function reset(Request $request): RedirectResponse
    {
                dd($request->all());

        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', 'min:8'],
            'token' => ['required'],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => bcrypt($request->password),
                ])->save();
            }
        );

        return $status == Password::PASSWORD_RESET
            ? redirect()->route('user.login')->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }
}
