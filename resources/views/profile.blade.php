<!doctype html>
<html lang="en-us">

<head>
  <meta charset="utf-8">
  
  <title>{{ $common->sitetitle }}</title>
  
  <meta name="description" content="{{ $common->metadesc }}">
  <meta name="keywords" content="{{ $common->metakey }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Playfair+Display|Quicksand&display=swap" rel="stylesheet">

  <style>
    .font-heading {
        font-family: 'Playfair Display', serif;
    }
    
    .font-reading {
        font-family: 'Quicksand', sans-serif;
    }

    .pattern {
        background-color: #3c366b;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 56 28' width='56' height='28'%3E%3Cpath fill='%235a67d8' fill-opacity='0.4' d='M56 26v2h-7.75c2.3-1.27 4.94-2 7.75-2zm-26 2a2 2 0 1 0-4 0h-4.09A25.98 25.98 0 0 0 0 16v-2c.67 0 1.34.02 2 .07V14a2 2 0 0 0-2-2v-2a4 4 0 0 1 3.98 3.6 28.09 28.09 0 0 1 2.8-3.86A8 8 0 0 0 0 6V4a9.99 9.99 0 0 1 8.17 4.23c.94-.95 1.96-1.83 3.03-2.63A13.98 13.98 0 0 0 0 0h7.75c2 1.1 3.73 2.63 5.1 4.45 1.12-.72 2.3-1.37 3.53-1.93A20.1 20.1 0 0 0 14.28 0h2.7c.45.56.88 1.14 1.29 1.74 1.3-.48 2.63-.87 4-1.15-.11-.2-.23-.4-.36-.59H26v.07a28.4 28.4 0 0 1 4 0V0h4.09l-.37.59c1.38.28 2.72.67 4.01 1.15.4-.6.84-1.18 1.3-1.74h2.69a20.1 20.1 0 0 0-2.1 2.52c1.23.56 2.41 1.2 3.54 1.93A16.08 16.08 0 0 1 48.25 0H56c-4.58 0-8.65 2.2-11.2 5.6 1.07.8 2.09 1.68 3.03 2.63A9.99 9.99 0 0 1 56 4v2a8 8 0 0 0-6.77 3.74c1.03 1.2 1.97 2.5 2.79 3.86A4 4 0 0 1 56 10v2a2 2 0 0 0-2 2.07 28.4 28.4 0 0 1 2-.07v2c-9.2 0-17.3 4.78-21.91 12H30zM7.75 28H0v-2c2.81 0 5.46.73 7.75 2zM56 20v2c-5.6 0-10.65 2.3-14.28 6h-2.7c4.04-4.89 10.15-8 16.98-8zm-39.03 8h-2.69C10.65 24.3 5.6 22 0 22v-2c6.83 0 12.94 3.11 16.97 8zm15.01-.4a28.09 28.09 0 0 1 2.8-3.86 8 8 0 0 0-13.55 0c1.03 1.2 1.97 2.5 2.79 3.86a4 4 0 0 1 7.96 0zm14.29-11.86c1.3-.48 2.63-.87 4-1.15a25.99 25.99 0 0 0-44.55 0c1.38.28 2.72.67 4.01 1.15a21.98 21.98 0 0 1 36.54 0zm-5.43 2.71c1.13-.72 2.3-1.37 3.54-1.93a19.98 19.98 0 0 0-32.76 0c1.23.56 2.41 1.2 3.54 1.93a15.98 15.98 0 0 1 25.68 0zm-4.67 3.78c.94-.95 1.96-1.83 3.03-2.63a13.98 13.98 0 0 0-22.4 0c1.07.8 2.09 1.68 3.03 2.63a9.99 9.99 0 0 1 16.34 0z'%3E%3C/path%3E%3C/svg%3E");
    }
  </style>

  <meta name="theme-color" content="#fafafa">

</head>

<body>
    <div class="w-full max-w-5xl mx-auto px-6 font-reading">

        <div class="w-full flex items-center justify-between py-4 border-b">
            <div class="w-1/3 text-left">
                <a href="/">
                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" class="stroke-current text-purple-800 inline-block fill-current" style="height: 3rem; width: 3rem" 
	 viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                    <g>
                        <g>
                            <path d="M146.798,286c-5.52,0-10,4.48-10,10c0,5.52,4.48,10,10,10c5.52,0,10-4.48,10-10C156.798,290.48,152.318,286,146.798,286z"
                                />
                        </g>
                    </g>
                    <g>
                        <g>
                            <path d="M146.798,326c-5.523,0-10,4.477-10,10v126c0,5.523,4.477,10,10,10c5.523,0,10-4.477,10-10V336
                                C156.798,330.477,152.32,326,146.798,326z"/>
                        </g>
                    </g>
                    <g>
                        <g>
                            <path d="M424.194,7.516c-0.824-3.215-3.19-5.812-6.314-6.931c-3.125-1.118-6.601-0.615-9.278,1.345
                                c-9.993,7.315-60.255,44.942-68.442,67.424c-4.867,13.391-3.761,28.008,2.773,40.39c-12.26,17.586-24.959,41.868-36.135,65.593V10
                                c0-5.523-4.478-10-10-10h-80c-5.523,0-10,4.477-10,10v196h-1.795l-17.08-66.449c-0.008-0.033-0.017-0.066-0.026-0.099
                                l-15.53-57.95c-0.001-0.002-0.001-0.004-0.002-0.006c-0.09-0.333-0.199-0.661-0.323-0.984c-0.038-0.099-0.084-0.194-0.125-0.292
                                c-0.094-0.225-0.192-0.447-0.303-0.665c-0.054-0.106-0.113-0.208-0.171-0.312c-0.113-0.205-0.232-0.407-0.36-0.604
                                c-0.065-0.099-0.132-0.196-0.2-0.293c-0.137-0.195-0.281-0.384-0.432-0.57c-0.042-0.051-0.076-0.107-0.119-0.157l-59.34-69.92
                                c-2.484-2.927-6.424-4.173-10.139-3.208c-3.715,0.965-6.55,3.972-7.295,7.738l-17.93,90.62c-0.013,0.067-0.016,0.135-0.028,0.201
                                c-0.046,0.261-0.084,0.522-0.109,0.784c-0.011,0.111-0.018,0.222-0.025,0.333c-0.015,0.25-0.021,0.498-0.018,0.747
                                c0.001,0.116,0.002,0.232,0.008,0.348c0.012,0.255,0.037,0.508,0.069,0.761c0.013,0.104,0.021,0.207,0.037,0.31
                                c0.055,0.353,0.125,0.702,0.217,1.047l15.512,57.892l10.406,41.166c-6.07,1.035-11.665,3.905-16.11,8.35
                                c-5.667,5.668-8.789,13.201-8.789,21.211c0,13.036,8.361,24.152,20,28.28V462c0,27.57,22.43,50,50,50h200c27.57,0,50-22.43,50-50
                                V264.296c4.168-1.471,7.991-3.866,11.211-7.085c5.668-5.668,8.789-13.201,8.789-21.211c0-14.612-10.504-26.811-24.356-29.46
                                c6.523-26.504,11.121-52.843,12.818-73.509c13.35-5.163,23.88-15.762,28.875-29.48C442.338,81.025,427.294,19.601,424.194,7.516z
                                M356.239,125.755c4.135,3.253,8.78,5.852,13.808,7.682c4.806,1.749,9.801,2.741,14.824,2.971
                                c-2.005,19.938-6.599,44.761-12.911,69.592h-57.164C330.067,171.396,344.172,144.092,356.239,125.755z M226.798,20h60v23h-20
                                c-5.522,0-10,4.477-10,10s4.478,10,10,10h20v20h-20c-5.522,0-10,4.477-10,10s4.478,10,10,10h20v20h-20c-5.522,0-10,4.477-10,10
                                c0,5.523,4.478,10,10,10h20v20h-20c-5.522,0-10,4.477-10,10s4.478,10,10,10h20v23h-60V20z M109.154,36.443l41.027,48.342
                                c-6.167,7.791-14.635,13.379-24.41,15.997c-9.737,2.609-19.822,2.017-29.028-1.61L109.154,36.443z M100.131,120.994
                                c4.43,0.928,8.942,1.403,13.479,1.403c5.781,0,11.602-0.76,17.336-2.296c10.238-2.742,19.46-7.778,27.134-14.647l10.486,39.127
                                L184.353,206h-62.139l-11.552-45.701c-0.011-0.046-0.023-0.092-0.036-0.137L100.131,120.994z M376.798,462
                                c0,16.542-13.458,30-30,30h-200c-16.542,0-30-13.458-30-30V266h260V462z M396.798,236c0,2.668-1.041,5.179-2.931,7.068
                                c-1.891,1.891-4.401,2.932-7.069,2.932h-280c-5.514,0-10-4.486-10-10c0-2.668,1.041-5.179,2.931-7.068
                                c1.891-1.891,4.401-2.932,7.069-2.932h90.385c0.02,0,0.039,0.002,0.058,0.002c0.013,0,0.026-0.002,0.039-0.002h102.224
                                c0.016,0,0.033,0.002,0.049,0.002c0.011,0,0.022-0.002,0.034-0.002h80.07c0.012,0,0.025,0.002,0.037,0.002
                                c0.02,0,0.039-0.002,0.059-0.002h7.046C392.311,226,396.798,230.486,396.798,236z M415.341,96.709
                                c-3.529,9.692-11.659,16.809-21.771,19.041c-5.533,1.234-11.301,0.851-16.682-1.106c-5.575-2.03-10.374-5.62-13.876-10.379
                                c-0.001-0.002-0.003-0.004-0.004-0.006c-5.978-8.113-7.492-18.607-4.055-28.066c3.748-10.292,28.141-32.238,49.371-48.931
                                C414.164,53.8,419.082,86.436,415.341,96.709z"/>
                        </g></g>
                    </svg>
                    </a>
            </div>
            <div class="hidden sm:block w-1/3 text-center">
                <a href="/" title="Homepage" class="cursor-pointer font-heading text-2xl md:text-3xl font-bold text-purple-800">{{ $common->sitename }}</a>
            </div>
            <div class="w-1/3 flex justify-end">
            @includeIf('modules.login')
            
            </div>
        </div>

        <div class="w-full">
        @include('modules.category-menu')
        </div>

        <div class="w-full pattern text-white rounded-lg overflow-scroll">
            <div class="max-w-4xl mx-auto text-center">

                <header class="w-full">
                    <div class="flex flex-col items-center justify-center">

                        <form class="w-full" method="post" action="/logout">
                            @csrf
                            <button class="w-full sm:text-right p-4" type="submit">
                                Logout
                            </button>
                        </form>


                        {!! $resource->photo('xl') !!}

                        <div class="my-4">
                            <h1 class="text-5xl text-indigo-100 font-heading font-bold italic leading-tight">
                                {{ $resource->name }}
                            </h1>
                            
                            <p class="mb-6 text-lg leading-tight italic text-indigo-200">
                                {{ ucfirst($resource->type) }} 
                            </p>
                        </div>
                    </div>

                </header>
            </div>
        </div>

        <main>

            @if(count($resource->publications))
                <h3 class="mt-10 text-sm uppercase text-gray-700 text-center pb-4 border-b">publications</h3>
                <div class="w-full md:flex md:flex-wrap">
                    @foreach($resource->publications()->limit(25)->get() as $page)
                    <div class="w-full flex flex-col justify-between md:w-1/2 pr-8 py-4">
                        <div class="pt-2 font-quick">
                            <h2 class="my-2">
                                <a href="{{ $page['url'] }}" class="text-blue-500 text-lg">
                                    {{ $page->title }}
                                </a>
                            </h2>
                            <p class="my-1 text-gray-800">{{ $page->summary }}</p>
                        </div>
                        <div class="text-gray-500 text-xs">
                            Updated on {{ $page->updated_at->toFormattedDateString() }}
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif

        </main>

        <div class="w-full flex justify-center mt-6 p-4 border-t text-indigo-400 rounded-lg">
                &copy; {{ $common->sitename }}
        </div>
    </div>

</body>
</html>