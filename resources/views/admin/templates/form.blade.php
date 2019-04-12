@extends('admin.layout')

@section('header')

<div class="py-4 px-6">
        <h1 class="w-full p-2">
                <span class="text-lg font-semibold text-indigo">
                        {{$template->name}}
                </span>
        </h1>

        <h3 class="px-2 text-sm font-light text-indigo-darker">
                Saved as a <span class="font-normal">{{ ucfirst($template->type) }}</span> Template. You can customise it below.
        </h3>
</div>

@endsection


@section('main')

@if (session()->has('message'))
<div class="px-6 py-4 text-green-dark bg-green-lightest border-t border-b border-green w-full" id="flash-msg">
        {{ session('message')}}
</div>
@endif

<form action="{{ route('templates.update', $template->id) }}" method="POST" id="frm">
        @csrf
        {{ method_field('PATCH') }}

        <div class="w-full px-8 py-6 bg-grey-lightest">
                <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-3" for="inName">
                        Name
                </label>
                <input name="name" class="appearance-none block border w-3/4 rounded py-3 px-4 mb-3 text-sm text-black focus:outline-none" id="inName" value="{{ $template->name }}" type="text" placeholder="e.g. My Sleek Template">

                <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-3 mt-6" for="inDesc">
                        Description
                </label>
                <textarea name="description" class="appearance-none block border w-3/4 rounded py-3 px-4 mb-3 text-sm text-black focus:outline-none" id="inDesc" placeholder="e.g. Single column sleek layout for personal blogging">{{ $template->description }}</textarea>
        </div>

        <input type="hidden" name="body" id="inpBody">
</form>

<div class="px-6 py-4 border-t  w-full">
        <span class="px-3 uppercase tracking-wide text-blue cursor-pointer text-xs font-bol1d mb-2" onclick="document.getElementById('advanced-pane').classList.toggle('hidden')">
                Look Under the hood?
        </span>
        <div id="advanced-pane" class="hidden">
                <div class="flex">
                        <div class="w-full px-3">
                                <h3 class="uppercase text-grey tracking-wide text-xs py-3">Code</h3>
                                <div id="editor" class="w-full" style="height: 25rem">{{ $template->body }}</div>
                        </div>

                        <!-- <div class="w-full lg:w-1/3 text-grey-darker font-mono text-sm p-3">
                        <h3>API Reference</h3>
                        <p>Quick list of variables accessible 
                </div> -->
                </div>
        </div>
</div>





<div class="block p-8 border-t border-b w-full bg-grey-lightest">
        <div class="w-3/4 flex items-baseline justify-between">
                <div>
                        <span class="cursor-pointer border border-teal px-4 py-2 rounded text-sm bg-teal text-white shadow" id="btnSave">
                                Save
                        </span>
                        <span class="cursor-pointer px-4 py-2 mx-2 rounded text-sm text-blue-dark" id="btnClose">
                                Close
                        </span>
                </div>
                <div class="">

                        <form action="{{ route('templates.destroy', $template->id) }}" method="POST">
                                @csrf
                                {{ method_field('DELETE') }}
                                <button 
                                type="submit" class="text-xs text-blue-light hover:text-red cursor-pointer" 
                                onclick="return confirm('Are you sure to delete this template from your server?')">Delete this template</button>
                        </form>
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
<script>
        document.getElementById('btnSave').onclick = function() {
                document.getElementById('inpBody').value = editor.getSession().getValue();
                document.getElementById('frm').submit();
        }

        document.getElementById('btnClose').onclick = function() {
                location.href = '{{ route("templates.index")}}'
        }

        let deleteTemplate = function() {
                if (confirm("Delete this template from your server?")) {

                }
        }

        //@if(session()->has('message'))

        setTimeout(function() {
                document.getElementById('flash-msg').style.display = 'none';
        }, 5000);
        //@endif
</script>

@endsection