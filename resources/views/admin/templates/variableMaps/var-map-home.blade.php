<script>
const variableMap = {
        // pages object
        'first_page_url': '@{{ $resource->pages->first_page_url }}',
        'last_page_url': '@{{ $resource->pages->last_page_url }}',
        'next_page_url': '@{{ $resource->pages->next_page_url }}',
        'prev_page_url': '@{{ $resource->pages->prev_page_url }}',
        'total': '@{{ $resource->pages->total }}',
        'per_page': '@{{ $resource->pages->per_page }}',
        'data': '@' + 'foreach($resource->pages as $page)\n\n' + '@' + 'endforeach',
        // page object
        'title': '@{{ $page->title }}',
        'summary': '@{{ $page->summary }}',
        'metakey': '@{{ $page->metakey }}',
        'metadesc': '@{{ $page->metadesc }}',
        'media_url': '@{{ $page->media_url }}',
        'created_at': '@{{ $page->created_at }}',
        'ago': '@{{ $page->ago }}',
        'url': '@{{ $page->url }}',
        'category.name': '@{{ $page->category->name }}',
        'category.description': '@{{ $page->category->description }}',
        'category.url': '@{{ $page->category->url }}',
        'category.created_ago': '@{{ $page->category->created_ago }}',
        'category.updated_ago': '@{{ $page->category->updated_ago }}',
        // common
        'sitename': '@{{ $resource->common->sitename }}',
        'sitetitle': '@{{ $resource->common->sitetitle }}',
        'site.metadesc': '@{{ $resource->common->metadesc }}',
        'site.metakey': '@{{ $resource->common->metakey }}',
        
}
</script>