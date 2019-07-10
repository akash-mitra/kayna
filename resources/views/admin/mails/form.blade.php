@extends('admin.layout')

@section('header')
        
<div class="py-4 px-6">
        
        <h1 class="w-full py-2">
                <a class="text-lg font-semibold text-indigo no-underline" href="{{ route('mails.index') }}">
                        Mails
                </a>
                <span class="text-lg text-grey-dark font-semibold">
                    / Standard Emails
                </span>
        </h1>        
</div>
@endsection


@section('main')
<div class="w-full px-6">

        <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-indigo font-light text-xl"> {{ $name }}</h1>
                    <p class="text-grey-darker py-3 text-sm"><code>{{ $file }}</code></p>
                </div>
                <div class="flex items-center">
                        @if(session()->has('flash')) 
                                <span class="p-4 text-grey-darker text-xs auto-dispose">{{ session("flash") }}</span> 
                        @endif
                        <span id="menu_save" class="px-10 py-2 my-4 mx-4 shadow rounded cursor-pointer font-bold text-white bg-indigo">Save</span>
                </div>
        </div>

        <div class="w-full md:flex bg-white">
                <div id="editor" class="w-full" style="height: 30rem">{{ $contents }}</div>
        </div>
        
</div>

@endsection

@section('script')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.5/ace.js" integrity="sha256-5Xkhn3k/1rbXB+Q/DX/2RuAtaB4dRRyQvMs83prFjpM=" crossorigin="anonymous"></script>
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.5/mode-php_laravel_blade.js" integrity="sha256-Y0m4DvHCUvjdHwKNzSha4auMQmit9Oj5mU3hMgDrLFY=" crossorigin="anonymous"></script>
        
        <script>
                var editor = ace.edit("editor");
                editor.setTheme("ace/theme/solarized_dark");
                editor.session.setMode("ace/mode/php_laravel_blade");
        </script>
        
        
        <script>
                


                /*
                 * Saves the file to the server
                 */
                util.click('#menu_save', function () {
                        util.submit('{{ route("mails.save") }}', {
                                'mail_file_name': "{{ $slug }}",
                                'mail_content': editor.getValue(),
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