@extends('admin.layout')

@section('header')
<div class="py-4 px-6">
        <h1 class="w-full p-2">
                <span class="text-lg font-semibold text-grey-darker uppercase borqder-b">
                        Tags
                </span>
        </h1>

        <h3 class="px-2 text-sm font-light text-grey-dark">
                Create or Edit Tag
        </h3>
</div>        
@endsection


@section('main')
        
        <div class="pt-4 flex justify-between">
                
                <input type="text" v-model="needle" id="txtSearch" class="p-3 w-1/3 text-sm bg-white border-grey-lighter rounded-lg border shadow" placeholder="Search name or description...">
                
                <a href="{{ route('tags.create') }}" id="btnNew" class="border border-teal px-3 py-3 rounded text-sm bg-teal no-underline hover:bg-orange hover:border-orange text-white shadow">
                        New Tag
                </a>

        </div>

        <div class="w-full mt-8 bg-white shadow rounded">
                <table class="w-full text-left table-collapse">
                        <thead class="uppercase text-xs font-semibold text-grey-darker border-b-2">
                                <tr>
                                        <th class="p-4">Name</th>
                                        <th class="p-4">Publications</th>
                                        <th class="p-4">Created</th>
                                        <th class="p-4">Actions</th>
                                </tr>
                        </thead>
                        <tbody class="align-baseline">
                                <tr v-for="tag in filter_tags">
                                        
                                        <td class="px-4 py-2 border-t border-grey-light whitespace-no-wrap">

                                                <p class="py-1 text-sm font-semibold" v-text="tag.name"></p>
                                                <p class="text-xs text-grey-darker" v-text="tag.description"></p>
                                                
                                        </td>
                                        <td class="px-4 py-2 border-t border-grey-light font-mono text-xs text-purple-dark whitespace-no-wrap">
                                                10
                                        </td>
                                        <td class="px-4 py-2 border-t border-grey-light font-mono text-xs text-purple-dark whitespace-no-wrap" v-text="tag.ago">
                                        </td>
                                        <td class="px-4 py-2 border-t border-grey-light font-mono text-sm whitespace-no-wrap">
                                                <a v-bind:href="editTag(tag.id)"   class="mb-1 cursor-pointer text-blue no-underline">
                                                        <svg viewBox="0 0 20 20" class="fill-current h-3 w-3 text-blue-light" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                                                <path d="M12.2928932,3.70710678 L0,16 L0,20 L4,20 L16.2928932,7.70710678 L12.2928932,3.70710678 Z M13.7071068,2.29289322 L16,0 L20,4 L17.7071068,6.29289322 L13.7071068,2.29289322 Z" id="Combined-Shape"></path>
						        </svg>
                                                        Edit
                                                </a>
                                                <!-- <button @click="deletetag(tag.id)" class="mb-1 cursor-pointer text-blue no-underline">
                                                         Edit
                                                </button> -->
                                        </td>
                                        
                                </tr>
                        </tbody>
                </table>
                
        </div>

        <p class="text-xs text-right py-4 text-grey-darker">
                @{{ tags.length }} records found
        </p>
        
@endsection

@section('script')

    <script>

        new Vue({ el: 'main', data: {
                        needle: '',
                        tags: @json($tags)
                },

                computed: {

                        filter_tags: function () {
                                return this.tags.filter ( tag => 
                                        tag.name.indexOf(this.needle) != -1 
                                        
                                )
                        }

                },

                methods: {
                        editTag: function (id) { return "/admin/tags/" + id + "/edit" },

                        deleteTag: function (id) {
                                let p = this
                                axios.delete('/admin/tags/' + id)
                                        .then(function (response){
                                                p.removeTagById(response.data.tag_id) 
                                                flash({message: response.data.flash.message})
                                        })
                        },

                        removeTagById: function (tag_id) {
                                for(let i = 0; i < this.tags.length; i++) { 
                                        if ( this.tags[i].id === tag_id ) 
                                                this.tags.splice(i, 1)
                                }
                        }
                }
        })

    </script>

@endsection