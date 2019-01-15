<?php

namespace App\Http\Controllers;

use App\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modules = Module::all();
        return view('admin.modules.index', compact('modules'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.modules.form')->with('types', Module::getTypes())->with('module', null);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $filename = $request->input('name');
        $content = $request->input('code');
        $data = request(['name', 'type', 'position', 'exceptions', 'applicables', 'active']);
        
        
        Module::storeTemplate($filename, $content);
        $module = tap(new Module($data))->save();

        return [
            'status' => 'success',
            'flash' => ['message' => 'module [' . $module->name . '] saved'],
            'module_id' => $module->id
        ];

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function show(Module $module)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function edit(Module $module)
    {

        $content = Module::getTemplate($module->name);
        $moduleWithCode = $module->toArray();
        $moduleWithCode['code'] = $content;
        return view('admin.modules.form')->with('types', Module::getTypes())->with('module', $moduleWithCode);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Module $module)
    {
       
        $filename = $request->input('name');
        $content = $request->input('code');
        
        $data = request(['name', 'type', 'position', 'exceptions', 'applicables', 'active']);
        


        Module::updateTemplate($module->name, $filename, $content);
        $module = tap($module->fill($data))->save();

        return [
            'status' => 'success',
            'flash' => ['message' => 'module [' . $module->name . '] saved']
                
        ];

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function destroy(Module $module)
    {
        
        Module::removeTemplate($module->name);
        $module->delete();

        return [
            'status' => 'success',
            'flash' => ['message' => 'Module [' . $module->name . '] deleted'],
            'module_id' => $module->id
                
        ];

    }
}
