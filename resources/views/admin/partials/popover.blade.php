<div id="popup" class="bg-white border shadow-lg rounded max-w-xs" style="display: none">

    <ul class="list-reset py-2 bg-grey-lightest">
        <li class="px-6 py-1"><a href="{{ route('users.edit', Auth::user()->id) }}" class="no-underline text-indigo-darker hover:text-blue text-sm">View Profile</a></li>
        <li class="px-6 py-1"><a href="https://blogtheory.co/subscription" target="_blank" class="no-underline text-indigo-darker hover:text-blue text-sm">Manage Subscription</a></li>
        <li class="px-6 py-1"><a href="https://blogtheory.co/documentation" target="_blank" class="no-underline text-indigo-darker hover:text-blue text-sm">Documentation</a></li>
        <li class="px-6 py-1"><a href="https://blogtheory.co/help" target="_blank" class="no-underline text-indigo-darker hover:text-blue text-sm">Help & Support</a></li>
    </ul>
    <div class="w-full p-2 bg-grey-lighter border-t">
        <ul class="list-reset">
            <li class="px-6 py-1">
                <a href="{{ route('logout') }}" class="no-underline text-indigo hover:text-blue text-sm" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    {{ csrf_field() }}
                </form>
            </li>
        </ul>
    </div>
</div> 