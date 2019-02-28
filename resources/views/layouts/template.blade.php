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

        .checkers {
                background-color: #ffffff;
                background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8' viewBox='0 0 8 8'%3E%3Cg fill='%239C92AC' fill-opacity='0.4'%3E%3Cpath fill-rule='evenodd' d='M0 0h4v4H0V0zm4 4h4v4H4V4z'/%3E%3C/g%3E%3C/svg%3E");
        }
         
    </style>
    
    @yield('css')

    
</head>
<body class="font-sans">
    
    <div class="flex flex-wrap bg-white">

        <div class="flex-1 w-full xl:w-4/5">

            <div class="max-h-screen overflow-scroll">

                <header class="flex justify-between bg-grey-lightest">
                    
                    
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


                <main class="w-full bg-grey-lightest min-h-screen">
                
                    @yield('main')

                    <flash  message="{{ empty($flash) ? session('flash') : $flash }}"></flash>

                </main>
                
            </div>
            
        </div>

    </div>
    
    <script src="{{ mix('/js/app.js') }}"></script>

    @yield('script')
    
</body>
</html>