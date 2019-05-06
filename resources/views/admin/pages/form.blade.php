<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>BlogTheory Admin</title>
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="/storage/css/main.css">

    @includeIf('admin.pages.editors.'. param('editor') . '.css')
</head>

<body class="font-sans bg-grey-lightest">

    <div class="w-full md:flex">

        <div class="hidden md:block md:w-1/5 max-h-screen overflow-y-auto">
            <div class="w-full">
                @include('admin.partials.logo')
            </div>
            <div class="w-full">
                @include('admin.partials.nav')
            </div>
        </div>

        <div class="w-full md:w-4/5 bg-white min-h-screen max-h-screen overflow-x-hidden overflow-y-auto">
            
            <div class="h-16 fixed w-full md:w-4/5 flex justify-center items-center border-b bg-white z-20">
                <trix-toolbar id="my_toolbar" style="padding-top:10px" class="bg-transparent"></trix-toolbar>
                
            </div>

            <main class="mt-16 w-full z-10">
                
                @includeIf('admin.pages.editors.'. param('editor') . '.main')
                
                <flash message="{{ empty($flash) ? session('flash') : $flash }}"></flash>
            </main>
            
        </div>
    </div>


    @include('admin.partials.popover')

    <script src="{{ mix('/js/app.js') }}"></script>

    @include('admin.partials.enable-menu-toggle')

    @include('admin.partials.popover-js')

    @includeIf('admin.pages.editors.'. param('editor') . '.js')
    
</body>
</html>