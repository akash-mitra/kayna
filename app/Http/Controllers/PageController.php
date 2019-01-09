<?php

namespace App\Http\Controllers;

use DB;
use App\Page;
use App\Category;
use Illuminate\Http\Request;

class PageController extends Controller
{


    public function __construct()
    {
        return $this->middleware('auth')->except(['show']);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.pages.index')
            ->with('pages',
                    Page::with('author')
                    ->orderBy('updated_at', 'desc')
                    ->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.pages.form')->with('categories', $categories)->with('page', null);;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $page = null;

        DB::transaction(function () use (&$page, $request) {
            $page = auth()->user()
                ->publications()
                ->create($request->input());

            $page->content()
                ->create($request->only(['body']));
        });

        return [
            "status" => "success",
            "flash" => ["message" => "Page [" . $page->title . "] saved"],
            "page_id" => $page->id
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Page $page
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page)
    {
        $pageData = $page->load('author', 'category', 'content');
        
        return compiledView('page', $pageData->toArray());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Page                 $page
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        $pageData = $page->load('author', 'category', 'content');
        
        $categories = Category::all();

        return view('admin.pages.form')->with('categories', $categories)->with('page',  $pageData);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Page                 $page
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Page $page)
    {
        DB::transaction(function () use ($page, $request) {
            tap($page->fill(request(['category_id', 'title', 'summary', 'status', 'media_url', 'metakeys', 'metadesc'])))
                    ->save()
                        ->content
                            ->fill(request(['body']))
                                ->save();
        });

        return [
                "status" => "success", 
                "flash" => ["message" => "Page [" . $page->title . "] saved"]
                //"page" => $page
            ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Page                 $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
        $page->delete();

        return [
            "status" => "success",
            "flash" => ["message" => "Page [" . $page->title . "] deleted"],
            "page_id" => $page->id
                //"page" => $page
        ];
    }
}
