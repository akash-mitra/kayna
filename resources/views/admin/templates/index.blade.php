@extends('admin.layout')

@section('header')
<div class="py-4 px-6">
        <h1 class="w-full p-2">
                <span class="text-lg font-semibold text-indigo uppercase">
                        Template Library
                </span>
        </h1>

        <h3 class="px-2 text-sm font-light text-indigo-darker">
                Import new templates for various content types.
        </h3>
</div>
@endsection


@section('main')

<div class="px-6 py-4">

        <div class="w-full flex flex-wrap uppercase text-sm font-bold">
                <span v-for="(tab, index) in tabs" :class="active_tab!=index+1? 'cursor-pointer text-grey-dark':'text-indigo-dark bg-white border-t-2 border-indigo'" class="py-4 px-8" @click="select(tab, $event)" v-text="tab"></span>
        </div>


        <div v-for="(tab, index) in tabs">
                <div v-show="active_tab===index+1" class="w-full text-sm bg-white">
                        <h3 class="w-full px-8 py-2 pt-8 uppercase text-xs text-grey-darker font-light">Installed</h3>
                        <div class="w-full shadow px-4 pt-2 pb-4 flex flex-wrap">
                                <div v-for="template in filterTemplatesFor(applied_templates, tab)" class="my-2 p-2 w-full md:w-1/3 md:max-w-xs">
                                        <template-tile v-bind:template="template" @apply-template="onApplyTemplate"></template-tile>
                                </div>
                        </div>
                        <h3 class="w-full px-8 py-2 pt-8 uppercase text-xs text-grey-darker font-light">Available</h3>
                        <div class="w-full shadow px-4 pt-2 pb-4 flex flex-wrap">
                                <div v-for="template in filterTemplatesFor(public_templates, tab)" class="my-2 p-2 w-full md:w-1/3 md:max-w-xs">
                                        <template-tile v-bind:template="template" @install-template="onInstallTemplate"></template-tile>
                                </div>
                        </div>
                </div>
        </div>

        <form id="frmInstall" method="post" action="{{route('templates.install')}}">
                @csrf
                <input id="inputTemplateId1" type="hidden" name="template">
        </form>

        <form id="frmApply" method="post" action="{{route('templates.apply')}}">
                @csrf
                <input id="inputTemplateId2" type="hidden" name="template">
        </form>
</div>


@endsection

@section('script')

<script src="/js/template-tile.js"></script>

<script>
        new Vue({
                el: 'main',
                data: {
                        active_tab: 1,
                        tabs: ['home', 'page', 'profile', 'category'],
                        applied_templates: @json($templates),
                        public_templates: [],
                        showModal: false
                },

                methods: {

                        select: function(choice, event) {
                                this.active_tab = this.tabs.indexOf(choice) + 1
                        },

                        // newTemplate: function() {
                        //         this.showModal = true
                        // },

                        // createTemplate: function(type) {
                        //         location.href = "/admin/templates/create/" + type
                        // },

                        filterTemplatesFor: function(templates, type) {
                                return templates.filter(item => item.type === type)
                        },

                        onInstallTemplate: function(templateId) {
                                var form = document.getElementById("frmInstall");
                                var inputTemplate = document.getElementById("inputTemplateId1");
                                inputTemplate.value = templateId;
                                form.submit();
                        },

                        onApplyTemplate: function(templateId) {
                                var form = document.getElementById("frmApply");
                                var inputTemplate = document.getElementById("inputTemplateId2");
                                inputTemplate.value = templateId;
                                form.submit();
                        },

                        // Merges list of all the available templates with the
                        // list of templates currently in use
                        // mergeTemplates(public_templates) {
                        //         for (let i = 0; i < public_templates.length; i++) {
                        //                 t = public_templates[i]
                        //                 // for (let j = 0; j < this.applied_templates.length; j++) {
                        //                 //         if (t.id === this.applied_templates[j].source_id) {

                        //                 //         }
                        //                 // }
                        //                 this.applied_templates.push(t)
                        //         }
                        // }
                },

                created: function() {
                        let p = this
                        axios.get("{{route('templates.templates')}}")
                                .then((response) => {
                                        p.public_templates = response.data
                                })
                                .catch((error) => {
                                        console.log(error)
                                })

                }
        })
</script>

@endsection