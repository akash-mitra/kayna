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
    public function create($type)
    {
        if (!in_array($type, ['home', 'page', 'category', 'profile'])) {
            return abort(400, 'Invalid template type');
        }

        $template = new Template();
        $template->frame = json_encode($this->getDefaultFrame());
        $template->type = $type;
        $props = json_encode($this->getAPIForContentType($type));
        $template->head = json_encode($this->getDefaultHead());


        return view('admin.templates.form')
            ->with('template', $template)
            ->with('props', $props);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $frame = $request->input('frame');
        $head = $request->input('head');
        
        $body = $this->build($frame, $head, $request->input('type'));
        $template = tap(new Template([
            'name' => $request->input('name'),
            'body' => $body,
            'type' => $request->input('type'),
            'frame' => $frame,
            'head' => $head
        ]))->save();

        return redirect()->to(route('templates.show', $template->id));
    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Template             $template
     * @return \Illuminate\Http\Response
     */
    public function show(Template $template)
    {

        $props = $this->getAPIForContentType($template->type);

        return view('admin.templates.form')
            ->with('template', $template)
            ->with('props', json_encode($props));

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
        $frame = $request->input('frame');
        $head = $request->input('head');

        $body = $this->build($frame, $head, $request->input('type'));

        $template = tap($template->fill([
            'name' => $request->input('name'),
            'body' => $body,
            'type' => $request->input('type'),
            'frame' => $frame,
            'head' => $head
        ]))->save();

        return [
            'status' => 'success',
            'flash' => ['message' => 'template [' . $template->name . '] saved'],
            'template_id' => $template->id
        ];
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

    private function getAPIForContentType($type)
    {
        $props = [];
        if ($type === 'page') {
            $props = \App\Page::props();
        }
        if ($type === 'category') {
            $props = \App\Category::props();
        }
        if ($type === 'profile') {
            $props = \App\User::props();
        }

        $filteredProps = [];
        foreach ($props as $prop) {
            if ($prop['visibility'] === true) {
                // $prop['class'] = '';
                array_push($filteredProps, $prop);
            }
        }

        return $filteredProps;
    }

    private function getDefaultFrame()
    {
        return [
            [
                'class' => 'flex',
                'cols' => [
                    [
                        'class' => 'w-full bg-white flex justify-between',
                        'positionNames' => 'header',
                        'positions' => [
                            [
                                'name' => 'header',
                                'class' => '',
                                'items' => [
                                    ['name' => 'title', 'class' => 'text-3xl', 'placeholder' => ['tag' => 'span', 'text' => 'The Intersteller Journey to the futures']]
                                ]
                            ],
                            [
                                'name' => 'login',
                                'class' => 'p-4',
                                'items' => []
                            ]
                        ]
                    ]
                ]
            ],
            [
                'class' => 'flex',
                'cols' => [
                    ['class' => 'w-full bg-white', 'positionNames' => 'body', 'positions' => [['name' => 'body', 'class' => '', 'items' => []]]]
                ]
            ],
            [
                'class' => 'flex',
                'cols' => [
                    ['class' => 'w-full bg-white', 'positionNames' => 'footer', 'positions' => [['name' => 'footer', 'class' => '', 'items' => []]]]
                ]
            ],
        ];
    }


    private function getDefaultHead()
    {
        return [
            ['prop' => 'lang', 'default' => 'us', 'value' => 'us' ], 
            ['prop' =>'charset' , 'default'  =>'UTF-8' , 'value'  => 'UTF-8'], 
            ['prop' =>'csrf-token' , 'default'  =>'{{ csrf_token() }}' , 'value'  => '{{ csrf_token() }}'],
            ['prop' => 'title', 'default' => '{{ $title }}', 'value' => '{{ $title }}'],
            ['prop' => 'css', 'default' => 'https://cdn.jsdelivr.net/npm/tailwindcss/dist/tailwind.min.css', 'value' => 'https://cdn.jsdelivr.net/npm/tailwindcss/dist/tailwind.min.css'],
            ['prop' => 'template-css', 'default' => '/storage/css/main.css', 'value' => '/storage/css/main.css'],
            ['prop' => 'js', 'default' => 'https://cdn.jsdelivr.net/npm/vue@2.5.21/dist/vue.js', 'value' => 'https://cdn.jsdelivr.net/npm/vue@2.5.21/dist/vue.js'], 
        ];
    }

    private function build($frame, $head, $type)
    {
        $frameJson = json_decode($frame);
        $headJson = json_decode($head);

        return Template::buildFromFrame($frameJson, $headJson, $type);
    }
}
