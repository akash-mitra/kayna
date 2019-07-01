<?php

namespace App\Http\Controllers;

use App\Page;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{


    // public function __construct()
    // {
    //     //return $this->middleware('auth')->except(['show']);
    // }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = Page::with(['author', 'category', 'comments'])
            ->orderBy('updated_at', 'desc')
            ->get();
        return view('admin.pages.index', compact('pages'));
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
     * Store a newly created page in storage.
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

            if ($request->filled('body')) {
                $page->content()->create($request->only(['body']));
            }

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

        if ($pageData->status != 'Live') {
            return abort(503, "This page is currently unavailable.");
        }

        return view('page', [
            "resource" => $pageData,
            "common" => (object)[
                "sitename" => param('sitename'),
                "sitetitle" => param('tagline'),
                "metadesc" => param('sitedesc'),
                "metakey" => param('sitekeys')
            ]
        ]);
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

        return view('admin.pages.form')->with('categories', $categories)->with('page', $pageData);
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

            $page = tap($page->fill($request->only(['category_id', 'title', 'summary', 'status', 'media_url', 'metakey', 'metadesc'])))->save();

            if ($request->filled('body')) {

                if ($page->content) {
                    $page->content->fill($request->only(['body']))->save();
                } else {
                    $page->content()->create($request->only(['body']));
                }
            }
            
        });

        return [
            "status" => "success",
            "flash" => ["message" => "Page [" . $page->title . "] saved"]
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



    public function apiGetAll()
    {
        return Page::paginate(10);
        // return Page::with(['author', 'category'])
        //     ->orderBy('updated_at', 'desc')
        //     ->get();
    }


    public function apiGet(Page $page)
    {
        return $page;
    }

    public function apiSetStatus(Request $request)
    {
        $page_id = $request->input('page_id');
        $status  = $request->input('status');
        $page = Page::findOrFail($page_id);
        $page->status = $status;
        $page->save();

        return [
            "status" => "success",
            "flash" => ["message" => "Page status updated to [" . $page->status . "]"],
            "page_id" => $page->id
        ];
    }


    
    public function apiSetAuthor(Request $request)
    {
        $page_id = $request->input('page_id');
        
        $page = Page::findOrFail($page_id);

        $page->user_id = auth()->user()->id;

        $page->save();

        return [
            "status" => "success",
            "flash" => ["message" => "You are now the author of this page"],
            "page_id" => $page->id
        ];
    }
}
