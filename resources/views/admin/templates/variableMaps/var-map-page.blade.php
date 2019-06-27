<script>
const variableMap = {

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

        // category object
        'name': '@{{ $resource->name }}',
        'description': '@{{ $resource->description }}',
        'url': '@{{ $resource->url }}',
        'created_ago': '@{{ $resource->created_ago }}',
        'updated_ago': '@{{ $resource->updated_ago }}',
        'subcategories': '@' + 'foreach($resource->subcategories as $category)\n\n' + '@' + 'endforeach',
        'parent': '@{{ $resource->parent }}',
        'pages': '@' + 'foreach($resource->pages as $page)\n\n' + '@' + 'endforeach',

        // author object
        'name': '@{{ $resource->author->name }}',
        'type': '@{{ $resource->author->type }}',
        'email': '@{{ $resource->author->email }}',
        'bio': '@{{ $resource->author->bio }}',
        'url': '@{{ $resource->author->url }}',
        'user.created_at': '@{{ $resource->author->created_at }}',
        'user.created_ago': '@{{ $resource->author->created_ago }}',
        'avatar': '@{{ $resource->author->avatar }}',

        // common
        'sitename': '@{{ $resource->common->sitename }}',
        'sitetitle': '@{{ $resource->common->sitetitle }}',
        'site.metadesc': '@{{ $resource->common->metadesc }}',
        'site.metakey': '@{{ $resource->common->metakey }}',
        
}
</script>