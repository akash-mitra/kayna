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

        if ($type) {
            $media->where('type', 'like', '%' . $type . '%');
        }
        if ($storage) {
            $media->where('storage', 'like', '%' . $storage . '%');
        }
        // if ($size) { $media->where('size', 'like', '%'.$size. '%'); }
        if ($name) {
            $media->where('name', 'like', '%' . $name . '%');
        }

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
    { }

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
        
        return Media::store ($uploadedFile, $name);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\media                $media
     * @return \Illuminate\Http\Response
     */
    public function show(media $media)
    { }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\media                $media
     * @return \Illuminate\Http\Response
     */
    public function edit(media $media)
    { }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\media                $media
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, media $media)
    { }

    /**
     * Remove the specified resource from storage.
     *
     */
    public function destroy(Media $media)
    {
        $photo = Media::destroy($media);

        return [
            "status" => "success",
            "flash" => ["message" => "Media File [" . $photo->name . "] deleted"],
            "photo_id" => $photo->id
            //"page" => $page
        ];
    }


    public function apiIndex(Request $request)
    {
        $media = Media::query();

        /**
         * This builds a "like" query based on the query string.
         * It breaks the query string in individual words and 
         * tries to match any of those words in image name.
         */
        $query = $request->input('query');
        if (! empty($query)) {
            $queryArray = explode(" ", $query);
            // a false where statement so that "or" condition below works
            $media->where('id', 0); 
            foreach($queryArray as $q) {
                if (! empty($q)) $media->orWhere('name', 'like', '%' . $q . '%');
            }
        }


        return $media->paginate(100);
    }
}
