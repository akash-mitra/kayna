@if(param('login_native_active') === 'yes' || param('login_google_active') === 'yes' || param('login_facebook_active') === 'yes')
@auth
<a href="{{ auth()->user()->url }}" class="no-underline">
    @if(empty(auth()->user()->avatar))
    <svg v-else class="w-16 h-16 rounded-full border-4 mr-4 fill-current text-grey-light" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
        <path class="heroicon-ui" d="M12 12a5 5 0 1 1 0-10 5 5 0 0 1 0 10zm0-2a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm9 11a1 1 0 0 1-2 0v-2a3 3 0 0 0-3-3H8a3 3 0 0 0-3 3v2a1 1 0 0 1-2 0v-2a5 5 0 0 1 5-5h8a5 5 0 0 1 5 5v2z" />
    </svg>
    @else
    <img src="{{ auth()->user()->avatar }}" class="h-8 w-8 rounded-full" />
    @endif
</a>
@endauth
@guest
<a href="/login" class="text-indigo no-underline text-sm">
    Register / Login
</a>
@endguest
@endif