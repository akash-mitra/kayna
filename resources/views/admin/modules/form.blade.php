@extends('admin.layout')

@section('header')
        
<div class="py-4 px-6 pb-8">
        
        <h1 class="w-full p-2">
                <span class="text-lg font-semibold text-grey-darker uppercase">
                        @if(empty($module->name))
                                <span class="text-grey-dark">Create New</span>
                        @else
                                <span class="text-grey-dark">Edit Module</span>
                        @endif
                </span>
        </h1>

        <h3 class="px-2 text-sm font-light text-grey-dark">
                Modules are small snippet of programmatic code that you can place in a position of your template
        </h3>

</div>
@endsection


@section('main')
        

<form action="{{ route('modules.store') }}" method="POST" id="frm">
        <div class="w-full md:w-4/5 lg:w-3/5  p-6 bg-white shadow bordesr rounded-lg">
                @csrf
                <div class="flex flex-wrap -mx-3 mb-4">
                        <div class="w-full px-3">
                                <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="name">
                                        Name
                                </label>
                                <input v-model="name" name="name" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-grey" id="inName" type="text" placeholder="e.g. My Custom Logo">
                                <p class="text-grey-dark text-xs italic">Provide a unique name</p>

                                <!-- <p vfor="e in errors.name" vtext="e" class="text-sm text-red py-1"><p> -->
                        </div>
                </div>

                <div class="flex flex-wrap -mx-3 mb-2">
                        <div class="w-full px-3">
                                <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="type">
                                        Select a Module Type
                                </label>

                                <div class="relative">
                                        <select v-model="type" name="type" class="appearance-none block w-full bg-grey-lighter text-gr1ey-darker border border-grey-lighter rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-grey">
                                                <option disabled>Please select one</option>
                                                <option v-for="type in types" :value="type" v-bind:key="type">
                                                        @{{ type }}
                                                </option>
                                        </select>
                                        <div class="pointer-events-none absolute pin-y pin-r flex items-center px-2 text-grey-darker">
                                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                        </div>
                                </div>
                        </div>
                </div>   
                
                <div class="flex flex-wrap -mx-3">
                        <div class="w-full px-3">
                                <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="position">
                                        Position
                                </label>
                                <input v-model="position" name="position" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-grey" id="inName" type="text" placeholder="e.g. right-aside">
                                <p class="text-grey-dark text-xs italic">Position names can not contain spaces. Position must exist in template for this module to show up.</p>
                        </div>
                </div>
        </div>

</form>

<div class="mt-4 w-full md:w-4/5 lg:w-3/5  p-6 bg-white shadow bordesr rounded-lg">
        <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full px-3">
                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-password">
                                Template 
                        </label>
                        
                        <div id="editor" 
                                class="appearance-none block w-full h-64  border border-grey-lighter rounded py-3 px-4 mb-3 leading-tight focus:outline-none"
                                >{{ data_get($module, 'code') }}</div>
                        <p class="text-grey-dark text-xs italic">Refer to our API documentation for details.</p>
                </div>
        </div>
</div>

<div class="mt-4 flex items-center">
        <button class="border border-teal px-8 py-2 rounded text-sm bg-teal text-white shadow" id="btnSave">
                Save                                
        </button>
</div>
<p>&nbsp;</p>

        

        
        
@endsection

@section('script')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.1/ace.js"></script>

        <script>
                var editor = ace.edit("editor");
                editor.setTheme("ace/theme/monokai");
                editor.session.setMode("ace/mode/php");

                let data = {
                        id:'{{data_get($module, "id")}}',
                        name: '{{data_get($module, "name")}}',
                        type: '{{data_get($module, "type")}}',
                        position: '{{data_get($module, "position")}}',
                        type: '{{data_get($module, "type")}}',
                        // active: '{{data_get($module, "active")}}',
                        active: 'Y',
                        
                        types: @json($types),

                        errors: {
                                name: [], 
                                type: [],
                                position: []
                        }
                };

                
                
                let confirm = function () {
                        
                        if (checkClientSideErrors ()) {

                                if (data.id === '') {
                                        createAtServer ()
                                }
                                else {
                                        updateAtServer ()
                                }
                        }
                },

                checkClientSideErrors = function () {
                        let result = true

                        // It has any kind of whitespace
                        if (/\s/.test(data.name)) {
                                result = false
                                data.errors.name.push ("Module name can not contain space")
                                alert(data.errors.name[0])
                        }
                        
                        return result
                },

                

                createAtServer = function () {
                        
                        
                        axios.post('{{ route("modules.store") }}', {
                                'name': data.name, 'type': data.type, 'position': data.position, 
                                'exceptions': data.exceptions, 'applicables': data.applicables, 
                                'code': editor.getSession().getValue(), 'active': data.active
                        })
                        .then (function (response) {
                                
                                data.id = response.data.module_id
                                flash({message: response.data.flash.message})
                        })
                },

                updateAtServer = function () {
                        axios.patch( '/admin/modules/' + data.id, {
                                'name': data.name, 'type': data.type, 'position': data.position, 
                                'exceptions': data.exceptions, 'applicables': data.applicables, 
                                'code': editor.getSession().getValue(), 'active': data.active
                        }).then (function (response) {
                                
                                flash({message: response.data.flash.message})
                        });
                };

                document.getElementById('btnSave').addEventListener("click", confirm);

                new Vue({ el: '#frm', 
                        data: data,
                        computed: {},
                        mounted() {
                                //editor.getSession().setValue(this.code)
                        },
                        methods: {
                                
                        }
                })
        </script>

@endsection