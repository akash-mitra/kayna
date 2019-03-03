@extends('admin.layout')

@section('header')
<div class="py-4 px-6">
        <h1 class="w-full p-2">
                <span class="text-lg font-semibold text-indigo uppercase">
                        Modules
                </span>
                <span class="px-2 text-sm font-light text-grey-dark">
                        &mdash; Create or Edit Module
                </span>
        </h1>
</div>        
@endsection


@section('main')
        
        <div class="w-full flex uppercase text-sm font-bold">
                <span :class="active_tab!=1? 'cursor-pointer text-grey-dark':'text-indigo-dark bg-white border-t-4 border-indigo'" class="py-2 px-8"  @click="select('custom', $event)">Custom</span>
                <span :class="active_tab!=2? 'cursor-pointer text-grey-dark':'text-indigo-dark bg-white border-t-4 border-indigo'" class="py-2 px-8"  @click="select('system', $event)">Pre-built</span>
        </div>

        <div v-show="active_tab===1" class="w-full text-sm bg-white">

                <div class="px-4 pt-6 flex justify-between">
                        <input type="text" v-model="needle" id="txtSearch" class="p-3 w-1/3 text-sm bg-grey-lightest rounaded-lg border" placeholder="Search Module Name">
                        <a href="{{ route('modules.create') }}" id="btnNew" class="border border-teal px-3 py-3 rowunded text-sm bg-teal no-underline hover:bg-orange hover:border-orange text-white shadow">
                                New Module
                        </a>
                </div>
                <div class="w-full mt-6 bg-white shadow">
                        <table class="w-full text-left table-collapse">
                                <thead class="uppercase text-xs font-semibold text-grey-darker border-t border-b-2">
                                        <tr>
                                                <th class="p-4">Name</th>
                                                <th class="p-4">Position</th>
                                                <th class="p-4">File</th>
                                                <th class="p-4"></th>
                                        </tr>
                                </thead>
                                <tbody class="align-baseline">
                                        <tr v-for="module in filter_modules">
                                                
                                                <td class="px-4 py-2 border-t border-grey-light font-mono text-xs text-puqrple-dark whitespace-no-wrap">
                                                        <a v-bind:href="module.url" class="no-underline text-sm font-medium text-blue">
                                                                @{{ module.name }}
                                                        </a>
                                                </td>
                                                <td class="px-4 py-2 border-t border-grey-light font-mono text-xs text-purple-dark whitespace-no-wrap">
                                                        @{{ module.position }}
                                                </td>
                                                <td class="px-4 py-2 border-t border-grey-light font-mono text-xs text-grey-dark whitespace-no-wrap">
                                                        @{{ module.file }}
                                                </td>
                                                
                                                </td>
                                                <td class="px-4 py-2 border-t border-grey-light font-mono text-sm whitespace-no-wrap flex justify-around">
                                                        <a v-bind:href="editModule(module.id)"   class="mb-1 cursor-pointer text-blue no-underline">
                                                                <svg viewBox="0 0 24 24"  class="heroicon h-6 w-6 fill-current text-blue-light" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                                                        <path d="M6.3 12.3l10-10a1 1 0 0 1 1.4 0l4 4a1 1 0 0 1 0 1.4l-10 10a1 1 0 0 1-.7.3H7a1 1 0 0 1-1-1v-4a1 1 0 0 1 .3-.7zM8 16h2.59l9-9L17 4.41l-9 9V16zm10-2a1 1 0 0 1 2 0v6a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6c0-1.1.9-2 2-2h6a1 1 0 0 1 0 2H4v14h14v-6z"></path>
                                                                </svg>
                                                                Edit
                                                        </a>
                                                        
                                                        <button @click="deleteModule(module.id)"   class="mb-1 cursor-pointer text-blue no-underline">
                                                                <svg viewBox="0 0 24 24"  class="heroicon h-6 w-6 fill-current text-blue-light" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                                                        <path d="M8 6V4c0-1.1.9-2 2-2h4a2 2 0 0 1 2 2v2h5a1 1 0 0 1 0 2h-1v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V8H3a1 1 0 1 1 0-2h5zM6 8v12h12V8H6zm8-2V4h-4v2h4zm-4 4a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0v-6a1 1 0 0 1 1-1zm4 0a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0v-6a1 1 0 0 1 1-1z"></path>
                                                                </svg>
                                                                Delete
                                                        </button>
                                                </td>
                                                
                                        </tr>
                                </tbody>
                        </table>

        
                </div>
        </div>

        <div v-show="active_tab===2" class="w-full flex flex-wrap text-sm py-4 bg-white">

                <table class="w-full text-left table-collapse">
                        <thead class="uppercase text-xs font-semibold text-grey-darker border-t border-b-2">
                                <tr>
                                        <th class="p-4">Module</th>
                                        <th class="p-4">Position</th>
                                        <th class="p-4">Action</th>
                                </tr>
                        </thead>
                        <tbody class="align-baseline">
                                <tr>
                                        <td class="p-4 border-t border-grey-light">
                                                <h3 class="text-xl text-grey-dark font-medium pb-2">Page Comment</h3>
                                                <p class="text-grey-darkest pb-2">When you enable this module, authenticated visitors of your blog will be able to make comments on your posts</p>
                                        </td>
                                        <td class="px-4 py-2 border-t border-grey-light font-mono text-xs text-purple-dark whitespace-no-wrap">
                                                <button class="text-xs text-blue" type="button">Set Position</button>
                                        </td>
                                        <td class="px-4 py-2 border-t border-grey-light font-mono text-xs">
                                                <div class="block flex flex-no-wrap bg-grey-lighter rounded-lg cursor-pointer border">
                                                        <span class="p-2 bg-green-light rounded-full"></span>
                                                        <span class="p-2 bg-transparent"></span>    
                                                </div>
                                        </td>
                                </tr>
                        </tbody>
                </table>

                <div class="w-full p-4 1bg-blue-lightest">
                        
                </div>
        </div>
        
@endsection

@section('script')

    <script>

        new Vue({ el: 'main', data: {
                        active_tab: 2,
                        tabs: ['custom', 'system'],
                        needle: '',
                        modules: @json($modules)
                },

                computed: {

                        filter_modules: function () {
                                return this.modules.filter ( module => 
                                        module.name.indexOf(this.needle) != -1 
                                        
                                )
                        }

                },

                methods: {

                        /**
                         * For changing the tab
                         */
                        select: function (choice, event) {
                                this.active_tab = this.tabs.indexOf(choice) + 1
                        },

                        editModule: function (id) { return "/admin/modules/" + id + "/edit" },

                        deleteModule: function (id) {
                                let p = this
                                axios.delete('/admin/modules/' + id)
                                        .then(function (response){
                                                p.removeModuleById(response.data.module_id) 
                                                flash({message: response.data.flash.message})
                                        })
                        },

                        removeModuleById: function (module_id) {
                                for(let i = 0; i < this.modules.length; i++) { 
                                        if ( this.modules[i].id === module_id ) 
                                                this.modules.splice(i, 1)
                                }
                        }
                }
        })

    </script>

@endsection