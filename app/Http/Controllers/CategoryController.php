<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
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
        $categories = Category::with('parent')->get();
        return view('admin.categories.index', compact('categories'));
    }


    public function apiIndex()
    {
        return Category::paginate(10);
    }


    public function apiGet(Category $category)
    {
        return $category;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.categories.form')
            ->with('categories', Category::all())
            ->with('category', null);
            
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = tap(new Category(request(['name', 'description', 'parent_id'])))->save();

        return [
            "status" => "success",
            "flash" => ["message" => "Category [" . $category->name . "] saved"],
            "category_id" => $category->id
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
    
        $categories = Category::all();

        return view('admin.categories.form')->with('category', $category)->with('categories', $categories);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        
        $category = tap($category->fill(request(['name', 'description', 'parent_id'])))->save();
    
        return [
            "status" => "success",
            "flash" => ["message" => "Category [" . $category->name . "] saved"]
                //"page" => $page
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return [
            "status" => "success",
            "flash" => ["message" => "Category \"" . $category->name . "\" deleted"],
            "category_id" => $category->id
          
        ];
    }
}
