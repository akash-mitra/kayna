@extends('admin.layout')

@section('header')
<div class="py-4 px-6">
    <h1 class="w-full p-2">
        <span class="text-lg font-semibold text-indigo uppercase">
            Media Gallery
        </span>
    </h1>

    <h3 class="px-2 text-sm font-light text-indigo-darker">
        Browse all your media files in a single place
    </h3>
</div>
@endsection


@section('main')

<div class="p-2">
        <media-gallery deletable></media-gallery>
</div>

@endsection

@section('script')
<script src="/js/media-gallery.js"></script>
<script>
    new Vue({el: 'main'})
</script>

@endsection