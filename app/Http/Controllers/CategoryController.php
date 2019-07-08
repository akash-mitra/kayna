<?php

namespace App\Http\Controllers;

use Validator;
use App\Category;
use Illuminate\Http\Request;


class CategoryController extends Controller
{

    /**
     * Display a list of categories 
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::with('parent', 'pages')->latest()->get();
        
        return view('admin.categories.index', compact('categories'));
    }



    /**
     * Show the form for creating a new category.
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
     * Store a newly created Category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable|max:500',
            'parent_id' => 'nullable|numeric|exists:categories,id'
        ]);

        $category = tap(new Category(request(['name', 'description', 'parent_id'])))->save();

        session()->flash('flash', 'Category [' . $category->name . '] saved');

        return redirect()->route('categories.index');
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        $categoryData = $category->load('pages','parent', 'subcategories');
        
        return view('category', [
            "resource" => $categoryData,
            "common" => (object)[
                "sitename" => param('sitename'),
                "sitetitle" => param('sitedesc'),
                "metadesc" => param('sitedesc'),
                "metakey" => ''
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
        $request->validate([
            'name' => 'sometimes|required|max:255',
            'description' => 'sometimes|nullable|max:500',
            'parent_id' => 'sometimes|nullable|numeric|exists:categories,id'
        ]);

        Validator::make($request->all(), [
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

        if ($noSubcategories > 0) {
            session()->flash('flash', 'Can not delete as this category has sub-categories under it.');   
             
        } else {
            $category->delete();
            session()->flash('flash', 'Category [' . $category->name . '] deleted.');
        }
        
        return redirect()->route('categories.index');
    }



    public function apiGetAll()
    {
        return Category::paginate(10);
    }


    
    public function apiGet(Category $category)
    {
        return $category;
    }
}
