<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth')->except('show');
    }

    public function show($slug)
    {
        $user = User::findOrFailBySlug($slug);

        $user->load('publications');

        return compiledView('profile', $user->toArray());
    }

    public function edit(User $user)
    {
        $profile = $user->load('publications', 'comments', 'providers');

        return view('admin.user.form', compact('profile'));
    }

    /**
     * Change the password of the user. An authenticated
     * request must contain the parameter "password".
     *
     * @param  Request $request
     * @param  User    $user
     * @return void
     */
    public function changePassword(Request $request, User $user)
    {
        if (! $user->isRequestingHerSelf()) {
            abort(403, 'Permission Denied');
        }

        //TODO enforce certain password standards here
        $password = $request->input('password');

        $user->password = Hash::make($password);

        $user->save();

        return [
            'status' => 'success',
            'message' => 'Password changed successfully'
        ];
    }
}
