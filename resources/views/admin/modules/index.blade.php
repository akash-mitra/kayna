@extends('admin.layout')

@section('header')
<div class="py-4 px-6">
    <h1 class="w-full p-2">
        <span class="text-lg font-semibold text-indigo uppercase">
            Modules
        </span>
    </h1>

    <h3 class="px-2 text-sm font-light text-indigo-darker">
        Create or Edit Module
    </h3>
</div>
@endsection


@section('main')

<div class="px-6 py-4">

    <div class="w-full flex uppercase text-sm font-bold">
        <span :class="active_tab!=1? 'cursor-pointer text-grey-dark':'text-indigo-dark bg-white border-t-2 border-indigo'" class="py-4 px-8" @click="select('custom', $event)">Custom</span>
        <span :class="active_tab!=2? 'cursor-pointer text-grey-dark':'text-indigo-dark bg-white border-t-2 border-indigo'" class="py-4 px-8" @click="select('system', $event)">Pre-built</span>
    </div>

    <div v-show="active_tab===1" class="w-full text-sm bg-white">

        <div class="px-4 pt-6 flex justify-between">
            <input type="text" v-model="needle" id="txtSearch" class="p-3 w-2/3 lg:w-1/2 text-sm bg-grey-lighter border rounded" placeholder="Search Module Name">
            <a href="{{ route('modules.create') }}" id="btnNew" class="border border-teal p-3 rounded text-sm bg-teal no-underline hover:bg-orange hover:border-orange text-white shadow">
                + Module
            </a>
        </div>
        <div class="w-full mt-6 shadow px-4 ">
            <table class="w-full text-left table-collapse bg-white rounded">
                <thead class="uppercase text-xs font-semibold text-grey-darker border-t border-b-2">
                    <tr>
                        <th class="p-4">Name</th>
                        <th class="p-4">Position</th>
                        <th class="p-4 hidden lg:table-cell">File</th>
                        <th class="p-4"></th>
                    </tr>
                </thead>
                <tbody class="align-baseline">
                    <tr v-for="module in filter_modules" class="border-b border-dotted">

                        <td class="px-4 py-2 font-mono text-xs text-puqrple-dark whitespace-no-wrap">
                            <a v-bind:href="module.url" class="no-underline text-sm font-medium text-blue">
                                @{{ module.name }}
                            </a>
                        </td>
                        <td class="px-4 py-2 font-mono text-xs text-purple-dark whitespace-no-wrap">
                            @{{ module.position }}
                        </td>
                        <td class="hidden lg:table-cell px-4 py-2 font-mono text-xs text-grey-dark whitespace-no-wrap">
                            @{{ module.file }}
                        </td>

                        </td>
                        <td class="px-4 py-2 font-mono text-sm whitespace-no-wrap flex justify-around">
                            <a v-bind:href="editModule(module.id)" class="flex items-center mb-1 cursor-pointer text-blue no-underline">
                                <svg viewBox="0 0 24 24" class="heroicon h-6 w-6 fill-current text-blue-light" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <path d="M6.3 12.3l10-10a1 1 0 0 1 1.4 0l4 4a1 1 0 0 1 0 1.4l-10 10a1 1 0 0 1-.7.3H7a1 1 0 0 1-1-1v-4a1 1 0 0 1 .3-.7zM8 16h2.59l9-9L17 4.41l-9 9V16zm10-2a1 1 0 0 1 2 0v6a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6c0-1.1.9-2 2-2h6a1 1 0 0 1 0 2H4v14h14v-6z"></path>
                                </svg>
                                <span class="hidden sm:block mt-4 ml-2">Edit</span>
                            </a>

                            <button @click="deleteModule(module.id)" class="flex items-center mb-1 cursor-pointer text-blue no-underline">
                                <svg viewBox="0 0 24 24" class="heroicon h-6 w-6 fill-current text-blue-light" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <path d="M8 6V4c0-1.1.9-2 2-2h4a2 2 0 0 1 2 2v2h5a1 1 0 0 1 0 2h-1v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V8H3a1 1 0 1 1 0-2h5zM6 8v12h12V8H6zm8-2V4h-4v2h4zm-4 4a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0v-6a1 1 0 0 1 1-1zm4 0a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0v-6a1 1 0 0 1 1-1z"></path>
                                </svg>
                                <span class="hidden sm:block  mt-4 ml-2">Delete</span>
                            </button>
                        </td>

                    </tr>
                </tbody>
            </table>

            <p class="h-8">&nbsp;</p>
        </div>
    </div>

    <div v-show="active_tab===2" class="w-full flex flex-wrap text-sm p-4 bg-white">

        <table class="w-full text-left table-collapse">
            <thead class="uppercase text-xs font-semibold text-grey-darker border-b-2">
                <tr class="hidden sm:table-row">
                    <th class="p-4">Module</th>
                    <th class="p-4">Position</th>
                    <th class="p-4">Enable</th>
                </tr>
            </thead>
            <tbody class="align-baseline">
                <tr class="align-top flex sm:table-row flex-col">
                    <td class="flex items-center justify-center flex-wrap sm:flex-no-wrap">
                        <img src="/png/undraw_comment.svg" class="w-24 h-24 mr-4" />
                        <div class="text-center sm:text-left">
                            <h3 class="text-indigo-dark font-light pb-2">Commenting System</h3>
                            <p class="text-xs text-indigo-darker max-w-sm">When you enable this module, authenticated visitors will be able to make comments on your posts</p>
                        </div>
                    </td>
                    <td class="p-4 font-mono text-xs text-purple-dark">
                        <input v-model="comment_module.position" class="w-full px-2 py-2 bg-grey-lightest rounded border" placeholder="Template Position" />
                    </td>
                    <td class="p-4 font-mono text-xs flex sm:table-cell items-center align-top">
                        <span class="sm:hidden mr-2">Tap here Enable or Disable</span>
                        <div class="w-12 flex justify-between flex-no-wrap rounded-lg cursor-pointer border" :class="comment_module.active==='Y'? 'bg-green-lightest border-green': 'bg-grey-lightest border-grey'" @click="enableComment">
                            <span class="p-2 rounded-full" :class="comment_module.active==='Y'? 'bg-transparent': 'bg-grey'"></span>
                            <span class="p-2 rounded-full" :class="comment_module.active==='Y'? 'bg-green': 'bg-transparent'"></span>
                        </div>

                    </td>
                </tr>
            </tbody>
        </table>

    </div>
</div>
@endsection

@section('script')

<script>
    new Vue({
        el: 'main',
        data: {
            active_tab: 1,
            tabs: ['custom', 'system'],
            needle: '',
            modules: @json($modules)
        },

        computed: {

            filter_modules: function() {
                return this.modules.filter(module =>
                    module.name.indexOf(this.needle) != -1
                )
            },

            comment_module: function() {
                return this.modules.filter(module => module.type === 'comment')[0]
            },
        },

        methods: {

            /**
             * For changing the tab
             */
            select: function(choice, event) {
                this.active_tab = this.tabs.indexOf(choice) + 1
            },

            editModule: function(id) {
                return "/admin/modules/" + id + "/edit"
            },

            deleteModule: function(id) {
                let p = this
                axios.delete('/admin/modules/' + id)
                    .then(function(response) {
                        p.removeModuleById(response.data.module_id)
                        flash({
                            message: response.data.flash.message
                        })
                    })
            },

            removeModuleById: function(module_id) {
                for (let i = 0; i < this.modules.length; i++) {
                    if (this.modules[i].id === module_id)
                        this.modules.splice(i, 1)
                }
            },

            enableComment: function() {

                if (this.comment_module.position === null) {
                    return alert("Set comment position first")
                }

                let p = this
                this.comment_module.active = (this.comment_module.active === 'Y' ? 'N' : 'Y')

                if (this.comment_module.id === null) {
                    axios.post('{{route("modules.store")}}', this.comment_module).then(function(response) {
                        flash({
                            message: response.data.flash.message
                        })
                        p.comment_module.id = response.data.module_id
                    })
                } else {
                    axios.patch('/admin/modules/' + this.comment_module.id, this.comment_module).then(function(response) {
                        flash({
                            message: response.data.flash.message
                        })
                        p.comment_module.id = response.data.module_id
                    })
                }

            }
        }
    })
</script>

@endsection 