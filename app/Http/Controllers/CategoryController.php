<?php

namespace App\Http\Controllers;

use Validator;
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
        $categories = Category::with('parent', 'pages')->get();
        // return $categories;
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
        $categoryData = $category->load('pages','parent');
        // return $categoryData;

        // return compiledView('category', $categoryData->toArray());

        return view('category', [
            "resource" => $categoryData,
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
        
        Validator::make($request->all(), [
            'name' => 'required|max:255',
            'parent_id' => [function ($attribute, $value, $fail) use ($category) {
                if ($category->id === $value) {
                    $fail('Category can not be created under itself.');
                }
            }]
        ])->validate();
        

        $category = tap($category->fill(request(['name', 'description', 'parent_id'])))->save();
    
        return [
            "status" => "success",
            "flash" => ["message" => "Category [" . $category->name . "] saved"]
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
        $noSubcategories = $category->subcategories()->count();
        if ($noSubcategories > 0 ) {
            return response([
                "status" => "failed",
                "flash" => [
                    "message" => "Can not delete as this category has " . $noSubcategories . " sub-categories under it.",
                    "type" => "warning"
                ],
            ], 422);
        }

        $category->delete();

        return [
            "status" => "success",
            "flash" => ["message" => "Category \"" . $category->name . "\" deleted"],
            "category_id" => $category->id
        ];
    }
}
