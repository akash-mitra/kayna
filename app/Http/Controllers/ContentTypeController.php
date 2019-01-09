<?php

namespace App\Http\Controllers;

use App\Template;
use App\ContentTypeTemplate;
use \Illuminate\Http\Request;

class ContentTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        return view('admin.content-types.index')
                ->with('ctt', ContentTypeTemplate::all())
                ->with('templates', Template::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ContentTypeTemplate  $ctt
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ContentTypeTemplate $contentTypeTemplate)
    {
        $contentTypeTemplate->template_id = $request->input('template_id');
        
        $contentTypeTemplate->save();

        return $contentTypeTemplate;
    }
}
