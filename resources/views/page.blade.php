<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <title>{{ $resource->title }}</title>
    <!-- Page Blade -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $resource->metadesc }}">
    <meta name="keywords" content="{{ $resource->metakey }}">
    <meta name="generator" content="BlogTheory" />
    <meta name="theme-color" content="#fafafa">

    <!-- <link href="https://cdn.jsdelivr.net/npm/tailwindcss@0.7.4/dist/tailwind.min.css?v=1" rel="stylesheet"> -->
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
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
                    <img src="https://flower.app/storage/media/ho8Rkag7bXZd4nt0PNOqgPuLDwLxo3cnya5sgf80.png" alt="Site Logo" class="max-w-full"/>
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
                        <div class="w-full mb-4">
                            <a href="{{ $resource->category->url }}" class="no-underline text-sm text-blue">{{ $resource->category->name }}</a>
                        </div>
                        <h1 class="mb-6 text-4xl text-indigo-darker font-quick">
                            {!! $resource->title !!}
                        </h1>
                        <p class="pb-3 text-xl font-sans text-grey-darkest leading-tight italic1 font-thin">
                            {!! $resource->summary !!}
                        </p>

                        <div class="mb-4 py-3 border-b border-dotted text-sm text-blue-darker font-serif flex justify-between items-center">
                            <address class="author mr-1">
                                <a rel="author" href="{{ $resource->author->url }}" class="text-blue no-underline flex items-center">
                                    <img src="{{ $resource->author->avatar }}" alt="author image" class="rounded-full w-8 h-8 mr-4 no-modal" />
                                    {{ $resource->author->name }}
                                </a>
                            </address>

                            <time datetime="2011-08-28" class="text-grey-darker">
                                {{ $resource->updated_at->toFormattedDateString() }}
                            </time>
                            <!-- &nbsp;|&nbsp; -->
                            <!-- <div class="ml-4">12 min</div> -->
                        </div>
                    </header>

                    <div class="content text-black font-quick leading-normal">
                        {!! $resource->content->body !!}
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

    @include('modules.image-modal')
</body>

</html>