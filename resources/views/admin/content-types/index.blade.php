@extends('admin.layout')

@section('header')
<div class="py-4 px-6">
        <h1 class="w-full p-2">
                <span class="text-lg font-semibold text-grey-darker uppercase borqder-b">
                        Content Types 
                </span>
        </h1>

        <h3 class="px-2 text-sm font-light text-grey-dark">
                Select the template for various content types
        </h3>
</div>        
@endsection


@section('main')
        
        <div class="w-full bg-white shadow">
                <table class="w-full text-left text-sm text-grey-darker border-collapse">
                        <thead class="bg-grey-lighter uppercase border-b">
                                <tr>
                                        <th class="py-2 px-6 font-semibold">Content Type</th>
                                        <th class="py-2 px-6 font-semibold">Template</th>
                                        <th class="py-2 px-6 font-semibold">Updated</th>
                                </tr>
                        </thead>
                        <tbody>
                                <tr v-for="ct in ctt" 
                                    class="border-b border-blue-lightest">
                                        <td class="py-2 px-6" v-text="ct.type"></td>
                                        <td class="py-2 px-6">
                                                <div class="inline-block relative w-64">
                                                        <select class="block appearance-none w-full bg-white border border-grey-light hover:border-grey px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline"
                                                            v-model="ct.template_id" 
                                                            v-on:change="save(ct)">
                                                                <option disabled value="0">Please select one</option>
                                                                <option v-for="template in templates" v-bind:value="template.id">
                                                                        @{{ template.name }}
                                                                </option>
                                                        </select>
                                                        <div class="pointer-events-none absolute pin-y pin-r flex items-center px-2 text-grey-darker">
                                                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                                        </div>
                                                </div>
                                        </td>
                                        <td class="py-2 px-6" v-text="ct.updated_at"></td>
                                </tr>
                        </tbody>
                </table>
                
        </div>
        
@endsection

@section('script')

    <!-- <script src="https://unpkg.com/axios/dist/axios.min.js"></script> -->

    
    <script>

        new Vue({ el: 'main', data: {
                        ctt: @json($ctt),
                        templates: @json($templates)
                },
                methods: {
                        save: function (ct) {
                                
                                ct.updated_at = 'Saving...'
                                
                                axios.post('/admin/content-types/' + ct.id, ct)

                                        .then(function (response) {
                                                ct.updated_at = 'Saved Successfully!'
                                                setTimeout(() => {
                                                ct.updated_at = response.data.updated_at  
                                                }, 2000);
                                        })
                                        
                                        .catch(function (error) {
                                                ct.updated_at = error.message
                                        })
                        } 
                } 
        })

    </script>

@endsection