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

    <div class="w-full">
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

    <div class="w-full bg-indigo-darker flex items-center">
        <nav class="container mx-auto px-10">
            <div class="flex flex-no-wrap flex-col md:flex-row overflow-auto">
                <span onclick="moduleMenuToggle()" class="text-grey-lighter tracking-wide uppercase px-4 py-4 my-0 md:hidden cursor-pointer">
                    Menu
                </span>
                @foreach(App\Category::whereNull('parent_id')->get() as $c)
                    <a href="{{ $c->url }}" class="menu-mod-item no-underline text-white whitespace-no-wrap px-4 py-4 my-0 hover:bg-indigo hidden md:block">
                        {{ $c->name }}
                    </a>
                @endforeach
                <script>
                    const items = document.getElementsByClassName('menu-mod-item')
                    function moduleMenuToggle() {
                        for(let i = 0; i < items.length; i++) {
                            let item = items[i]
                            item.classList.toggle('hidden')
                        }
                    }
                </script>
            </div>
        </nav>
    </div>

    <div class="w-full">
        <div class="container mx-auto lg:flex justify-between px-10">
            <main class="w-full lg:w-2/3 max-w-md py-6">
                <article>
                    <header>
                        @if(! empty($resource->parent_id))
                        <div class="w-full text-sm text-grey-darker mb-4">{{ $resource->parent->name }}</div>
                        @endif
                        <h1 class="text-4xl text-indigo-darker font-quick">
                            {{ $resource->name }}
                        </h1>
                        @if(! empty($resource->description))
                        <p class="text-xl font-sans text-grey-darkest leading-tight italic font-thin">
                            {{ $resource->description }}
                        </p>
                        @endif
                    </header>

                    @if(count($resource->subcategories))
                    <div class="w-full mt-4">
                        <h3 class="mt-10 pb-4 text-sm uppercase text-grey-dark font-quick">Sub-Categories</h3>
                        <table class="border-none">
                            <tbody>
                            @foreach($resource->subcategories as $category)
                                <tr>
                                    <td class="pl-0 pr-4 text-grey hidden md:table-cell align-top whitespace-no-wrap align-top">
                                       # {{ $loop->iteration }}
                                    </td>
                                    <td class="px-0 align-top">
                                        <a href="{{ $category->url }}" class="no-underline text-indigo font-bold font-quick">{{ $category->name }}</a>
                                    </td>
                                    <td class="px-0 text-grey-darker font-quick">
                                        {{ $category->description }}
                                    </td>   
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif

                    @if(count($resource->pages))
                        <h3 class="mt-10 text-sm uppercase text-grey-dark font-quick">Pages</h3>
                        <div class="content w-full lg:flex lg:flex-wrap">
                            @foreach($resource->pages as $page)
                            <div class="w-full flex flex-col justify-between lg:w-1/2 pr-8 py-4">
                                <div class="pt-2 font-quick">
                                    <h2 class="my-2">
                                        <a href="{{ $page['url'] }}" class="no-underline text-blue">
                                            {{ $page->title }}
                                        </a>
                                    </h2>
                                    <p class="my-1">{{ $page->summary }}</p>
                                </div>
                                <div class="text-grey text-xs">
                                    Updated on {{ $resource->updated_at->toFormattedDateString() }}
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif
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