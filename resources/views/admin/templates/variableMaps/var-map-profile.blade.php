<script>
const variableMap = {

        // author object
        'name': '@{{ $resource->name }}',
        'type': '@{{ $resource->type }}',
        'email': '@{{ $resource->email }}',
        'bio': '@{{ $resource->bio }}',
        'url': '@{{ $resource->url }}',
        'user.created_at': '@{{ $resource->created_at }}',
        'user.created_ago': '@{{ $resource->created_ago }}',
        'avatar': '@{{ $resource->avatar }}',

        // common
        'sitename': '@{{ $resource->common->sitename }}',
        'sitetitle': '@{{ $resource->common->sitetitle }}',
        'site.metadesc': '@{{ $resource->common->metadesc }}',
        'site.metakey': '@{{ $resource->common->metakey }}',
        
}
</script>