@extends('admin.layout')

@section('header')
<div class="py-2 px-6 flex items-center">
    <img src="/png/undraw_pages.svg" class="h-24 w-24 mr-4" />
    <div>
        <h1 class="w-full p-2">
            <span class="text-lg font-semibold text-indigo uppercase">
                Pages
            </span>
        </h1>

        <h3 class="px-2 text-sm font-light text-indigo-darker">
            Create or Edit Pages
        </h3>
    </div>

</div>
@endsection


@section('main')

<div class="px-6 py-4 flex justify-between">

    <input type="text" v-model="needle" id="txtSearch" class="p-3 w-2/3 lg:w-1/2 text-sm bg-white border-grey-lighter rounded border shadow" placeholder="Search title, author, category etc...">

    <a href="{{ route('pages.create') }}" id="btnNew" class="border border-teal px-3 py-3 rounded text-sm bg-teal no-underline hover:bg-orange hover:border-orange text-white shadow">
        + New Page
    </a>

</div>

<div class="w-full px-6">
    
    <div v-for="page in filter_pages" :class="page.status != 'Live' ? 'bg-grey-lighter': 'bg-white'" class="my-6 rounded">

        <div class="w-full sm:flex px-6 py-2">
            
                <div class="w-full sm:w-3/4">
                        <a v-bind:href="editPage(page.id)" class="no-underline text-blue text-sm block pt-3">
                            <span v-text="page.title" class="text-sm font-semibold"></span>
                        </a>
                        <p v-text="page.summary" class="pt-4 text-sm text-grey-darkest"></p>
                        <p class="py-2 flex items-center text-xs text-grey-dark">
                            <a :href="page.author.url" class="no-underline">
                                <img v-if="page.author.avatar" v-bind:src="page.author.avatar" class="w-6 h-6 rounded-full mr-4">
                                <svg v-if="!page.author.avatar" class="w-6 h-6 rounded-full border mr-2 fill-current text-grey-lighter" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                    <path class="heroicon-ui" d="M12 12a5 5 0 1 1 0-10 5 5 0 0 1 0 10zm0-2a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm9 11a1 1 0 0 1-2 0v-2a3 3 0 0 0-3-3H8a3 3 0 0 0-3 3v2a1 1 0 0 1-2 0v-2a5 5 0 0 1 5-5h8a5 5 0 0 1 5 5v2z" />
                                </svg>
                            </a>
                            <span>Posted under @{{page.category.name}}, updated @{{page.ago}}</span>
                        </p>

                        <div class="w-full my-2 py-2 text-xs text-orange-dark">
                            <span class="p-1 border rounded border-red-lighter" v-if="page.metadesc === null">No Meta Description</span>
                            <span class="p-1 border rounded border-red-lighter" v-if="page.metakey === null">No Meta Key</span>
                        </div>
                </div>    
                <div class="w-full sm:w-1/4 py-2">
                    
                </div>
        </div>

        <div class="px-6 bg-grey-lightest text-sm py-1 border-b">
                <a v-bind:href="page.url" target="_blank" class="p-2 cursor-pointer text-indigo-darker no-underline hover:text-blue">View</a>
                <button @click="changeStatus(page.id, (page.status != 'Live'? 'Live' : 'Draft'))" v-text="page.status != 'Live'? 'Publish' : 'Take Down'" class="p-2 cursor-pointer text-indigo-darker no-underline hover:text-blue"></button>
                <button @click="deletePage(page.id)" class="p-2 cursor-pointer text-indigo-darker no-underline hover:text-blue">Delete</button>
        </div>
        
    </div> <!-- v-if ends -->
</div>

<div class="px-6 text-xs text-right py-4 text-grey-darker">
    <span v-text="pages.length"></span> records found
</div>

@endsection

@section('script')

<script>
    new Vue({
        el: 'main',
        data: {
            needle: '',
            pages: @json($pages)
        },

        computed: {
            filter_pages: function() {
                return this.pages.filter(page => {
                    let t = page.title.toLowerCase()
                    let a = page.author.name.toLowerCase()
                    return t.indexOf(this.needle.toLowerCase()) != -1 
                            || a.indexOf(this.needle.toLowerCase()) != -1
                })
            }

        },

        methods: {
            editPage: function(id) {
                return "/admin/pages/" + id + "/edit"
            },

            deletePage: function(id) {

                if (confirm("Are you sure that you want to delete this page? \nThis will permanently delete this page. This action is unrecoverable.")) {
                    let p = this
                    axios.delete('/admin/pages/' + id)
                        .then(function(response) {
                            flash({
                                message: response.data.flash.message
                            })
                            p.removePageById(response.data.page_id)
                        })
                }
            },

            changeStatus: function(id, status) {
                let p = this
                axios.post("{{ route('api.pages.setStatus') }}", {
                        page_id: id,
                        status: status
                    })
                    .then(function(response) {
                        flash({
                            message: response.data.flash.message
                        })
                        let page = p.getPageById(response.data.page_id)
                        page.status = status
                    })
            },

            /**
             * Removes a page from the pages list
             */
            removePageById: function(page_id) {
                for (let i = 0; i < this.pages.length; i++) {
                    if (this.pages[i].id === page_id)
                        this.pages.splice(i, 1)
                }
            },

            /**
             * Returns  the page that has the provided id
             */
            getPageById: function(page_id) {
                const l = this.pages.length
                for (let i = 0; i < l; i++) {
                    if (this.pages[i].id === page_id)
                        return this.pages[i]
                }
            }
        }
    })
</script>

@endsection 