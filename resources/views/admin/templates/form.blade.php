@extends('admin.layout')

@section('header')
        
<div class="py-4 px-6">
        
        <h1 class="w-full p-2">
                <span class="text-lg font-semibold text-indigo">
                        Templates /
                </span>
                <span class="text-lg font-semibold text-grey-darker">
                        @if(empty($template->name))
                                <span class="text-grey-dark">Create</span>
                        @else
                                <span class="text-grey-dark">Edit</a>
                        @endif
                </span>
        </h1>        
</div>
@endsection


@section('main')
<div class="px-6">

        <div class="flex border-b">
                <span @click="selectedTab=1" class="no-underline text-grey-dark cursor-pointer hover:bg-white px-4 py-3 mr-2" :class="selectedTab===1?'border-t-2 border-indigo bg-white -mb-1 text-indigo':''">
                        General
                </span>

                @if($template->id != null)
                <span @click="selectedTab=2" class="no-underline text-grey-dark cursor-pointer hover:bg-white px-4 py-3 mr-2" :class="selectedTab===2?'border-t-2 border-indigo bg-white -mb-1 text-indigo':''">
                        Files
                </span>
                @endif

                
        </div>

        <div v-if="selectedTab==1" class="bg-white shadow">
                <div class="max-w-md px-3 py-8">

                        <div class="flex flex-wrap mb-6">
                                <div class="w-full px-3">
                                        <label class="block uppercase tracking-wide text-grey-darker text-xs mb-2" for="name">
                                                Name
                                        </label>
                                        <input v-model="name" name="name" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-grey" id="inName" type="text" placeholder="e.g. KnightKing">
                                        <p class="text-grey-dark text-xs italic">Minimum 5 characters. Must be unique. Only letters, numbers, dashes and underscores are allowed.</p>
                                        @if($errors->has('name'))
                                                <p class="text-red text-xs italic">{{ $errors->first('name') }}</p>
                                        @endif
                                </div>
                        </div>

                        <div class="flex flex-wrap mb-6">
                                <div class="w-full px-3">
                                        <label class="block uppercase tracking-wide text-grey-darker text-xs mb-2" for="description">
                                                Description
                                        </label>
                                        <textarea v-model="description" name="description" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-grey" id="inName" type="text" placeholder="A dark theme template for my new blog"></textarea>
                                        
                                        @if($errors->has('description'))
                                                <p class="text-red text-xs italic">{{ $errors->first('description') }}</p>
                                        @endif
                                </div>
                        </div>
                        
                        <button class="mx-3 bg-indigo text-white px-6 py-2 rounded hover:bg-indigo-dark" @click="confirm">Save</button>
                </div>
        </div>


        @if($template->id != null)
        <div v-if="selectedTab==2" class="bg-white shadow">
                <div class="px-6 pt-1 pb-4">
                        <p class="text-xs uppercase text-indigo mt-4 py-2">Standard Template Files</p>
                        <table class="w-full mt-2 rounded text-left table-collapse">
                                <thead class="text-xs font-semibold text-grey-darker border-b-2">
                                        <tr>
                                                <th class="py-4">Name</th>
                                                <th class="hidden sm:table-cell py-4">File</th>
                                                <th class="py-4"></th>
                                        </tr>
                                </thead>
                                <tbody class="align-baseline text-sm">
                                        <tr class="border-b hover:bg-grey-lightest">
                                                <td class="py-2">Home Page Template</td>
                                                <td class="py-2"><code>/resources/views/templates/home.blade.php</code></td>
                                                <td class="">
                                                        <a href="{{ route('templates.file', [$template->id, 'home']) }}" class="no-underline text-blue" v-if="isBladeFileAvailable('home')">Edit</a>
                                                        <a href="{{ route('templates.file', [$template->id, 'home']) }}" v-else>Create</a>
                                                </td>
                                        </tr>
                                        <tr class="border-b hover:bg-grey-lightest">
                                                <td class="py-2">Category Page Template</td>
                                                <td class="py-2"><code>/resources/views/templates/category.blade.php</code></td>
                                                <td class="">
                                                        <a href="{{ route('templates.file', [$template->id, 'category']) }}" class="no-underline text-blue" v-if="isBladeFileAvailable('category')">Edit</a>
                                                        <a href="{{ route('templates.file', [$template->id, 'category']) }}" v-else>Create</a>
                                                </td>
                                        </tr>
                                        <tr class="border-b hover:bg-grey-lightest">
                                                <td class="py-2">Article Page Template</td>
                                                <td class="py-2"><code>/resources/views/templates/page.blade.php</code></td>
                                                <td class="">
                                                        <a href="{{ route('templates.file', [$template->id, 'page']) }}" class="no-underline text-blue" v-if="isBladeFileAvailable('page')">Edit</a>
                                                        <a href="{{ route('templates.file', [$template->id, 'page']) }}" v-else>Create</a>
                                                </td>
                                        </tr>
                                        <tr class="border-b hover:bg-grey-lightest">
                                                <td class="py-2">User Profile Page Template</td>
                                                <td class="py-2"><code>/resources/views/templates/profile.blade.php</code></td>
                                                <td class="">
                                                        <a href="{{ route('templates.file', [$template->id, 'profile']) }}" class="no-underline text-blue" v-if="isBladeFileAvailable('profile')">Edit</a>
                                                        <a href="{{ route('templates.file', [$template->id, 'profile']) }}" v-else>Create</a>
                                                </td>
                                        </tr>
                                </tbody>
                        </table>

                        <p class="text-xs uppercase text-indigo mt-4 py-2">All Files</p>
                        <table class="w-full mt-2 rounded text-left table-collapse">
                                <thead class="text-xs font-semibold text-grey-darker border-b-2">
                                        <tr>
                                                <th class="py-4">Name</th>
                                                <th class="hidden sm:table-cell py-4">Last Modified</th>
                                                <th class="hidden sm:table-cell py-4">Size (Bytes)</th>
                                        </tr>
                                </thead>
                                <tbody class="align-baseline text-sm">
                                
                                        <tr v-for="file in files" class="border-b hover:bg-grey-lightest">
                                                <td class="py-2" v-text="file.name"></td>
                                                <td class="py-2" v-text="file.updated"></td>
                                                <td class="py-2" v-text="file.size"></td>

                                        </tr>
                                </tbody>
                        </table>
                </div>
        </div>
        @endif
</div>
        
        
@endsection

@section('script')
        

        <script>
                let data = {
                        selectedTab: 1,
                        'id':'{{data_get($template, "id")}}',
                        'name': "{{ old('name', $template->name) }}",
                        'description': "{{ old('description', $template->description) }}",
                        'files': @json($template->getFiles()),
                        resources: []
                }
                new Vue({ el: 'main', 
                        data: data,
                        
                        methods: {

                                /**
                                 * Checks if a blade file of a specific type
                                 * exists in the file list
                                 */
                                isBladeFileAvailable: function (type) {
                                        let l = this.files.length;
                                        for (let i = 0; i < l; i++) {
                                                let file = this.files[i].name
                                                if (file === "views\/templates\/" + this.name + "\/" + type + ".blade.php") {
                                                        return true
                                                }
                                        }
                                        return false
                                },                                
                                

                                /**
                                 * A placeholder function to implement client side form validations
                                 */
                                checkMandatory: function () {
                                        
                                        return true
                                },

                                

                                confirm: function () {
                                        if (this.checkMandatory ()) {

                                                if (this.isNew()) {
                                                        this.createAtServer ()
                                                }
                                                else {
                                                        this.updateAtServer ()
                                                }
                                        }
                                },

                                createAtServer: function () {
                                        
                                        util.submit("{{ route('templates.store') }}", {
                                                'name': this.name, 
                                                'description': this.description
                                        });
                                },

                                updateAtServer: function () {
                                        // let p = this
                                        // util.ajax(
                                        //         'patch', 
                                        //         '/admin/categories/' + this.id,
                                        //         {
                                        //                 'name': this.name, 
                                        //                 'description': this.description, 
                                        //                 'parent_id': this.parent_id
                                        //         },
                                        //         function (data) {
                                        //                 flash({message: data.flash.message}) 
                                        //         },
                                        //         function (code, data) {
                                        //                 p.message = data.message
                                        //                 p.errors = data.hasOwnProperty('errors')? data.errors : {}
                                        //         },
                                        //         function (code, data) {
                                        //                 p.message = data.message
                                        //         }
                                        // );
                                },


                                destroy: function () {
                                        if(confirm('Are you sure to delete this category?')) {
                                                // util.submit('/admin/categories/' + this.id, {}, 'delete');
                                                
                                        }
                                },

                                /**
                                 * Checks if the resource is a new resource (has not been saved in database)
                                 */
                                isNew: function () {
                                        return this.id === ''
                                }
                        }
                })
        </script>

@endsection