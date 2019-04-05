<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>BlogTheory Admin</title>
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet" />

    @yield('css')
</head>

<body class="font-sans">

    <div class="w-full md:flex">

        <div class="w-full md:w-1/6 max-h-screen overflow-y-auto">
            <div class="w-full">
                @include('admin.partials.logo')
            </div>
            <div class="w-full">
                @include('admin.partials.nav')
            </div>
        </div>

        <div class="w-full md:w-5/6 bg-grey-lighter min-h-screen max-h-screen overflow-x-hidden overflow-y-auto">
            <div class="w-full flex justify-between items-center bg-grey-lighter">
                @yield('header')
                @include('admin.partials.user-tile')
            </div>
            <div class="w-full">
                <main class="w-full">
                    @yield('main')
                    <flash message="{{ empty($flash) ? session('flash') : $flash }}"></flash>
                </main>
            </div>
        </div>
    </div>


    @include('admin.partials.popover')

    <script src="{{ mix('/js/app.js') }}"></script>

    @include('admin.partials.enable-menu-toggle')

    @include('admin.partials.popover-js')

    @yield('script')

</body>

</html>