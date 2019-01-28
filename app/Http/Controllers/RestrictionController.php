<?php

namespace App\Http\Controllers;

use App\Restriction;
use Illuminate\Http\Request;

class RestrictionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accesses = Restriction::list();

        return view('admin.accesses.index', compact('accesses'));
    }

    

    /**
     * Updates or creates a new resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createOrUpdate(Request $request)
    {

        $restriction = new Restriction($request->input());

        $existing = Restriction::exists($restriction);

        $message = '';

        if (empty($existing)) {

            $restriction->save();
            $message = 'Content restricted for user type ' . $restriction->user_type . ' only.';

        } else {

            if ($request->input('user_type') === 'None') 
            {
                $this->destroy($existing);

                $message = 'Content restriction removed.';
            }
            else 
            {
                $existing->user_type = $request->input('user_type');
                $existing->save();

                $message = 'Content restriction updated for user type ' . $restriction->user_type . ' only.';
            }

        }
        
        return [
            'status' => 'success',
            'flash' => ['message' => $message],
            'content_id' => $restriction->content_id
        ];

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Restriction  $restriction
     * @return \Illuminate\Http\Response
     */
    // public function show(Restriction $restriction)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Restriction  $restriction
     * @return \Illuminate\Http\Response
     */
    // public function edit(Restriction $restriction)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Restriction  $restriction
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, Restriction $restriction)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Restriction  $restriction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Restriction $restriction)
    {
        return $restriction->delete();
    }
}
