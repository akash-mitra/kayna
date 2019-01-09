@extends('admin.layout')

@section('header')
<div class="py-4 px-6">
        <h1 class="w-full p-2">
                <span class="text-lg font-semibold text-grey-darker uppercase">
                        {{ $template->name}}
                </span>
        </h1>

        <h3 class="px-2 text-sm font-light text-grey-dark">
                Created on {{ $template->created_at->format('D, d M Y') }} | Last Updated {{ $template->updated_at->diffForHumans() }}.
        </h3>
</div>
        
@endsection


@section('main')



        

<div class="w-full p-6 bg-white shadow">
        <form action="{{ route('templates.update', $template->id) }}" method="POST" id="frm">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3">
                                <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-password">
                                        Name
                                </label>
                                <input name="name" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-grey" id="inName" value="{{ $template->name }}" type="text" placeholder="e.g. Default Forum Page">
                                <p class="text-grey-dark text-xs italic">Provide a unique name</p>
                        </div>
                </div>

                <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3">
                                <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-password">
                                        Template 
                                </label>
                                <!-- <textarea name="body" class="appearance-none block w-full h-64 bg-blue-darkest text-blue-lighter text-sm border border-grey-lighter rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-grey" id="txtTemplate"  placeholder="e.g. HTML syntax">{{ $template->body }}</textarea> -->
                                <input type="hidden" name="body" id="inpBody">
                                <div id="editor" class="appearance-none block w-full h-64  border border-grey-lighter rounded py-3 px-4 mb-3 leading-tight focus:outline-none">{{ $template->body }}</div>
                                <p class="text-grey-dark text-xs italic">Supports <a class="text-blue no-underline" href="https://laravel.com/docs/master/blade">Blade</a> template</p>
                        </div>
                </div>
        </form>

        <div class="flex items-center">
                <button class="border border-teal px-4 py-2 rounded text-sm bg-teal text-white shadow" id="btnSave">
                        Save                                
                </button>
                <button class="px-4 py-2 mx-2 rounded text-sm text-blue-dark" id="btnClose">
                        Cancel
                </button>
        </div>
</div>

        

        
        
@endsection

@section('script')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.1/ace.js"></script>
        <script>
                var editor = ace.edit("editor");
                editor.setTheme("ace/theme/monokai");
                editor.session.setMode("ace/mode/html");
        </script>
        <script>
                
                document.getElementById('btnSave').onclick = function () {
                        document.getElementById('inpBody').value = editor.getSession().getValue();
                        frm.submit();
                }

                document.getElementById('btnClose').onclick = function () {
                        location.href = '{{ route("templates.index")}}'
                }
        </script>

@endsection