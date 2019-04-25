@if (Route::has('login'))
@auth
<div id="user-ref" class="max-w-xs cursor-pointer p-6 popup-opener">
    <div class="flex items-center popup-opener">
        <a href="{{ route('users.edit', auth()->user()->id) }}">
            @if(empty(auth()->user()->avatar))
            <svg v-else class="w-8 h-8 rounded-full border-2 border-grey mr-4 fill-current text-grey" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                <path class="heroicon-ui" d="M12 12a5 5 0 1 1 0-10 5 5 0 0 1 0 10zm0-2a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm9 11a1 1 0 0 1-2 0v-2a3 3 0 0 0-3-3H8a3 3 0 0 0-3 3v2a1 1 0 0 1-2 0v-2a5 5 0 0 1 5-5h8a5 5 0 0 1 5 5v2z" />
            </svg>
            @else
            <img class="w-8 h-8 rounded-full mr-4 popup-opener" src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}">
            @endif
        </a>
        <div class="text-sm popup-opener hidden sm:block">
            <p class="text-black leading-none popup-opener">{{ Auth::user()->name }}</p>
            <p class="text-grey text-xs italic flex mt-1 items-center popup-opener">
                {{ ucfirst(Auth::user()->type) }}
                <svg class="fill-current h-4 w-4 popup-opener" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                </svg>
            </p>
        </div>
    </div>
</div>
@else
<div class="flex p-6">
    <a class="no-underline text-blue-dark" href="{{ route('login') }}">Login</a>&nbsp;
    <a class="no-underline text-blue-dark" href="{{ route('register') }}">Register</a>
</div>
@endauth
@endif