@extends('admin.layout')

@section('header')
        
<div class="py-4 px-6 pb-8">
        
        <h1 class="w-full p-2">
                <span class="text-lg font-semibold text-grey-darker uppercase">
                        @if(empty($category->name))
                                <span class="text-grey-dark">Create New</span>
                        @else
                                <span class="text-grey-dark">Edit Category</span>
                        @endif
                </span>
        </h1>

        <h3 class="px-2 text-sm font-light text-grey-dark">
                Categories help you organize your pages in separate groups
        </h3>

</div>
@endsection


@section('main')
     
<div class="px-6">
<form action="{{ route('categories.store') }}" method="POST" id="frm">
        @csrf

        <div class="w-full md:w-4/5 lg:w-3/5  p-6 bg-white shadow rounded-lg">
                        
                        <div class="flex flex-wrap -mx-3 mb-6">
                                <div class="w-full px-3">
                                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="name">
                                                Name
                                        </label>
                                        <input v-model="name" name="name" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-grey" id="inName" type="text" placeholder="e.g. Sports, Movie Reviews">
                                        <p class="text-grey-dark text-xs italic">Provide a unique name</p>
                                </div>
                        </div>

                        <div class="flex flex-wrap -mx-3 mb-6">
                                <div class="w-full px-3">
                                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="parent_id">
                                                Make this category under
                                        </label>

                                        <div class="relative">
                                                <select v-model="parent_id" name="parent_id" class="appearance-none block w-full bg-grey-lighter text-gr1ey-darker border border-grey-lighter rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-grey">
                                                        <option disabled>Please select one</option>
                                                        <option value="">None (Top level category)</option>
                                                        <option v-for="category in flat" v-if="category.id>0" :value="category.id" v-bind:key="category.id">
                                                                
                                                                @{{ category.name }}
                                                        </option>
                                                </select>
                                                <div class="pointer-events-none absolute pin-y pin-r flex items-center px-2 text-grey-darker">
                                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                                </div>
                                        </div>
                                </div>
                        </div>

                        <div class="flex flex-wrap -mx-3 mb-4">
                                <div class="w-full px-3">
                                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="description">
                                                Description 
                                        </label>
                                        <textarea v-model="description" name="description" class="appearance-none block w-full h-32 bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-grey" id="txtCategory"  placeholder="e.g. Movies I have watched this summer..."></textarea>
                                </div>
                        </div>
                

                <div class="flex items-center">
                        <button type="button" 
                                class="border border-teal px-8 py-2 rounded text-sm bg-teal text-white shadow" 
                                @click="confirm">
                                Save                                
                        </button>
                </div>
        </div>
</form>
        
</div>
        
        
@endsection

@section('script')
        
        
        <script>

                let data = {
                        'id':'{{data_get($category, "id")}}',
                        'name': '{{data_get($category, "name")}}',
                        'description': '{{data_get($category, "description")}}',
                        'parent_id': '{{data_get($category, "parent_id")}}',
                        'categories': @json($categories),
                        'flat': []
                }
                new Vue({ el: 'main', 
                        data: data,
                        computed: {
                                
                        },
                        created: function () {

                                // we are using this to build a flattened hierarchy from the
                                // categories data coming from server. The flat structure is
                                // later used to display the category names in order in select
                                // option dropdown. We insert a top root node to encompass all
                                // the parent nodes under a single root tree.
                                let root = {
                                        id: 0,
                                        name: 'root',
                                        children: this.createDataTree(this.categories)
                                }
                                
                                // this will store the flat structure in the flat variable passed
                                // to the function 
                                this.createFlatIndent(this.flat, root) ;
                                
                        },
                        methods: {
                                checkMandatory: function () {
                                        return true
                                },

                                /**
                                 * This function takes a flat list with id and parent_id and 
                                 * converts it to a tree structure.
                                 */
                                createDataTree:  function (dataset) {
                                        let hashTable = Object.create(null)
                                        dataset.forEach( aData => hashTable[aData.id] = { ...aData, children : [] } )
                                        let dataTree = []
                                        dataset.forEach( aData => {
                                                if( aData.parent_id ) hashTable[aData.parent_id].children.push(hashTable[aData.id])
                                                else dataTree.push(hashTable[aData.id])
                                        } )
                                        return dataTree
                                },

                                /**
                                 * This function takes a tree structure and flattens it with indentation
                                 */
                                createFlatIndent: function (struct, tree, level) {
                                        if (typeof level === 'undefined') level = 0;
                                        let indentation = '';
                                        for (let i =1; i < level; i++) indentation += "\u2014";
                                        struct.push({
                                                id: tree.id,
                                                name: indentation + ' ' + tree.name,
                                                level: level
                                        });
                                        // struct.push("name=" + tree.name + " at level=" + level)
                                        if (tree.children.length > 0) {
                                                level += 1;
                                                for(let i = 0; i < tree.children.length; i++) {
                                                        let t = tree.children[i]
                                                        // indentedStructure.push (this.createFlatIndent(t, level))
                                                        this.createFlatIndent(struct, t, level)
                                                }
                                        } 

                                        // return indentedStructure;
                                       
                                },

                                confirm: function () {
                                        if (this.checkMandatory ()) {

                                                if (this.id === '') {
                                                        this.createAtServer ()
                                                }
                                                else {
                                                        this.updateAtServer ()
                                                }
                                        }
                                },

                                createAtServer: function () {
                                        p = this
                                        axios.post('{{ route("categories.store") }}', {
                                                'name': this.name, 'description': this.description, 'parent_id': this.parent_id
                                        })
                                        .then (function (response) {
                                                p.id = response.data.category_id
                                                
                                                flash({message: response.data.flash.message})
                                        })
                                },

                                updateAtServer: function () {
                                        axios.patch( '/admin/categories/' + this.id, {
                                                'name': this.name, 'description': this.description, 'parent_id': this.parent_id
                                        }).then (
                                                (response) => { flash({message: response.data.flash.message}) },
                                                (error)    => { 
                                                        // console.log(error.response.data.errors)
                                                        flash({message: error.response.data.message, type: 'error'}) 
                                                },
                                        )
                                },
                        }
                })
        </script>

@endsection