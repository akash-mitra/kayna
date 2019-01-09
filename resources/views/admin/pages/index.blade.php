@extends('admin.layout')

@section('header')
<div class="py-4 px-6">
        <h1 class="w-full p-2">
                <span class="text-lg font-semibold text-grey-darker uppercase borqder-b">
                        Pages
                </span>
        </h1>

        <h3 class="px-2 text-sm font-light text-grey-dark">
                Create or Edit Pages
        </h3>
</div>
@endsection


@section('main')
        
        <div class="pt-4 flex justify-between">
                
                <input type="text" v-model="needle" id="txtSearch" class="p-3 w-1/3 text-sm bg-white border-grey-lighter rounded-lg border shadow" placeholder="Search title, author, category etc...">
                
                <a href="{{ route('pages.create') }}" id="btnNew" class="border border-teal px-3 py-3 rounded text-sm bg-teal no-underline hover:bg-orange hover:border-orange text-white shadow">
                        Add New Page
                </a>

        </div>

        <div class="w-full mt-8 bg-white shadow">
                <table class="w-full text-left table-collapse">
                        <thead class="uppercase text-xs font-semibold text-grey-darker border-b-2">
                                <tr>
                                        <th class="p-4">Actions</th>
                                        <th class="p-4">Page</th>
                                        <th class="p-4">Stats</th>
                                </tr>
                        </thead>
                        <tbody class="align-baseline">
                                <tr v-for="page in filter_pages" 
                                    class="border-b border-blue-lightest">
                                        <td class="px-4 py-2 font-mono text-xs whitespace-no-wrap flex flex-col items-end">
                                                <a v-bind:href="editPage(page.id)"   class="mb-4 cursor-pointer text-blue no-underline">Edit</a>
                                                <button @click="deletePage(page.id)" class="mb-4 cursor-pointer text-blue no-underline">Delete</button>
                                        </td>
                                        <td class="py-2 px-4 max-w-xs bg-white text-sm">
                                                <a v-bind:href="page.url" class="no-underline text-blue text-sm font-medium">
                                                        <span v-text="page.title"></span>
                                                </a>
                                                <p class="py-2 text-sm" v-text="page.summary"></p>
                                                <div class="py-2 flex text-grey-dark italic">
                                                        <div>
                                                                Created by 
                                                                <a v-bind:href="page.author.url" class="no-underline text-blue-light">
                                                                        <span class="" v-text="page.author.name"></span>
                                                                </a>
                                                        </div>
                                                        <div>
                                                                , Updated: <span class="" v-text="page.ago"></span>.
                                                        </div>
                                                </div>
                                        </td>
                                        <td class="flex p-4 text-sm">
                                                <div class="italic text-grey-dark">
                                                        <span class="font-medium text-blue font-mono" v-text="page.title.length"></span> Comments
                                                </div>
                                        </td>
                                        
                                </tr>
                        </tbody>
                </table>
                
        </div>

        <p class="text-xs text-right py-4 text-grey-darker">
                {{ count($pages) }} records found
        </p>
        
@endsection

@section('script')

    <script>

        new Vue({ el: 'main', data: {
                        needle: '',
                        pages: @json($pages)
                },

                computed: {

                        filter_pages: function () {
                                return this.pages.filter ( page => 
                                        page.title.indexOf(this.needle) != -1 
                                        || page.author.name.indexOf(this.needle) != -1 
                                )
                        }

                },

                methods: {
                        editPage: function (id) { return "/admin/pages/" + id + "/edit" },

                        deletePage: function (id) {
                                let p = this
                                axios.delete('/admin/pages/' + id)
                                        .then(function (response){
                                                p.removePageById(response.data.page_id) 
                                        })
                        },

                        removePageById: function (page_id) {
                                for(let i = 0; i < this.pages.length; i++) { 
                                        if ( this.pages[i].id === page_id ) 
                                                this.pages.splice(i, 1)
                                }
                        }
                }
        })

    </script>

@endsection