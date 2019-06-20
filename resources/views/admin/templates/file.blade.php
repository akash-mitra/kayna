@extends('admin.layout')

@section('header')
        
<div class="py-4 px-6">
        
        <h1 class="w-full p-2">
                <a class="text-lg font-semibold text-indigo no-underline" href="{{ route('templates.edit', $template->id) }}">
                        {{ ucfirst($template->name) }} / 
                </a>
                <span class="text-lg font-semibold text-grey-darker">
                        {{ ucfirst($type) }}
                </span>
        </h1>        
</div>
@endsection


@section('main')
<div class="w-full px-6">
        <div class="flex">
                <span id="menu_save" class="p-4 cursor-pointer font-bold text-grey-darker hover:text-indigo">Save</span>
                <span id="menu_boiler" class="p-4 cursor-pointer font-bold text-grey-darker hover:text-indigo">Boilerplate</span>
                <span id="menu_variable" class="p-4 cursor-pointer font-bold text-grey-darker hover:text-indigo">Variable</span>
                <span id="menu_ref" class="p-4 cursor-pointer font-bold text-grey-darker hover:text-indigo">Docs</span>
                <span id="menu_fullscreen" class="p-4 cursor-pointer font-bold text-grey-darker hover:text-indigo">Expand</span>
        </div>
        <div class="w-full md:flex bg-white p-4">
                <div id="editor" class="w-full" style="height: 30rem">{{ $content }}</div>
                <div id="variable" class="w-full md:w-2/3 px-4 bg-grey-lighter overflow-scroll" style="height: 30rem; display: none">
                        @include('admin.templates.variables')
                </div>
                <div id="qref" class="w-full md:w-2/3 px-4 bg-white" style="height: 30rem; display: none">
                        <h3>Docs</h3>
                </div>
        </div>
        
</div>

@endsection

@section('script')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.3/ace.js" integrity="sha256-gkWBmkjy/8e1QUz5tv4CCYgEtjR8sRlGiXsMeebVeUo=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.3/mode-php_laravel_blade.js" integrity="sha256-+2NX/jqWgjkR31OcFDazKbHbXSZC4uQYYPoFo4yVhlI=" crossorigin="anonymous"></script>
        <script>
                var editor = ace.edit("editor");
                editor.setTheme("ace/theme/solarized_dark");
                editor.session.setMode("ace/mode/php_laravel_blade");
        </script>
        
        @include('admin.templates.boilerplate')
        
        <script>
                let qref = util.get('#qref')
                util.click('#menu_ref', function () {
                        variable.style.display = 'none'
                        qref.style.display = (qref.style.display === 'none'? 'block' : 'none')
                })

                let variable = util.get('#variable')
                util.click('#menu_variable', function () {
                        qref.style.display = 'none'
                        variable.style.display = (variable.style.display === 'none'? 'block' : 'none')
                })

                util.click('#menu_boiler', function () {
                        util.confirm('This will insert HTML5 Boilerplate code in the code editor.',
                        function () {
                                editor.session.insert(editor.getCursorPosition(), text)
                        })
                })

                util.click('.variable', function (event) {
                        let key = event.target.innerText
                        if(variableMap.hasOwnProperty(key)) {
                                editor.session.insert(editor.getCursorPosition(), variableMap[key])
                        }
                })

                const variableMap = {
                        'first_page_url': '@{{ $resource->pages->first_page_url }}',
                        'last_page_url': '@{{ $resource->pages->last_page_url }}',
                        'next_page_url': '@{{ $resource->pages->next_page_url }}',
                        'prev_page_url': '@{{ $resource->pages->prev_page_url }}',
                        'total': '@{{ $resource->pages->total }}',
                        'per_page': '@{{ $resource->pages->per_page }}',
                        'data': '@' + 'foreach($resource->pages as $page)\n\n' + '@' + 'endforeach',
                        'title': '@{{ $page->title }}',
                        'summary': '@{{ $page->summary }}',
                        'metakey': '@{{ $page->metakey }}',
                        'metadesc': '@{{ $page->metadesc }}',
                        'media_url': '@{{ $page->media_url }}',
                        'created_at': '@{{ $page->created_at }}',
                        'ago': '@{{ $page->ago }}',
                        'url': '@{{ $page->url }}',
                        'category.name': '@{{ $page->category->name }}',
                        'category.description': '@{{ $page->category->description }}',
                        'category.url': '@{{ $page->category->url }}',
                        'category.created_ago': '@{{ $page->category->created_ago }}',
                        'category.updated_ago': '@{{ $page->category->updated_ago }}',
                }


                /*
                 * Saves the file to the server
                 */
                util.click('#menu_save', function () {
                        util.submit('{{ route("templates.file.save", [$template->id, $type]) }}', {
                                data: editor.getValue()
                        })
                })
        </script>
@endsection