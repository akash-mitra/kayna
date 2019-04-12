@auth
    <a href="{{ auth()->user()->url }}" class="no-underline">
        <img src="{{ auth()->user()->avatar }}" class="h-8 w-8 rounded-full" />
    </a>
@endauth
@guest
    <a href="/login" class="text-indigo no-underline text-sm">
    Register / Login 
    </a>
@endguest