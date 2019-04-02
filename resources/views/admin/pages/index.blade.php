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
    <table class="w-full bg-white shadow rounded text-left table-collapse">
        <thead class="uppercase text-xs font-semibold text-grey-darker border-b-2">
            <tr>
                <th class="p-4 hidden sm:table-cell">Actions</th>
                <th class="p-4">Page</th>
                <th class="p-4 hidden sm:table-cell">Stats</th>
            </tr>
        </thead>
        <tbody class="align-baseline">
            <tr v-for="page in filter_pages" :class="page.status != 'Live' ? 'bg-grey-lightest': 'shadow-inner'" class="flex sm:table-row flex-col-reverse sm:flex-row">
                <td class="px-4 py-2 font-mono text-xs whitespace-no-wrap flex sm:flex-col items-end border-b-2 sm:border-none bg-grey-lightest sm:bg-transparent">
                    <a v-bind:href="page.url" target="_blank" class="p-2 cursor-pointer text-indigo-dark no-underline hover:text-blue">View</a>

                    <button @click="changeStatus(page.id, (page.status != 'Live'? 'Live' : 'Draft'))" v-text="page.status != 'Live'? 'Publish' : 'Take Down'" class="p-2 cursor-pointer text-indigo-dark no-underline hover:text-blue"></button>

                    <button @click="deletePage(page.id)" class="p-2 cursor-pointer text-indigo-dark no-underline hover:text-blue">Delete</button>
                </td>
                <td class="py-2 px-4 max-w-sm text-sm">

                    <p v-text="page.category.name + ' / '" class="text-grey text-sm mb-2"></p>

                    <div class="bg-grey-lightest p-4 rounded-lg">
                        <a v-bind:href="editPage(page.id)" class="no-underline text-blue text-sm font-medium">
                            <span v-text="page.title"></span>
                        </a>
                        <p class="py-2 text-sm" v-text="page.summary"></p>
                    </div>
                    <div class="my-2 flex text-grey-dark italic justify-between items-center">
                        <div class="flex items-center">
                            <a :href="page.author.url" class="no-underline">
                                <img v-if="page.author.avatar" v-bind:src="page.author.avatar" class="w-6 h-6 rounded-full mr-4">
                                <svg v-if="!page.author.avatar" class="w-6 h-6 rounded-full border mr-4 fill-current text-grey-lighter" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                    <path class="heroicon-ui" d="M12 12a5 5 0 1 1 0-10 5 5 0 0 1 0 10zm0-2a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm9 11a1 1 0 0 1-2 0v-2a3 3 0 0 0-3-3H8a3 3 0 0 0-3 3v2a1 1 0 0 1-2 0v-2a5 5 0 0 1 5-5h8a5 5 0 0 1 5 5v2z" /></svg>
                            </a>

                            <a v-bind:href="page.author.url" class="no-underline text-blue-light">
                                <span class="" v-text="page.author.name"></span>
                            </a>
                        </div>
                        <div class="hidden sm:table-cell">
                            <svg viewBox="0 0 24 24" class="heroicon h-5 w-5 fill-current text-grey" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <path d="M12 22a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm1-8.41l2.54 2.53a1 1 0 0 1-1.42 1.42L11.3 12.7A1 1 0 0 1 11 12V8a1 1 0 0 1 2 0v3.59z"></path>
                            </svg>

                            <span class="" v-text="page.ago"></span>.
                        </div>
                    </div>
                </td>
                <td class="p-4 text-sm hidden sm:table-cell">
                    <div class="italic text-grey-dark">
                        <span class="font-medium text-blue font-mono" v-text="page.comments.length"></span> Comments
                    </div>
                </td>

            </tr>
        </tbody>
    </table>

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
                return this.pages.filter(page =>
                    page.title.indexOf(this.needle) != -1 ||
                    page.author.name.indexOf(this.needle) != -1
                )
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