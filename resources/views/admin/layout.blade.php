<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Bliss Admin</title>
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

        <div class="hidden flex-none md:flex md:flex-col md:w-full xl:w-1/5  max-h-screen overflow-scroll" id="leftCol">

            <div class="nav-scrollbar-wrapper">

                @include('admin.partials.nav')
            </div>
            
        </div><!-- end of left col -->


        <div class="flex-1 w-full xl:w-4/5">

            <div class="max-h-screen  overflow-scroll">

                <header class="flex justify-between bg-grey-lighter">
                    
                    
                    <div class="w-full">
                        @yield('header')
                           
                        
                    </div>
                    <div class="py-4 px-6 text-grey-darker text-right">
                        @if (Route::has('login'))
                            <div class="top-right links">
                                @auth
                                    <a href="{{ route('profile', Auth::user()->slug) }}" class="no-underline">
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


                <main class="w-full bg-grey-lighter min-h-screen px-8">
                
                    @yield('main')

                    <flash  message="{{ empty($flash) ? session('flash') : $flash }}"></flash>

                </main>
                
            </div>
            
        </div>

    </div>
    
    <script>

        /**
         * This code is for creating the left side menu toggle 
         * behavior. 
         */
        // let toggleSideBar = function () {
        //         var leftCol = document.getElementById('leftCol');
        //         var logoBlock = document.getElementById('logoBlock');
        //         if (leftCol.style.display === 'none') {
        //             leftCol.style.display = 'flex'
        //             logoBlock.style.display = 'none'
        //         }
        //         else {
        //             logoBlock.style.display = 'block';
        //             leftCol.style.display = 'none';
        //         }
        // }, btnSidebar = document.getElementsByClassName('btnSidebar');

        // for (var i = 0; i < btnSidebar.length; i++) {
        //     btnSidebar[i].addEventListener('click', toggleSideBar);
        // }

    
    </script>

    <script src="{{ mix('/js/app.js') }}"></script>

    @yield('script')
    
</body>
</html>