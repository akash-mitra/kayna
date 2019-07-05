<?php

namespace App\Http\Controllers;

use App\Media;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    
    /**
     * Display a page containing the listing of all the media.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.media.index'); 
    }




    /**
     * Store a newly uploaded media in storage.
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




    /**
     * Returns a JSON listing of all the media.
     */
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
