@extends('admin.layout')

@section('header')
<div class="py-4 px-6">
    <h1 class="w-full p-2">
        <span class="text-lg font-semibold text-indigo uppercase">
            Templates
        </span>
    </h1>
    
    <h3 class="px-2 text-sm font-light text-indigo-darker">
        Create or Edit Template
    </h3>
</div>
@endsection


@section('main')

<div class="px-6 py-4 block sm:flex sm:justify-between">

    

    <div class="w-full md:w-3/4 xl:w-4/5 flex justify-between items-center text-sm bg-white border-grey-lighter rounded-lg border shadow">
        <input type="text" v-model="needle" id="txtSearch" ref="txtSearchRef" class="p-3 w-full" placeholder="Search name or description...">
        <p v-if="needle.length>0" v-text="filter_templates.length + ' item(s)'" class="hidden sm:flex bg-yellow-lighter text-right text-xs text-orange cursor-pointer whitespace-no-wrap px-2 py-1 mr-2 rounded-lg" @click="needle=''"></p>
    </div>

    <a href="{{ route('templates.create') }}" id="btnNew" class="flex justify-center items-center mt-4 sm:mt-0 px-4 py-2 rounded text-sm bg-indigo no-underline hover:bg-indigo-dark text-white shadow whitespace-no-wrap">
        Create Template
    </a>

</div>

<div class="w-full px-6">
    <table class="w-full mt-2 bg-white shadow rounded text-left table-collapse">
        <thead class="text-xs font-semibold text-grey-darker border-b-2">
            <tr>
                <th class="py-4 px-6">Name</th>
                <th class="hidden sm:table-cell p-4">Description</th>
                <th class="hidden sm:table-cell p-4">Active</th>
                <th class="p-4"></th>
            </tr>
        </thead>
        <tbody class="align-baseline">
            <tr v-for="template in filter_templates" class="border-b hover:bg-grey-lightest">

                <td class="px-6 py-2 text-xs max-w-xs align-middle">
                    <a v-bind:href="editTemplate(template.id)" class="no-underline text-sm font-medium text-blue">
                        <span v-text="template.name"></span>
                    </a>
                </td>

                <td class="hidden sm:table-cell px-4 py-2 text-xs whitespace-no-wrap align-middle">
                    <p v-if="template.description" class="text-grey-dark  my-2 text-sm font-sans truncate" v-text="template.description"></p>
                </td>
                
                <td class="hidden sm:table-cell px-4 py-2 font-mono text-xs text-purple-dark whitespace-no-wrap align-middle" v-text="template.active">
                </td>
                <td class="px-4 py-2 font-mono text-sm whitespace-no-wrap align-middle text-right">
                    <a href="/" class="mb-1 cursor-pointer text-blue no-underline">
                        <svg viewBox="0 0 20 20" class="fill-current h-6 w-6 text-grey" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
							<g id="icon-shape">
								<polygon id="Combined-Shape" points="12.9497475 10.7071068 13.6568542 10 8 4.34314575 6.58578644 5.75735931 10.8284271 10 6.58578644 14.2426407 8 15.6568542 12.9497475 10.7071068"></polygon>
							</g>
						</svg>
                    </a>
                </td>
            </tr>
        </tbody>
    </table>

</div>

<p class="px-6 text-xs text-right py-4 text-grey-darker">
    @{{ templates.length }} records found
</p>

@endsection

@section('script')

<script>
    new Vue({
        el: 'main',
        data: {
            needle: '',
            templates: @json($templates)
        },

        computed: {

            filter_templates: function() {
                return this.templates.filter(template => {
                    
                    let t = template.name.toLowerCase()
                    let d = (template.description === null? '': template.description.toLowerCase())
                    return t.indexOf(this.needle.toLowerCase()) != -1 
                            || d.indexOf(this.needle.toLowerCase()) != -1

                })
            }

        },

        mounted: function () {
            this.$nextTick(() => this.$refs.txtSearchRef.focus())
        },

        methods: {
            editTemplate: function(id) {
                return "/admin/templates/" + id
            },

        //     deleteTemplate: function(id) {
        //         let p = this
        //         axios.delete('/admin/templates/' + id)
        //             .then(function(response) {
        //                 p.removeTemplateById(response.data.template_id)
        //                 flash({
        //                     message: response.data.flash.message
        //                 })
        //             })
        //     },

        //     removeTemplateById: function(template_id) {
        //         for (let i = 0; i < this.templates.length; i++) {
        //             if (this.templates[i].id === template_id)
        //                 this.templates.splice(i, 1)
        //         }
        //     }
        }
    })
</script>

@endsection