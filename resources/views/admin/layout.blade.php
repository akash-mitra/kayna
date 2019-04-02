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

    <div class="flex flex-wrap bg-white">

        <div class="w-full md:w-1/5  max-h-screen overflow-scroll" id="leftCol">

            <div class="nav-scrollbar-wrapperq">

                @include('admin.partials.nav')
            </div>

        </div><!-- end of left col -->

        <div class="flex-1 w-full md:w-4/5">

            <div class="max-h-screen overflow-scroll">
                <header class="relative bg-grey-lighter w-full">
                    @yield('header')

                    <div class="absolute pin-t pin-r m-6">
                        @include('admin.partials.user-tile')
                    </div>
                </header>

                <main class="w-full bg-grey-lighter min-h-screen">
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