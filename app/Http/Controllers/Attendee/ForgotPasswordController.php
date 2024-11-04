<?php

namespace App\Http\Controllers\Attendee;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\RedirectResponse;


class ForgotPasswordController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('Attendees.Auth.password.email'); // Default view for the password reset request
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // Check if the user exists
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => __('We could not find a user with that email address.')]);
        }

        // Send the password reset link
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status == Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withInput($request->only('email'))
                ->withErrors(['email' => __($status)]);
    }
}
