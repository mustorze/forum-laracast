<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Http\Controllers\Controller;

/**
 * Class UsersController
 * @package App\Http\Controllers\Api
 */
class UsersController extends Controller
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function index()
    {
        $search = request('name');
        return User::where('name', 'LIKE', "$search%")
            ->take(5)
            ->pluck('name');
    }
}
