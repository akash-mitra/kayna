@extends('admin.layout')
@section('header')
<div class="py-4 px-6">
    <h1 class="w-full p-2">
        <span class="text-lg font-semibold text-indigo uppercase">
            Access
        </span>
    </h1>

    <h3 class="p-2 text-sm font-light text-indigo-darker">
        Limit the access of a category or a page to a specific group of users ONLY.
    </h3>
</div>
@endsection


@section('main')

<div class="px-6 py-4 bg-grey-lightest">

    <div class="px-2 w-full my-2 text-xs">
        <p class="uppercase text-indigo-darker"> Add a New Rule</p>
        <p class="py-2 text-xs text-grey-dark">Search a category or page to apply new rule</p>
    </div>


    <div class="w-full mb-4">
        <input type="text" class="w-2/3 md:w-1/2 py-2 px-4 text-sm bg-white border-grey-lighter rounded border shadow" v-model="search_string" placeholder="Search a category or page to apply new rule" @keypress="instantSearch" />
        <span class="p-3 ml-1 text-blue text-xs cursor-pointer" @click="search">Search</span>
    </div>


    <table v-show="search_string.length > 0" class="w-full text-left table-collapse border-y bg-white shadow rounded mb-2">
        <thead class="uppercase text-xs font-semibold text-grey-darker border-b-2">
            <tr>
                <th class="p-4">Contents</th>
                <th class="p-4 bg-grey-lighters hidden sm:table-cell">Limit Access to</th>
                <th class="p-4 hidden sm:table-cell">Action</th>
            </tr>
        </thead>
        <tbody class="align-baseline" v-show="search_string.length > 0">
            
            <tr v-for="result in search_results" class="hover:bg-yellow-lightest flex sm:table-row flex-col border-b-2 sm:border-none">
                <td class="px-4 py-4 text-sm sm:border-t sm:border-b border-grey-light align-middle">
                    <span v-text="result.content_title"></span>
                </td>
                <td class="px-4 py-1 bg-grey-lightest text-sm sm:border-t sm:border-grey-light align-middle">
                    <div class="relative">
                        <select v-model="result.user_type" @change="result.save_state = 'Save'" class="appearance-none block w-full text-sm text-blue bg-grey-lightest rounded py-2 leading-tight cursor-pointer focus:outline-none">
                            <option value="Admin">Admin</option>
                            <option value="Editor">Editor</option>
                            <option value="Author">Author</option>
                            <option value="Registered">Registered</option>
                            <option value="None">None</option>
                        </select>
                        <div class="pointer-events-none absolute pin-y pin-r flex items-center px-2 text-grey-darker">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" /></svg>
                        </div>
                    </div>
                </td>
                <td class="px-4 py-2 sm:border-t sm:border-grey-light align-middle">
                    <div v-show="result.save_state !== 'saved'" @click="lock(result)" class="cursor-pointer rounded p-2 bg-teal text-center text-sm text-white hover:bg-teal-dark">
                        <span v-text="result.save_state"></span>
                    </div>
                </td>
            </tr>

        </tbody>
    </table>

    <p v-show="server_message.length > 0" v-text="server_message" class="text-xs text-right py-4 text-grey-darker"></p>

</div>


<div class="w-full px-6 mt-4">
    <div class="px-2 w-full my-2 text-xs">
        <p class="uppercase text-indigo-darker">Existing Rules</p>
        <p class="py-2 text-xs text-grey-dark">Current restrictions in pages and categories</p>
    </div>
    <table class="w-full bg-white shadow rounded text-left table-collapse">
        <thead class="uppercase text-xs font-semibold text-grey-darker border-b-2">
            <tr>
                <th class="p-4 text-right hidden sm:table-cell">Type</th>
                <th class="p-4">Content</th>
                <th class="p-4 hidden sm:table-cell">Access Limited To</th>
                <th class="p-4 hidden sm:table-cell">Action</th>
            </tr>
        </thead>
        <tbody class="align-baseline">
            <tr v-for="access in accesses" class="flex sm:table-row flex-col border-b-2 sm:border-none">
                <td class=" hidden sm:table-cell py-4 px-2 border-t border-grey-light text-right align-middle">
                    <span v-text="access.content_type" class="whitespace-no-wrap text-purple rounded text-xs py-1 px-2 bg-purple-lightest"></span>
                </td>
                <td class="p-4 border-t border-grey-light align-middle">
                    <span v-text="access.content_title" class="text-sm text-grey-darkest"></span>

                    <a :href="access.url" class="text-xs text-blue no-underline"> (View)</span>
                </td>
                <td class="p-4 sm:border-t sm:border-grey-light sm:bg-grey-lighter align-middle">
                    <span v-text="access.user_type" class="font-mono text-xs text-white whitespace-no-wrap py-1 px-2 rounded bg-grey-dark"></span>
                </td>
                <td class="p-4 sm:border-t border-grey-light text-center align-middle">
                    <div @click="unlock(access)" class="flex items-center no-underline cursor-pointer text-blue text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="hi hi-xl">
                            <path class="heroicon-ui" d="M9 10h10a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-8c0-1.1.9-2 2-2h2V7a5 5 0 1 1 10 0 1 1 0 0 1-2 0 3 3 0 0 0-6 0v3zm-4 2v8h14v-8H5zm7 2a1 1 0 0 1 1 1v2a1 1 0 0 1-2 0v-2a1 1 0 0 1 1-1z" />
                        </svg>
                        <span class="ml-2">Remove</span>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

</div>

<p class="px-6 text-xs text-right py-4 text-grey-darker">
    @{{ accesses.length }} records found
</p>

@endsection

@section('script')

<script>
    new Vue({
        el: 'main',
        data: {
            needle: '',
            accesses: @json($accesses),
            search_string: '',
            search_results: [],
            //new_content_type: 'category',
            //new_content_title: '',
            //new_content_id: null,
            // new_user_type: 'general',
            server_message: ''
        },

        methods: {

            instantSearch: function(event) {
                if (typeof event.which != 'undefined' && event.which === 0) return;
                if (this.search_string.length <= 3) return;
                return this.search();
            },

            search: function() {

                if (this.search_string.length === 0) return false;
                this.server_message = "Searching ..."
                let p = this
                axios.post('/api/search', {
                    find: this.search_string

                }).then(function(response) {

                    p.server_message = "Found " + response.data.length + " search results"
                    p.search_results = response.data.map(function(item) {

                        let found = p.accesses.find(function(ele) {
                            return ele.content_type === item.content_type && ele.content_id === item.content_id
                        });

                        if (typeof found != 'undefined') {
                            item["user_type"] = found.user_type
                        } else {
                            item["user_type"] = 'None'
                        }
                        item["save_state"] = 'saved'
                        return item
                    })

                }).catch(error => {
                    p.server_message = "Error: " + error.response.statusText
                })

            },

            unlock: function(item) {
                item.user_type = 'None';
                this.lock(item)
            },

            lock: function(restriction) {

                let p = this;
                restriction.save_state = 'Saving...'
                axios.post('/admin/accesses/store', restriction)
                    .then(function(response) {
                        flash({
                            message: response.data.flash.message
                        })
                        restriction.content_id = response.data.content_id
                        restriction.save_state = 'saved'
                        restriction.url = (restriction.content_type === 'Page' ? '/pages/' : '/categories/') + restriction.content_id
                        // find the element
                        // if exists remove it
                        p.accesses = p.accesses.filter(function(element) {
                            console.log(element.content_type, restriction.content_type, element.content_id, restriction.content_id)
                            if (element.content_type === restriction.content_type && element.content_id === restriction.content_id) {
                                return false
                            }
                            return true
                        })
                        // re-insert if user type not None
                        if (restriction.user_type != 'None') {
                            p.accesses.push(restriction)
                        }
                    })
                    .catch(function(error) {
                        p.server_message = "Error: " + error.response.statusText
                    });
            },


            deleteAccess: function(id) {
                let p = this
                axios.delete('/admin/accesses/' + id)
                    .then(function(response) {
                        p.removeAccessById(response.data.access_id)
                        flash({
                            message: response.data.flash.message
                        })
                    })
            },

            removeAccessById: function(access_id) {
                for (let i = 0; i < this.accesses.length; i++) {
                    if (this.accesses[i].id === access_id)
                        this.accesses.splice(i, 1)
                }
            }
        }
    })
</script>

@endsection 