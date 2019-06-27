@extends('admin.layout')

@section('header')
        
<div class="py-4 px-6">
        
        <h1 class="w-full p-2">
                <a class="text-lg font-semibold text-indigo no-underline" href="{{ route('templates.index', $template->id) }}">
                        Templates / 
                </a>
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
                        <p class="text-xs uppercase text-indigo mt-4 py-2">Standard Templates</p>
                        <table class="w-full mt-2 rounded text-left table-collapse">
                                <thead class="text-xs font-semibold text-grey-darker border-b-2">
                                        <tr>
                                                <th class="py-4">Name</th>
                                                <th class="py-4">Action</th>
                                        </tr>
                                </thead>
                                <tbody class="align-baseline text-sm">
                                        <tr class="border-b hover:bg-grey-lightest">
                                                <td class="py-2">Home Page Template</td>
                                                <td class="">
                                                        <a href="{{ route('templates.file', [$template->id, 'home']) }}" class="no-underline text-blue" v-if="isBladeFileAvailable('home')">Edit</a>
                                                        <a href="{{ route('templates.file', [$template->id, 'home']) }}" v-else>Create</a>
                                                </td>
                                        </tr>
                                        <tr class="border-b hover:bg-grey-lightest">
                                                <td class="py-2">Category Page Template</td>
                                                <td class="">
                                                        <a href="{{ route('templates.file', [$template->id, 'category']) }}" class="no-underline text-blue" v-if="isBladeFileAvailable('category')">Edit</a>
                                                        <a href="{{ route('templates.file', [$template->id, 'category']) }}" v-else>Create</a>
                                                </td>
                                        </tr>
                                        <tr class="border-b hover:bg-grey-lightest">
                                                <td class="py-2">Article Page Template</td>
                                                <td class="">
                                                        <a href="{{ route('templates.file', [$template->id, 'page']) }}" class="no-underline text-blue" v-if="isBladeFileAvailable('page')">Edit</a>
                                                        <a href="{{ route('templates.file', [$template->id, 'page']) }}" v-else>Create</a>
                                                </td>
                                        </tr>
                                        <tr class="border-b hover:bg-grey-lightest">
                                                <td class="py-2">User Profile Page Template</td>
                                                <td class="">
                                                        <a href="{{ route('templates.file', [$template->id, 'profile']) }}" class="no-underline text-blue" v-if="isBladeFileAvailable('profile')">Edit</a>
                                                        <a href="{{ route('templates.file', [$template->id, 'profile']) }}" v-else>Create</a>
                                                </td>
                                        </tr>
                                </tbody>
                        </table>

                        
                        <p class="text-xs uppercase text-indigo mt-8 py-2">Other Template Files</p>   

                        
                        <table class="w-full mt-2 rounded text-left table-collapse">
                                <thead class="text-xs font-semibold text-grey-darker border-b-2">
                                        <tr>
                                                <th class="py-4">File</th>
                                                <th class="hidden sm:table-cell py-4">Last Modified</th>
                                                <th class="hidden sm:table-cell py-4">Size (Bytes)</th>
                                                <th class="py-4">Action</th>
                                        </tr>
                                </thead>
                                <tbody class="align-baseline text-sm">
                                
                                        <tr v-for="file in nonStandardFiles" class="border-b hover:bg-grey-lightest">
                                                <td class="py-2 font-mono" v-text="file.name"></td>
                                                <td class="py-2" v-text="file.updated"></td>
                                                <td class="py-2" v-text="file.size"></td>
                                                <td class="py-2 cursor-pointer text-blue" @click="editFile(file.name)">Edit</td>
                                        </tr>
                                </tbody>
                        </table>

                        <p class="text-xs uppercase text-blue mt-8 py-2 hover:font-bold cursor-pointer" @click="showGetNameModal=true">+ Add Other File</p>   

                </div>
        </div>

        @if(! $template->isActive())
        <div class="w-full py-4 text-right">
                <form method="post" action="{{ route('template.destroy', $template->id) }}">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button class="text-sm text-grey-darker hover:text-red" type="submit">Delete this template</button>
                </form>
        </div>
        @endif

        <base-modal :show="showGetNameModal" cover="1/2" @close="showGetNameModal=null">
                <h4 slot="header" class="w-full text-blue-dark font-semibold bg-grey-lightest border-blue-lighter border-b py-4 px-8">
                        What is the name of the file?
                </h4>
                <div class="w-full bg-grey-lighter py-4 px-8">
                        <input type="text" v-model="newFileName" class="p-2 border rounded bg-white w-full" placeholder="e.g. main.css or main.js">
                        <P class="text-grey-darker py-2 text-xs">Only letters, numbers, dots, dashes and underscores are allowed in file name.</p>
                        <button class="my-4 p-2 bg-green text-white rounded" @click="addNewFile">Create New File</button>
                </div>        
        </base-modal>

        @endif
</div>
        
        
@endsection

@section('script')
        

        <script>
                let data = {
                        @if($template->id != null)
                        selectedTab: 2,
                        @else
                        selectedTab: 1,
                        @endif
                        id:'{{data_get($template, "id")}}',
                        name: "{{ old('name', $template->name) }}",
                        description: "{{ old('description', $template->description) }}",
                        files: @json($template->getFiles()),
                        resources: [],
                        standardTemplateFiles: [
                                "home.blade.php",
                                "category.blade.php",
                                "profile.blade.php",
                                "page.blade.php",
                        ],
                        showGetNameModal: null,
                        newFileName: '',
                };

                new Vue({ 
                        el: 'main', 

                        data: data,
                        
                        computed: {
                                
                                nonStandardFiles: function() {
                                        let p = this
                                        return  this.files.filter(function (file) { 
                                                return p.standardTemplateFiles.indexOf(file.basename) === -1 
                                        })
                                }
                        },

                        methods: {

                                /**
                                 * Checks if a blade file of a specific type
                                 * exists in the file list
                                 */
                                isBladeFileAvailable: function (type) {
                                        let l = this.files.length;
                                        for (let i = 0; i < l; i++) {
                                                let file = this.files[i].basename
                                                if (file === type + ".blade.php") {
                                                        return true
                                                }
                                        }
                                        return false
                                },   


                                /**
                                 * Adds a new non-standard template file
                                 */
                                addNewFile: function () {
                                        let re = /^[\w.-]+$/i;
                                        if(!re.test(this.newFileName)) { 
                                                alert('Invalid file name')
                                        } else {

                                                util.submit ("{{ route('templates.file', [$template->id, 'other']) }}", {
                                                        filename: this.newFileName
                                                }, 'get')
                                        }
                                },
                                
                                
                                editFile: function (fullFilePath) {
                                        
                                        let fileName = fullFilePath.split('\\').pop().split('/').pop();

                                        util.submit ("{{ route('templates.file', [$template->id, 'other']) }}", {
                                                filename: fileName
                                        }, 'get')
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