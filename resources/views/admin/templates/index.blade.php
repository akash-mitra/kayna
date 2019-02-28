@extends('admin.layout')

@section('header')
<div class="py-4 px-6">
        <h1 class="w-full p-2">
                <span class="text-lg font-semibold text-grey-darker uppercase borqder-b">
                        Templates 
                </span>
        </h1>

        <h3 class="px-2 text-sm font-light text-grey-dark">
                Import new templates for various content types.
        </h3>
</div>        
@endsection


@section('main')
        
        <div class="pt-4 flex justify-end">
                <a href="/admin/content-types" class="no-underline border border-teal px-4 py-2 rounded text-sm  hover:bg-teal hover:text-white text-teal mr-2">
                        Template Assignments
                </a>

                <button id="btnNew" @click="newTemplate" class="border border-teal px-2 py-2 rounded text-sm bg-teal hover:bg-orange hover:border-orange text-white shadow">
                        New Template
                </button>
        </div>

        <div class="w-full mt-8 bg-white shadow">
                <table class="w-full text-left table-collapse">
                        <thead class="uppercase text-xs font-semibold text-grey-darker border-b-2">
                                <tr>
                                        <th class="p-4">#</th>
                                        <th class="p-4">Name</th>
                                        <th class="p-4">Used In</th>
                                        <th class="p-4">Created</th>
                                </tr>
                        </thead>
                        <tbody class="align-baseline">
                                @foreach($templates as $template)
                                        <tr class="hover:bg-grey-lightest hover:shadow-inner cursor-pointer border-b border-blue-lightest">
                                                <td class="px-4 py-2 border-t border-grey-light whitespace-no-wrap text-sm">{{ $loop->iteration }}</td>
                                                <td class="px-4 py-2 border-t border-grey-light whitespace-no-wrap">
                                                        <a href="{{ route('templates.show', $template->id)}}" class="no-underline text-blue">
                                                                {{ $template->name }}
                                                        </a>
                                                </td>
                                                <td class="px-4 py-2 border-t border-grey-light font-mono text-purple-dark whitespace-no-wrap text-sm">{!! implode(", ", $template->used_in) !!}</td>
                                                <td class="px-4 py-2 border-t border-grey-light whitespace-no-wrap text-sm">{{ $template->created_at->diffForHumans() }}</td>
                                        </tr>
                                @endforeach
                        </tbody>
                </table>

                <div class="w-full bg-grey-lightest h-12 flex justify-between px-2 py-2 font-normal text-xs text-blue-light border-b">
                        {{ $templates->links() }}
                </div>
        </div>

        <p class="text-xs text-right py-4 text-grey-darker">
                {{ count($templates) }} records found
        </p>

        <base-modal :show="showModal" cover="1/3" @close="showModal=false">
                <h4 slot="header" class="w-full text-blue-dark font-semibold bg-grey-lightest border-blue-lighter border-b qshadow py-4 px-8">
                        What template do you want to create?
                </h4>

                <div  class="w-full max-w-lg mx-auto px-8 pt-2 pb-4 border-b hover:bg-blue-lightest cursor-pointer" @click="createTemplate('home')">
                        <h3 class="text-blue font-light py-1">Homepage Template</h3>
                        <p class="text-grey-dark">Template for the first page or the landing page of your blog</p>
                </div>
                <div  class="w-full max-w-lg mx-auto px-8 pt-2 pb-4 border-b hover:bg-blue-lightest cursor-pointer" @click="createTemplate('page')">
                        <h3 class="text-blue font-light py-1">Page Template</h3>
                        <p class="text-grey-dark">Page templates are used to display individual pages of your blog</p>
                </div>
                <div  class="w-full max-w-lg mx-auto px-8 pt-2 pb-4 border-b hover:bg-blue-lightest cursor-pointer" @click="createTemplate('category')">
                        <h3 class="text-blue font-light py-1">Category Template</h3>
                        <p class="text-grey-dark">This template is used to display pages of a specific category chronologically</p>
                </div>
                <div  class="w-full max-w-lg mx-auto px-8 pt-2 pb-4 border-b hover:bg-blue-lightest cursor-pointer" @click="createTemplate('profile')">
                        <h3 class="text-blue font-light py-1">Profile Template</h3>
                        <p class="text-grey-dark">Profile template is used to show the profile page of a registered user</p>
                </div>

                <div slot="footer" class="bg-blue-lightest border-blue-lighter border-t h-4">
        </base-modal>
        
@endsection

@section('script')

        <script>
                // document.getElementById('btnSearch').onclick = function () {
                //         location.href = '{{ route('templates.index') }}' + '?q=' + document.getElementById('txtSearch').value 
                // }

                new Vue({
                        el: 'main',
                        data: {
                                showModal: false
                        },
                        methods: {
                                newTemplate: function () {
                                        this.showModal = true
                                },

                                createTemplate: function (type) {
                                        location.href = "/admin/templates/create/" + type
                                }
                        }
                })

        </script>

@endsection