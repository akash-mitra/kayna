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

<div class="w-full flex flex-wrap px-6 border-t border-b bg-grey-lightest py-4 mb-4 items-center justify-between text-grey-darker">
        <label class="my-2 mx-2">
                <span class="uppercase tracking-wide text-xs mr-2">Name</span>
                <input type="text" v-model="name" class="border rounded text-grey-darker text-sm py-1 px-2" placeholder="Search words..."/>
        </label>

        <label class="my-2 mx-2"> 
                <span class="uppercase tracking-wide text-xs mr-2">Location</span>
                <select v-model="selectedStorage" class="text-sm text-grey-darkest border w-32 bg-white">
                        <option v-for="option in storageOptions" v-bind:value="option.value">
                                @{{ option.text }}
                        </option>
                </select>
        </label>

        <label class="my-2 mx-2"> 
                <span class="uppercase tracking-wide text-xs mr-2">Type</span>
                <select v-model="selectedType" class="text-sm text-grey-darkest border w-32 bg-white">
                        <option v-for="option in typeOptions" v-bind:value="option.value">
                                @{{ option.text }}
                        </option>
                </select>
        </label>

        <button @click="search" class="bg-teal text-white px-2 py-1 rounded shadow m-2">Search</button>

</div>

<div class="w-full flex flex-wrap px-6">
        <div v-for="photo in photos.data" class="w-full sm:w-1/2 md:w-1/3 xl:w-1/4">
                <div class="bg-white shadow mr-4 mb-4">
                        <div class="w-full bg-grey-lightest border-b text-grey-darker text-sm p-2 truncate">
                                <span v-text="photo.name"></span>
                        </div>
                        <div class="w-full flex items-center justify-center py-4 px-2">
                                <img :src="'/' + photo.path" />
                        </div>
                        
                        <div class="w-full flex bg-grey-lighter border-t justify-between text-grey-dark text-xs p-2">
                                <span v-text="photo.storage.toUpperCase()"></span>
                                <span>@{{ photo.size }} KB</span>
                        </div>
                </div>
        </div>
</div>



@endsection

@section('script')

<script>
    new Vue({
        el: 'main',
        data: {
                needle: '',
                photos: @json($photos),
                typeOptions: [
                    {text: 'Any', value: ''},
                    {text: 'PNG', value: 'png'},
                    {text: 'JPG', value: 'jpg'},
                    {text: 'GIF', value: 'gif'},
                    {text: 'ICO', value: 'ico'},
                    {text: 'SVG', value: 'svg'},
                ],
                selectedType: '{{ $query["type"] }}',
                storageOptions: [{text: 'Any', value: ''}, {text: 'Local', value: 'public'}, {text: 'AWS Cloud', value: 's3'}],
                selectedStorage: '{{ $query["storage"] }}',
                name: '{{ $query["name"] }}',
        },

        methods: {
                search: function () {
                        let href= (location.protocol + '//' + location.host + location.pathname + '?'
                                + (this.name.length? 'name=' + this.name + '&': '')
                                + (this.selectedType.length? 'type=' + this.selectedType + '&': '')
                                + (this.selectedStorage.length? 'storage=' + this.selectedStorage + '&': ''))
                        // console.log(href);
                        location.href = href;
                },
            deleteCategory: function(id) {
                // let p = this
                // axios.delete('/admin/categories/' + id)
                //     .then(function(response) {
                //         p.removeCategoryById(response.data.category_id)
                //         flash({
                //             message: response.data.flash.message
                //         })
                //     })
            },
        }
    })
</script>

@endsection