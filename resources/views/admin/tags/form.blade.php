@extends('admin.layout')

@section('header')
        
<div class="py-4 px-6 pb-8">
        
        <h1 class="w-full p-2">
                <span class="text-lg font-semibold text-grey-darker uppercase">
                        @if(empty($tag->name))
                                <span class="text-grey-dark">Create New</span>
                        @else
                                <span class="text-grey-dark">Edit Tag</span>
                        @endif
                </span>
        </h1>

        <h3 class="px-2 text-sm font-light text-grey-dark">
                Tags help you to relate contents that are similar so that you can access them faster
        </h3>

</div>
@endsection


@section('main')
        

        <div class="w-full md:w-4/5 lg:w-3/5 p-6 bg-white shadow rounded-lg">
                <form action="{{ route('tags.store') }}" method="POST" id="frm">
                        @csrf
                        <div class="flex flex-wrap -mx-3 mb-6">
                                <div class="w-full px-3">
                                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="name">
                                                Name
                                        </label>
                                        <input v-model="name" name="name" class="w-32 appearance-none block bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-grey" id="inName" type="text" placeholder="e.g. Tennis">
                                        <p class="text-grey-dark text-xs italic">Provide a unique name</p>
                                </div>
                        </div>

                        

                        <div class="flex flex-wrap -mx-3 mb-4">
                                <div class="w-full px-3">
                                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="description">
                                                Description 
                                        </label>
                                        <textarea v-model="description" name="description" class="appearance-none block w-full h-32 bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-grey" id="txtTag"  placeholder="e.g. no matter how good I am at tennis, I'll never be as good as a wall."></textarea>
                                </div>
                        </div>
                </form>

                <div class="flex items-center">
                        <button class="border border-teal px-8 py-2 rounded text-sm bg-teal text-white shadow" 
                                @click="confirm">
                                Save                                
                        </button>
                </div>
        </div>

        

        
        
@endsection

@section('script')
        
        
        <script>

                let data = {
                        id:'{{data_get($tag, "id")}}',
                        name: '{{data_get($tag, "name")}}',
                        description: `{{data_get($tag, "description")}}`
                }
                new Vue({ el: 'main', 
                        data: data,
                        computed: {},
                        methods: {
                                checkMandatory: function () {
                                        return true
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
                                        axios.post('{{ route("tags.store") }}', {
                                                'name': this.name, 'description': this.description
                                        })
                                        .then (function (response) {
                                                p.id = response.data.tag_id
                                                
                                                flash({message: response.data.flash.message})
                                        })
                                },

                                updateAtServer: function () {
                                        axios.patch( '/admin/tags/' + this.id, {
                                                'name': this.name, 'description': this.description
                                        }).then (function (response) {
                                                
                                                flash({message: response.data.flash.message})
                                        });
                                },
                        }
                })
        </script>

@endsection