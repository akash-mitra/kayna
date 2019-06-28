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
    public function index()
    {
        $templates = Template::all();
        return view('admin.templates.index')
            ->with('templates', $templates);
    }


    /**
     * Shows the initial template creation form
     * (Before files are added)
     */
    public function create()
    {
        $template = new Template();
        $template->resources = [];
        return view('admin.templates.form', compact('template'));
    }


    /**
     * This is called when a template is being created for the
     * first time. It creates the main entry for the template
     * in the database and creates the template directory.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:5|alpha_dash|unique:templates,name',
            'description' => 'max:255'
        ]);

        $template = new Template($request->only(['name', 'description']));
        $template->save();
        $template->createTemplateDirectory();

        return redirect()->route('templates.edit', $template->id);
    }



    /**
     * Shows the template edit page (after the template has been created)
     */
    public function edit(Template $template)
    {
        return view('admin.templates.form', compact('template'));
    }



    /**
     * Sets the requested template as the default template
     */
    public function setDefault(Request $request)
    {

        $request->validate([
            'template_id' => 'required|numeric'
        ]);

        $template = Template::findOrFail($request->input('template_id'));

        $template->setDefault();

        session()->flash('flash', 'Successfully set as the default template!');

        return back();
    }


    /**
     * Remove the specified template
     *
     * @param  \App\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function destroy(Template $template)
    {

        if ($template->isActive()) {
            
            session()->flash('flash', "Active template can not be deleted");
            
            return back();
        }

        $template->removeFiles();

        $template->delete();

        session()->flash('flash', $template->name . " deleted successfully");

        return redirect()->route('templates.index');
    }

    
}
