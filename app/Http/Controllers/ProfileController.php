<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Show the user profile.
     *
     * @param User $user
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(User $user)
    {
        $datasets = $user->datasets()->published()->paginate(5);
        $codes = $user->codes()->published()->paginate(5, ['*'], 'codes_page');

        return view('profile.show', compact('user', 'datasets', 'codes'));
    }
}
