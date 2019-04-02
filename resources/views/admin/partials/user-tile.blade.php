@if (Route::has('login'))
@auth
<div id="user-ref" class="max-w-xs cursor-pointer p-2 popup-opener">
    <div class="flex items-center popup-opener">
        <img class="w-8 h-8 rounded-full mr-4 popup-opener" src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}">
        <div class="text-sm popup-opener">
            <p class="text-black leading-none popup-opener">{{ Auth::user()->name }}</p>
            <p class="text-grey-dark flex items-center popup-opener">
                {{ ucfirst(Auth::user()->type) }}
                <svg class="fill-current h-4 w-4 popup-opener" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                </svg>
            </p>
        </div>
    </div>
</div>
@else
<a class="no-underline text-blue-dark" href="{{ route('login') }}">Login</a>&nbsp;
<a class="no-underline text-blue-dark" href="{{ route('register') }}">Register</a>
@endauth
@endif 