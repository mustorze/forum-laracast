<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;

/**
 * Class RegisterConfirmationController
 * @package App\Http\Controllers\Auth
 */
class RegisterConfirmationController extends Controller
{
    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function index()
    {
        $user = User::where('confirmation_token', request('token'))
            ->first();

        if (!$user) {
            return redirect(route('threads'))
                ->with('flash', 'Unknown token.');
        }

        $user->confirm();

        return redirect(route('threads'))
            ->with('flash', 'Your account is now confirmed! You may post to the forum.');
    }
}
