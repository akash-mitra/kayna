<?php

namespace App\Http\Controllers;

use App\User;

class ProfileController extends Controller
{
    public function show($slug)
    {
        $user = User::findOrFailBySlug($slug);
        
        $user->load('publications');
        
        return compiledView('profile', $user->toArray());
    }
}
