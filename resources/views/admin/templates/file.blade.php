@extends('admin.layout')

@section('header')
        
<div class="py-4 px-6">
        
        <h1 class="w-full p-2">
                <a class="text-lg font-semibold text-indigo no-underline" href="{{ route('templates.edit', $template->id) }}">
                        {{ ucfirst($template->name) }} / 
                </a>
                <span class="text-lg font-semibold text-grey-darker">
                        @if($type==='other')
                                {{ $filename }}
                        @else
                                {{ ucfirst($type) }}
                        @endif
                </span>
        </h1>        
</div>
@endsection


@section('main')
<div class="w-full px-6">

        <div class="flex justify-between items-center">
                
                <div class="flex">
                        <span id="menu_boiler" class="p-4 cursor-pointer font-bold text-grey-darker hover:text-indigo">Boilerplate</span>
                        <span id="menu_variable" class="p-4 cursor-pointer font-bold text-grey-darker hover:text-indigo">Variable</span>
                        <span id="menu_fullscreen" class="p-4 cursor-pointer font-bold text-grey-darker hover:text-indigo">Expand</span>
                </div>

                <div class="flex items-center">
                        @if(session()->has('flash')) 
                                <span class="p-4 text-grey-darker text-xs auto-dispose">{{ session("flash") }}</span> 
                        @endif
                        <span id="menu_save" class="px-10 py-2 my-4 mx-4 shadow rounded cursor-pointer font-bold text-white bg-indigo">Save</span>
                </div>
        </div>

        <div class="w-full md:flex bg-white p-4">
                <div id="editor" class="w-full" style="height: 30rem">{{ $content }}</div>
                <div id="variable" class="w-full md:w-2/3 px-4 bg-grey-lighter overflow-scroll" style="height: 30rem; display: none">
                        @include('admin.templates.variables.index')
                </div>
                <div id="qref" class="w-full md:w-2/3 px-4 bg-white" style="height: 30rem; display: none">
                        <h3>Docs</h3>
                </div>
        </div>
        
</div>

@endsection

@section('script')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.5/ace.js" integrity="sha256-5Xkhn3k/1rbXB+Q/DX/2RuAtaB4dRRyQvMs83prFjpM=" crossorigin="anonymous"></script>
        
        @if($type==='other')
                @switch($extension)
                        @case("CSS")
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.5/mode-css.js" integrity="sha256-ejRV6HoEO4cwL/ZQ6sKQynq563ad5yVQMYZX4yQIX3U=" crossorigin="anonymous"></script>
                        @break
                        @case("JS")
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.5/mode-javascript.js" integrity="sha256-9nVHCZW1SuyhaVgqmPk1XutGn+g/ASVBiVAheioldo4=" crossorigin="anonymous"></script>
                        @break
                        @default
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.5/mode-php_laravel_blade.js" integrity="sha256-Y0m4DvHCUvjdHwKNzSha4auMQmit9Oj5mU3hMgDrLFY=" crossorigin="anonymous"></script>
                @endswitch
        @else
                <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.5/mode-php_laravel_blade.js" integrity="sha256-Y0m4DvHCUvjdHwKNzSha4auMQmit9Oj5mU3hMgDrLFY=" crossorigin="anonymous"></script>
        @endif
        
        <script>
                var editor = ace.edit("editor");
                editor.setTheme("ace/theme/solarized_dark");

                @if($type==='other')
                        @switch($extension)
                                @case("CSS")
                                editor.session.setMode("ace/mode/css");
                                @break
                                @case("JS")
                                editor.session.setMode("ace/mode/javascript");
                                @break
                                @default
                                editor.session.setMode("ace/mode/php_laravel_blade");
                        @endswitch
                @else
                        editor.session.setMode("ace/mode/php_laravel_blade");
                @endif
        </script>
        
        @include('admin.templates.boilerplate')

        @include('admin.templates.variableMaps.map')
        
        <script>
                let qref = util.get('#qref')

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


                /*
                 * Saves the file to the server
                 */
                util.click('#menu_save', function () {
                        util.submit('{{ route("templates.file.save", [$template->id, $type]) }}', {
                                data: editor.getValue(),
                                filename: '{{ $filename }}'
                        })
                });


                /*
                 * Shows a auto-disposing success message after successful saving of the contents
                 */
                const els = document.getElementsByClassName('auto-dispose');
                for (var i = 0; i < els.length; i++) 
                {
                        let item = els[i];
                        setTimeout(function () { 
                                item.style.display = 'none' 
                        }, 3000);
                        
                }
        </script>
@endsection