@extends('admin.layout')

@section('header')
<div class="px-6 py-4">
        <h1 class="w-full p-2">
                <span class="text-lg font-semibold text-grey-darker uppercase">
                        Create new Template
                </span>
        </h1>

        <h3 class="p-2 text-sm font-light text-grey-dark">
                Use blade syntax to create a new template
        </h3>
</div>
        
@endsection


@section('main')
        
<div class="w-full p-6 bg-white shadow">
        <form action="/admin/templates" method="POST" id="frm">
                {{ csrf_field() }}
                <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3">
                                <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-password">
                                        Name
                                </label>
                                <input name="name" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-grey" id="inName" type="text" placeholder="e.g. Default Forum Page">
                                <p class="text-grey-dark text-xs italic">Provide a unique name</p>
                        </div>
                </div>

                <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3">
                                <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-password">
                                        Template 
                                </label>
                                <!-- <textarea name="body" class="appearance-none block w-full h-64 bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-grey" id="txtTemplate"  placeholder="e.g. HTML syntax"></textarea> -->
                                <input type="hidden" name="body" id="inpBody">
                                <div id="editor" class="appearance-none block w-full h-64  border border-grey-lighter rounded py-3 px-4 mb-3 leading-tight focus:outline-none"></div>
                                <p class="text-grey-dark text-xs italic">Supports <a href="https://laravel.com/docs/master/blade">Blade</a> template</p>
                        </div>
                </div>
        </form>

        <button class="border border-teal px-4 py-2 rounded text-sm bg-teal text-white shadow" id="btnSave">
                Save                                
        </button>
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
        </script>

@endsection