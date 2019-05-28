<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
        <meta charset="utf-8">
        <title>Profile of {{ $resource->name }}</title>
        <!-- Page Blade -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="{{ $resource->metadesc }}">
        <meta name="keywords" content="{{ $resource->metakey }}">
        <meta name="generator" content="BlogTheory" />
        <meta name="theme-color" content="#fafafa">

        <!-- <link href="https://cdn.jsdelivr.net/npm/tailwindcss@0.7.4/dist/tailwind.min.css?v=1" rel="stylesheet"> -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">

        <style>
                .font-quick {
                        font-family: 'Quicksand', sans-serif;
                }

                .content div {
                        margin-bottom: 1.5rem;
                }

                .content h2 {
                        margin-bottom: 1rem;
                }
        </style>

</head>

<body>

        <div class="w-full border-b">
                <header class="container mx-auto flex items-center px-10">
                        <div class="w-full py-2">
                                
                        <a href="/" class="flex items-center no-underline text-indigo-dark align-middle">
                                <img src="https://flower.app/storage/media/ho8Rkag7bXZd4nt0PNOqgPuLDwLxo3cnya5sgf80.png" alt="Site Logo" class="max-w-full "/>
                                <span class="ml-4 text-4xl font-semibold">{{ $common->sitename }}</span>
                        </a>
                        </div>
                        <div class="w-full py-6 flex justify-end">
                                @includeIf('modules.login')

                        </div>
                </header>
        </div>

        <div class="w-full border-b">
                <div class="container mx-auto lg:flex justify-between px-10">
                        <main class="w-full lg:w-2/3 max-w-md py-6">
                                <article>
                                        <header>

                                                <h1 class="w-full flex items-center mb-6 font-quick">
                                                        {!! $resource->photo('md') !!}
                                                        <span class="text-4xl text-indigo-darker">{{ $resource->name }}</span>
                                                        <span class="text-sm py-1 px-2  rounded bg-indigo-lightest ml-4 text-indigo-dark">{{ ucfirst($resource->type) }}</span>
                                                </h1>

                                        </header>


                                        <p class="bg-grey-lighter py-8 px-4 rounded text-xl font-sand text-grey-darkest leading-tight italic font-thin">
                                                {!! $resource->bio !!}
                                        </p>

                                        <div class="my-4 flex justify-between font-light text-xs tracking-wide">
                                                <p class="italic text-grey-dark">Joined {{ $resource->created_ago }}</p>

                                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="">
                                                        {{ csrf_field() }}
                                                        <button type="submit" class="text-blue hover:underline">Logout</button>
                                                </form>
                                        </div>
                                </article>
                                <div class="mt-8">
                                        @foreach(getModulesforPosition("bottom") as $module)
                                        @include($module)
                                        @endforeach
                                </div>
                        </main>
                        <aside class="w-full lg:w-1/3 py-6">
                                @foreach(getModulesforPosition("aside") as $module)
                                @include($module)
                                @endforeach
                        </aside>
                </div>
        </div>

        <div class="w-full">
                <footer class="container mx-auto lg:flex px-10">
                        @foreach(getModulesforPosition("footer") as $module)
                        @include($module)
                        @endforeach
                </footer>
        </div>

</body>

</html>