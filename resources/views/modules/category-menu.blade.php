<nav>
    <div class="flex justify-center flex-no-wrap flex-col md:flex-row overflow-auto">
        <span onclick="moduleMenuToggle()" class="text-indigo-700 text-center mt-2 font-bold tracking-wide uppercase cursor-pointer p-4 rounded md:hidden">
            Menu
        </span>
        @foreach(App\Category::whereNull('parent_id')->get() as $c)
            <a href="{{ $c->url }}" class="menu-mod-item text-indigo-900 whitespace-no-wrap px-4 py-4 my-0 hover:text-indigo-600 hidden md:block">
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