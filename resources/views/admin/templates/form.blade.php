@extends('admin.layout')

@section('header')

<div class="py-4 px-6">
        <h1 class="w-full p-2">
                <span class="text-lg font-semibold text-indigo">
                        Save "{{$template->name}}" As
                </span>
        </h1>

        <h3 class="px-2 text-sm font-light text-indigo-darker">
                {{ ucfirst($template->type) }} Template
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

        <div>
                <div class="w-full p-6 bg-grey-lightest">
                        <div class="w-full sm:flex items-baseline justify-between p-3">
                                <div class="w-full flex items-baseline">
                                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mr-3" for="inName">
                                                Name
                                        </label>
                                        <input name="name" class="appearance-none block border w-3/4 rounded py-3 px-4 mb-3 focus:outline-none" id="inName" value="{{ $template->name }}" type="text" placeholder="e.g. Default Forum Page">
                                </div>
                                <div class="flex items-baseline justify-end">
                                        <span class="cursor-pointer px-4 py-2 mx-2 rounded text-sm text-blue-dark" id="btnClose">
                                                Cancel
                                        </span>
                                        <span class="cursor-pointer border border-teal px-4 py-2 rounded text-sm bg-teal text-white shadow" id="btnSave">
                                                Save
                                        </span>
                                </div>
                        </div>
                        <span class="px-3 uppercase tracking-wide text-blue cursor-pointer text-xs font-bol1d mb-2" onclick="document.getElementById('advanced-pane').classList.toggle('hidden')">
                                Do you need to customize the template?
                        </span>
                </div>
        </div>
        <div>
                <div id="advanced-pane" class="hidden px-6">
                        <div class="flex">
                                <div class="w-full px-3">
                                        <h3 class="uppercase text-grey tracking-wide text-xs py-3">Code</h3>
                                        <input type="hidden" name="body" id="inpBody">
                                        <div id="editor" class="w-full" style="height: 25rem">{{ $template->body }}</div>
                                </div>

                                <!-- <div class="w-full lg:w-1/3 text-grey-darker font-mono text-sm p-3">
                                        <h3>API Reference</h3>
                                        <p>Quick list of variables accessible 
                                </div> -->
                        </div>
                </div>
        </div>
</form>


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

        //@if(session()->has('message'))

        setTimeout(function() {
                document.getElementById('flash-msg').style.display = 'none';
        }, 5000);
        //@endif
</script>

@endsection