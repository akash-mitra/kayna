<h4 class="py-2 uppercase text-sm text-grey-dark border-b">
    In this Category
</h4>

<?php
    $c = \App\Category::findOrFail($category["id"]);
?>
<ul class="list-reset">
@foreach($c->pages as $p)
    <li class="my-1 py-2 text-sm border-b border-grey-lighter">
        <a href="{{ $p->url }}" class="no-underline text-blue-dark">{{ $p->title }}</a>
    </li>
@endforeach
</ul>