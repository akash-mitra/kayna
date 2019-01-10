<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::all();

        return view('admin.tags.index', compact('tags'));
    }

    public function apiIndex()
    {
        return Tag::all()->paginate(10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tags.form')->with('tag', null);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tag = tap(new Tag(request(['name', 'description'])))->save();

        return [
            'status' => 'success',
            'flash' => ['message' => 'Tag [' . $tag->name . '] saved'],
            'tag_id' => $tag->id
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tag                  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tag                  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        return view('admin.tags.form')->with('tag', $tag);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tag                  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {
        $tag = tap($tag->fill(request(['name', 'description'])))->save();

        return [
            'status' => 'success',
            'flash' => ['message' => 'Tag [' . $tag->name . '] saved']
                //"page" => $page
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tag                  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
    }
}
