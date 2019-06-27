<script>
const variableMap = {
        // category
        'name': '@{{ $resource->name }}',
        'description': '@{{ $resource->description }}',
        'url': '@{{ $resource->url }}',
        'created_ago': '@{{ $resource->created_ago }}',
        'updated_ago': '@{{ $resource->updated_ago }}',
        'subcategories': '@' + 'foreach($resource->subcategories as $category)\n\n' + '@' + 'endforeach',
        'parent': '@{{ $resource->parent }}',
        'pages': '@' + 'foreach($resource->pages as $page)\n\n' + '@' + 'endforeach',
        // page 
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