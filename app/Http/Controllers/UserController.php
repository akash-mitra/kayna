<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return view('admin.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int                       $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int                       $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $profile = $user->load('publications', 'comments', 'providers');

        return view('admin.user.form', compact('profile'));
    }

    public function update(Request $request, User $user)
    {
        // only bio and type fields are updatable
        $hasUpdates = false;

        if ($request->has('bio')) {
            $user->bio = $request->bio;
            $hasUpdates = true;
        }

        if ($request->has('type')) {
            $user->type = $request->type;
            $hasUpdates = true;
        }

        if ($hasUpdates === true) {
            $user->save();
            return [
                'status' => 'success',
                'message' => 'User information updated successfully'
            ];
        }

        return Response::json([
            'status' => 'failed',
            'message' => 'No information to update'
        ], 400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int                       $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
}
