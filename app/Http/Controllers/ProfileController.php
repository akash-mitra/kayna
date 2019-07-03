<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

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

        return view('profile', [
            "resource" => $user,
            "common" => (object)[
                "sitename" => param('sitename'),
                "sitetitle" => param('tagline'),
                "metadesc" => param('sitedesc'),
                "metakey" => param('sitekeys')
            ]
        ]);
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
        if (!$user->isRequestingHerSelf()) {
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



    /**
     * Impersonated the current auth user as the user of supplied user_id
     */
    public function impersonate(Request $request)
    {
        $request->validate([
            'user_id' => 'required'
        ]);

        Auth::loginUsingId($request->input('user_id'));

        if ($request->ajax())
        {
            return [
                'status' => 'success'
            ];

        } else {
            return back();
        }
    }
}
