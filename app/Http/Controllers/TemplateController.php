<?php

namespace App\Http\Controllers;

use App\Template;
use \Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Guzzle\Http\Exception\ClientErrorResponseException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\BadResponseException;

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




    //-----------------------------------------------------------------------------------------------------------------------------------------------------


    /**
     * Returns a list of templates from the BlogTheory's 
     * public repository
     */
    public function templates()
    {
        $client = new Client();

        try {
            $response = $client->get('https://blogtheory.co/repository/templates');
            $result = $response->getBody();
        } catch (\Exception $exception) {

            return response([
                'status' => 'failed',
                'message' => 'Can not read templates from repository [code = ' . $exception->getCode() . ']'
            ], $exception->getCode());
        }

        return json_decode($result, true);
    }


    public function install(Request $request)
    {
        $selected_template_id = $request->input('template');
        $templates = $this->templates();

        foreach($templates as $template) {

            if ($template['id'] === $selected_template_id) {
                $newTemplate = null;

                try {
                    $newTemplate = $this->installTemplate($template);
                    
                } catch (\Exception $exception) {
                    return response([
                        "status" => 'failed',
                        "message" => "Template installation failed [Code " . $exception->getCode() . "]. Try again later."
                    ], 503);
                }

                return redirect(route( 'templates.form', $newTemplate->id));
            }
        }
        return [
            "status" => 'failed',
            "message" => 'supplied template id is not present'
        ];
    }



    public function apply(Request $request)
    {
        $selected_template_id = $request->input('template');
        $template = Template::findOrFail($selected_template_id);
        
        // place the template in view folder
        $content = Storage::disk('repository')->get($template->filename);
        Template::refreshViewTemplate($template->type, $content);

        // update the database
        Template::where('type', $template->type)->update(['active' => 'N']);
        $template->active = 'Y';
        $template->save();

        return redirect()->back();
    }


    public function installTemplate ($template) 
    {
        $body = $this->downloadTemplateBody ($template['url']);
        
        $templateBladeFile = Template::getFileFromTemplateName($template['name'], $template['type']);

        Storage::disk('repository')->put($templateBladeFile, $body);

        $newTemplate = new Template([
            'source_id' => $template['id'],
            'name' => $template['name'],
            'type' => $template['type'],
            'description' => $template['description'],
            'url' => $template['url'],
            'filename' => $templateBladeFile,
            'parameters' => null,
            'positions' => null,
            'active' => 'N'
        ]);

        return tap($newTemplate)->save();
    }


    public function downloadTemplateBody ($url)
    {
        $client = new Client();

        $response = $client->get($url);
        $result = $response->getBody();
        $content = $result->getContents();

        return $content;
    }


    // public function form(Template $template) 
    // {
    //     $body = Storage::disk('repository')->get($template->filename);

    //     $template['body'] = $body;

    //     return view('admin.templates.form', compact('template'));
    // }


    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create($type)
    // {
    //     if (!in_array($type, ['home', 'page', 'category', 'profile'])) {
    //         return abort(400, 'Invalid template type');
    //     }

    //     $template = new Template();
    //     $template->frame = json_encode($this->getDefaultFrame());
    //     $template->type = $type;
    //     $props = json_encode($this->getAPIForContentType($type));
    //     $template->head = json_encode($this->getDefaultHead());


    //     return view('admin.templates.form')
    //         ->with('template', $template)
    //         ->with('props', $props);
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    //     $frame = $request->input('frame');
    //     $head = $request->input('head');

    //     $body = $this->build($frame, $head, $request->input('type'));
    //     $template = tap(new Template([
    //         'name' => $request->input('name'),
    //         'body' => $body,
    //         'type' => $request->input('type'),
    //         'frame' => $frame,
    //         'head' => $head
    //     ]))->save();

    //     return redirect()->to(route('templates.show', $template->id));
    // }

    /**
     * Display the specified resource.
     *
     * @param  \App\Template             $template
     * @return \Illuminate\Http\Response
     */
    // public function show(Template $template)
    // {

    //     $props = $this->getAPIForContentType($template->type);

    //     return view('admin.templates.form')
    //         ->with('template', $template)
    //         ->with('props', json_encode($props));
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Template             $template
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Template $template)
    {
        
        $name = $request->input('name');
        $description = $request->input('description');
        $body = $request->input('body');
        $templateBladeFile = Template::getFileFromTemplateName($name, $template->type);
        
        Storage::disk('repository')->delete ($template->filename);
        Storage::disk('repository')->put ($templateBladeFile, $body);
        
        if ($template->isActive()) {
            Template::refreshViewTemplate( $template->type, $body);
        }
        

        // TODO 
        // In use template must be copied to right place

        $template = tap($template->fill([
            'name' => $name,
            'description' => $description
        ]))->save();
        
        $request->session()->flash( 'message', 'template [' . $template->name . '] saved');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Template             $template
     * @return \Illuminate\Http\Response
     */
    public function destroy(Template $template)
    {
        Storage::disk('repository')->delete($template->filename);

        $template->delete();

        return redirect()->route('templates.index')->with('message', $template->name . " deleted successfully");
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
            ['prop' => 'lang', 'default' => 'en', 'value' => 'en'],
            ['prop' => 'charset', 'default'  => 'UTF-8', 'value'  => 'UTF-8'],
            ['prop' => 'csrf-token', 'default'  => '{{ csrf_token() }}', 'value'  => '{{ csrf_token() }}'],
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
