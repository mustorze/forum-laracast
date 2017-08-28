<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Http\Controllers\Controller;

/**
 * Class RegisterConfirmationController
 * @package App\Http\Controllers\Api
 */
class RegisterConfirmationController extends Controller
{
    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function index()
    {
        try {
            User::where('confirmation_token', request('token'))
                ->firstOrFail()
                ->confirm();
        } catch (\Exception $e) {
            return redirect(route('threads'))
                ->with('flash', 'Unknown token.');
        }

        return redirect(route('threads'))
            ->with('flash', 'Your account is now confirmed! You may post to the forum.');
    }
}
