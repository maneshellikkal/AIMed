<?php

namespace App\Http\Controllers;

use Validator;
use App\Aimed;
use Carbon\Carbon;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct ()
    {
        $this->middleware('auth');
    }

    /**
     * @param User $user
     *
     * @return mixed
     */
    public function edit (User $user)
    {
        $data = [
            'activeTab' => request('tab', Aimed::firstSettingsTabKey()),
            'invoices'  => [],
            'user'      => auth()->user()->isAdmin() ? $user : auth()->user(),
        ];

        return view('users.edit', $data);
    }

    public function update (User $user)
    {
        $this->validate(request(), [
            'name'              => 'required|max:255',
            'username'          => 'sometimes|alpha_num|min:4|max:30|unique:users',
            'email'             => 'sometimes|email|max:255|unique:users',
            'dob'               => 'nullable|date|before:' . Carbon::parse('- 16 years')->toDateTimeString(),
            'occupation'        => 'nullable|string|max:255',
            'organization'      => 'nullable|string|max:255',
            'github_username'   => 'nullable|string|max:255',
            'linkedin_username' => 'nullable|string|max:255',
            'website'           => 'nullable|active_url|max:255',
        ]);

        $user = auth()->user()->isAdmin() ? $user : auth()->user();
        $data = request()->intersect([
            'name',
            'dob',
            'occupation',
            'organization',
            'github_username',
            'linkedin_username',
            'website'
        ]);

        if (auth()->user()->isAdmin()) {
            $data += request()->intersect(['email', 'username']);
        }

        $user->update($data);


        alert()->success('Profile Updated');

        return redirect($user->path() . '/edit?tab=profile');
    }

    public function password (User $user)
    {
        $validator = Validator::make(request()->all(), [
            'password' => 'required|min:6|confirmed',
        ]);

        if($validator->fails()) {
            return redirect($user->path() . '/edit?tab=security')->withErrors($validator);
        }

        $user = auth()->user()->isAdmin() ? $user : auth()->user();

        $user->update(['password' => bcrypt(request('password'))]);

        alert()->success('Password Changed');

        return redirect($user->path() . '/edit?tab=security');
    }
}
