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

    .page-body h2, .page-body h3, .page-body h4 {
        margin-top: 1em;
        font-family: 'Playfair Display', serif;
        font-size: 1.75em;
        margin-bottom: 0.5em;
        color: #333333;
    }

    .page-body h2 {
        font-size: 1.75em;
    }

    .page-body h3 {
        font-size: 1.6em;
    }

    .page-body h4 {
        font-size: 1.25em;
    }


    .page-body p {
        margin-bottom: 1em;
        color: #555555;
        line-height:1.5em;
        font-size: 1.1em;
        font-weight: 100;
    }

    .page-body table {
        width: 100%;
        border-collapse: collapse;
        vertical-align: baseline;
        margin-top: 2rem;
        margin-bottom: 2rem;
    }

    .page-body thead th {
        background-color: #f7fafc;
        font-weight: 600;
        padding: 0.5rem;
        text-align: left;
    }

    .page-body tbody {
        vertical-align: baseline
    }

    .page-body tbody tr:hover {
        background-color: #f7fafc;
    }
    .page-body tbody td {
        border-top-width: 1px;
        border-color: #e2e8f0;
        padding: 0.5rem
    }

    pre, img {
        margin-top: 2rem;
        margin-bottom: 2rem;
    }

  </style>

  <meta name="theme-color" content="#fafafa">

</head>

<body>
    <div class="w-full max-w-5xl mx-auto px-6 font-reading">

        <div class="w-full flex items-center justify-between py-4">
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

        <div class="w-full border-b">
            @include('modules.category-menu')
        </div>

        <main>
            <div class="mt-6 max-w-2xl mx-auto">
                <article>
                    <header>
                        
                        <p class="text-center">
                            <a href="{{ $resource->category->url }}" class="text-sm text-blue-500">{{ $resource->category->name }}</a>
                        </p>
                        
                        <h3 class="mt-4 text-4xl text-center font-heading text-indigo-800">{{ $resource->title }}</h3>

                        <div class="flex justify-center mt-6 items-center text-indigo-800">
                            <div class="flex items-center">
                                <a href="{!! $resource->author->url !!} ">
                                    {!! $resource->author->photo() !!}  
                                </a>
                                {{ $resource->author->name }}
                            </div>
                            <time datetime="{{ $resource->updated_at->toDateTimeString() }}" class="text-indigo-800">
                                &nbsp; Updated on {{ $resource->updated_at->toFormattedDateString() }}
                            </time>
                        </div>
                        
                        <p class="mt-6 text-lg mt-4 p-6 bg-gray-100 rounded-lg text-gray-700">{{ $resource->summary }}</p>

                    </header>

                    <div class="font-reading mt-6 page-body">
                        {!! $resource->body !!}
                    </div>

                </article>
            </div>
            
        </main>

        <div class="max-w-2xl mx-auto">
            <aside>
            @foreach(getModulesforPosition("bottom") as $module)
                @include($module)
            @endforeach
            </aside>
        </div>

        <div class="w-full flex justify-center mt-10 p-4 border-t text-indigo-400 rounded-lg">
            <footer>
                &copy; {{ $common->sitename }}
            </footer>
        </div>
    </div>

    @include('modules.highlighting')

    @include('modules.image-expander')

</body>
</html>