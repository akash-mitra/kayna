<!doctype html>
<html lang="en-us">

<head>
  <meta charset="utf-8">
  <title>{{ $common->sitetitle }}</title>
  <!-- Home Blade -->
  <meta name="description" content="{{ $common->metadesc }}">
  <meta name="keywords" content="{{ $common->metakey }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss/dist/tailwind.min.css" rel="stylesheet">
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
            <div class="w-full py-6">
                <a href="/" class="flex items-center no-underline text-indigo-dark">
                <svg class="w-12 h-12 fill-current" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
 viewBox="0 0 24 24" style="enable-background:new 0 0 24 24;" xml:space="preserve">
                    <title>Kayna Template Logo</title>
                    <g>
                        <path d="M7.406,24.01c-2.895,0-5.25-2.355-5.25-5.25V9.773c0-0.414,0.336-0.75,0.75-0.75h1.196L3.661,7.771
                C2.711,7.602,1.911,7,1.49,6.125C0.616,4.352,0.616,2.228,1.493,0.449c0.103-0.209,0.301-0.36,0.53-0.405
                C2.07,0.036,2.118,0.031,2.167,0.031c0.184,0,0.362,0.068,0.5,0.191C4.272,1.66,4.54,1.76,4.85,1.875
                c0.229,0.085,0.514,0.191,1.043,0.532C6.365,2.72,6.73,3.154,6.955,3.664c0.278,0.672,0.307,1.399,0.09,2.076l2.038,3.284h0.028
                l1.844-5.227c0.039-0.109,0.103-0.21,0.186-0.29l3.404-3.286c0.141-0.136,0.326-0.21,0.521-0.21c0.085,0,0.169,0.014,0.249,0.043
                c0.27,0.095,0.459,0.331,0.495,0.614l0.586,4.695c0.015,0.115,0.002,0.234-0.037,0.344l-1.171,3.318h2.717
                c2.895,0,5.25,2.355,5.25,5.25c-0.006,2.89-2.361,5.241-5.25,5.241h-0.809c-0.37,2.548-2.586,4.496-5.191,4.496H7.406z
                 M3.656,18.76c0,2.068,1.682,3.75,3.75,3.75h4.5c2.066,0,3.748-1.681,3.75-3.746v-8.241h-12V18.76z M17.906,18.014
                c2.063,0,3.746-1.679,3.75-3.743c0-2.067-1.682-3.748-3.75-3.748h-0.75v7.491H17.906z M13.598,9.023l0.704-1.995
                c-0.934-0.016-1.844-0.341-2.575-0.91l-1.025,2.905H13.598z M7.318,9.023L6.132,7.112C5.895,7.312,5.626,7.477,5.338,7.596
                C5.295,7.614,5.251,7.63,5.207,7.646l0.485,1.377H7.318z M2.489,2.06c-0.291,1.136-0.171,2.352,0.35,3.408
                C3.089,5.989,3.62,6.324,4.194,6.324c0.196,0,0.388-0.038,0.571-0.114c0.37-0.153,0.658-0.441,0.811-0.81
                c0.153-0.37,0.153-0.777,0-1.146c-0.103-0.234-0.279-0.441-0.504-0.59C4.689,3.416,4.513,3.351,4.328,3.281
                C3.893,3.119,3.551,2.964,2.489,2.06z M12.271,4.577c0.525,0.599,1.297,0.951,2.103,0.951c0.159,0,0.317-0.014,0.473-0.041
                l0.04-0.114l-0.378-3.031l-2.197,2.121L12.271,4.577z"/>
                    </g>
                </svg>
                <span class="ml-4 text-4xl font-mono font-semibold">{{ $common->sitename }}</span>
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
                
    
                <div class="w-full font-quick lg:flex lg:flex-wrap">
                    <p class="uppercase text-grey tracking-wide px-4">Latest Posts</p>
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