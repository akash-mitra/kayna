<div class="w-full">
        @if(session()->has('message'))
                        <div class="bg-green-lightest text-green text-sm py-4 px-6 mb-6 border-b border-green">{{ session('message') }}</div>
        @endif

        <div class="px-6 py-6">
                <h3 class="font-bold text-indigo">Application Cache</h3>
                <p class="py-4 text-grey-dark">Application Cache holds a copy of frequently accessed information such as paramters, modules etc. <br>If you find that your cache data is stale or old, you may delete your application cache data from here.</p>
                <form action="{{ route('app.cache.clear') }}" method="post">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-green text-white rounded shadow hover:bg-green-dark">Clear App Cache</button>
                </form>
        </div>
</div>