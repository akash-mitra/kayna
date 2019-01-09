<?php

namespace App\Http\Controllers;

use App\Template;
use \Illuminate\Http\Request;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = $request->get('q');

        if (!empty($query)) {
            $templates = Template::where('name', 'like', '%' . $query . '%')->simplePaginate(15);
        } else {
            $templates = Template::simplePaginate(15);
        }

        return view('admin.templates.index')
                    ->with('templates', $templates)
                    ->with('query', $query);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.templates.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $template = new Template($request->input());

        $template->save();

        return redirect()->route('templates.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Template             $template
     * @return \Illuminate\Http\Response
     */
    public function show(Template $template)
    {
        return view('admin.templates.show', compact('template'));
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Template             $template
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Template $template)
    {
        $template->fill($request->input())->save();

        return redirect()->route('templates.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Template             $template
     * @return \Illuminate\Http\Response
     */
    public function destroy(Template $template)
    {
    }
}
