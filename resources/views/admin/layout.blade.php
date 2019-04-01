<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>BlogTheory Admin</title>
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet" />
    <link href="/css/admin/fa.css" rel="stylesheet" />

    <style>
        .active {
            background-color: transparent;
        }

        .btnSidebar {
            cursor: pointer;

        }

        @media (max-width: 1200px) {
            .nav-scrollbar-wrapper nav {
                flex-wrap: nowrap;
                overflow-x: auto;
                overflow-y: auto;
                white-space: nowrap;
            }
        }
    </style>

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

            <div class="max-h-screen  overflow-scroll">

                <header class="flex justify-between bg-grey-lighter">


                    <div class="w-full">
                        @yield('header')


                    </div>
                    <div class="p-4 text-grey-darker text-right">
                        @if (Route::has('login'))
                        <div class="top-right links">
                            @auth
                            <a href="{{ route('profiles.show', Auth::user()->slug) }}" class="no-underline">
                                <img class="w-10 h-10 rounded-full mr-4" src="{{ Auth::user()->avatar }}" alt="User Avatar">
                            </a>

                            @else
                            <a class="no-underline text-blue-dark p-2 hover:shadow rounded" href="{{ route('login') }}">Login</a>
                            <a class="no-underline text-blue-dark p-2 hover:shadow rounded" href="{{ route('register') }}">Register</a>
                            @endauth
                        </div>
                        @endif
                    </div>

                </header>


                <main class="w-full bg-grey-lighter min-h-screen px-81">

                    @yield('main')

                    <flash message="{{ empty($flash) ? session('flash') : $flash }}"></flash>

                </main>

            </div>

        </div>

    </div>

    <script>
        /**
         * This code is for creating the left side menu toggle 
         * behavior. 
         */
        let toggleMenu = function() {
            let menu_list = document.getElementsByClassName('menu-list');
            for (let i = 0; i < menu_list.length; i++) {
                menu_list[i].classList.toggle("hidden");
            }
        }
    </script>

    <script src="{{ mix('/js/app.js') }}"></script>

    @yield('script')

</body>

</html> 