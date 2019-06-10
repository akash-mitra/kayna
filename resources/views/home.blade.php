<!doctype html>
<html lang="en-us">

<head>
  <meta charset="utf-8">
  <title>{{ $common->sitetitle }}</title>
  <!-- Home Blade -->
  <meta name="description" content="{{ $common->metadesc }}">
  <meta name="keywords" content="{{ $common->metakey }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
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

  <!-- <meta name="theme-color" content="#fafafa"> -->
</head>

<body>

    <div class="w-full border-b">
        <header class="container mx-auto flex items-center px-10">
            <div class="w-full py-2">
                <a href="/" class="flex items-center no-underline text-indigo-dark align-middle">
                    <img src="/storage/media/ho8Rkag7bXZd4nt0PNOqgPuLDwLxo3cnya5sgf80.png" alt="Site Logo" class="max-w-full"/>
                    <span class="ml-4 text-4xl font-semibold">{{ $common->sitename }}</span>
                </a>
            </div>
            
            <div class="w-full py-2 flex justify-end">
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

    <div class="w-full border-b">
        <div class="container mx-auto lg:flex justify-between px-10">
            <main class="w-full lg:w-2/3 max-w-md py-6">
                
    
                <div class="w-full font-quick lg:flex lg:flex-wrap">
                    <p class="w-full uppercase text-grey tracking-wide px-4">Latest Posts</p>
                    @foreach($resource->pages as $item)
                        
                        @if($loop->first)
                            <section class="w-full p-4">
                        @else
                            <section class="w-full lg:w-1/2 p-4">
                        @endif
                                <header>
                                    <h2 class="my-2">
                                        <a href="{{ $item->url }}" class="no-underline text-indigo-darker hover:text-blue">
                                            {{ $item->title }}
                                        </a>
                                    </h2>
                                </header>
                                <div class="text-grey-darker @if($loop->first) text-normal @else text-sm @endif">
                                    {{ $item->summary }}
                                </div>
                                <footer>
                                    <div class="text-xs mt-4 text-indigo">
                                        Published {{ $item->ago }} under {{ $item->category->name }}
                                    </div>
                                </footer>
                            </section>
                    @endforeach
                </div>

                
            </main>
            
            <aside class="w-full lg:w-1/3 py-6">
                
                <p class="uppercase text-grey tracking-wide pb-8 font-quick">Browse Categories</p>
                <div class="w-full font-quick mb-8">
                    @foreach($resource->categories as $item)
                        <a href="{{ $item->url }}" class="no-underline text-indigo p-2 rounded-lg bg-indigo-lightest mx-2 font-quick">{{$item->name}}</a>
                    @endforeach
                </div>
                
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