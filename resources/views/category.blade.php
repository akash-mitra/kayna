<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <title>{{ $resource->name }}</title>
    <!-- Category Blade -->
    <meta name="description" content="{{ $resource->description }}">
    <meta name="keywords" content="{{ $resource->name }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="generator" content="BlogTheory" />
    <meta name="theme-color" content="#fafafa">

    <!-- <link href="https://cdn.jsdelivr.net/npm/tailwindcss@0.7.4/dist/tailwind.min.css?v=1" rel="stylesheet"> -->
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">

    <style>
        .font-quick {
            font-family: 'Quicksand', sans-serif;
        }

        .content p {
            padding-bottom: 1.5rem;
        }

        .content h3 {
            padding-bottom: 1.5rem;
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
                        @if(! empty($resource->parent_id))
                        <div class="w-full text-sm text-grey-darker mb-4">{{ $resource->parent->name }}</div>
                        @endif
                        <h1 class="pb-8 text-4xl text-indigo-darker font-quick">
                            {{ $resource->name }}
                        </h1>
                        <p class="p-8 bg-grey-lightest text-xl font-sans text-grey-darkest leading-tight italic1 font-thin">
                            {{ $resource->description }}
                        </p>
                    </header>

                    <div class="content w-full lg:flex lg:flex-wrap">
                        @foreach($resource->pages as $page)
                        <div class="w-full flex flex-col justify-between lg:w-1/2 px-2 py-6">
                            <div class="py-2 font-quick">
                                <h2 class="my-2">
                                    <a href="{{ $page['url'] }}" class="no-underline text-blue">
                                        {{ $page->title }}
                                    </a>
                                </h2>
                                <p>{{ $page->summary }}</p>
                            </div>
                            <div class="text-grey text-xs">
                                Updated on {{ $resource->updated_at->toFormattedDateString() }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </article>
                <div>

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