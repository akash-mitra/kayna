<?php

namespace App\Http\Controllers;

use App\Media;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $type = $request->input('type');
        $storage = $request->input('storage');
        // $size = $request->input('size');
        $name = $request->input('name');

        $media = Media::query();

        if ($type) { $media->where('type', 'like', '%'.$type. '%'); }
        if ($storage) { $media->where('storage', 'like', '%'.$storage. '%'); }
        // if ($size) { $media->where('size', 'like', '%'.$size. '%'); }
        if ($name) { $media->where('name', 'like', '%'.$name. '%'); }

        $photos = $media->paginate();
        $query = [
            'type' => $type,
            'storage' => $storage,
            'name' => $name
        ];
        return view('admin.media.index')->with('photos', $photos)->with('query', $query);
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
        $input = $request->input();
        $uploadedFile = request()->file('media');
        $name = $input['name'];

        try {
            $url = Media::store($uploadedFile, $name);

            return response()->json(['url' => asset($url)], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\media                $media
     * @return \Illuminate\Http\Response
     */
    public function show(media $media)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\media                $media
     * @return \Illuminate\Http\Response
     */
    public function edit(media $media)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\media                $media
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, media $media)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     */
    public function destroy(Request $request)
    {
        $url = $request->input('url');

        $urlArray = explode('/', $url);

        // Get the filename from the url.
        // This filename is not the original client supplied file name
        // this is a unique filename that was generated when client
        // first uploaded the file to the server
        $filename = end($urlArray);

        return Media::destroy($filename);
    }
}
