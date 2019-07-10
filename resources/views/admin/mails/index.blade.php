@extends('admin.layout')

@section('header')
<div class="py-4 px-6">
    <h1 class="w-full p-2">
        <span class="text-lg font-semibold text-indigo uppercase">
            Mailing
        </span>
    </h1>

    <h3 class="px-2 text-sm font-light text-indigo-darker">
        Create or Edit E-Mail Templates
    </h3>

    
</div>
@endsection



@section('main')

@if(empty(param('mail_service')))
<div class="py-4 px-6 text-sm bg-yellow-lightest text-orange-dark border-t border-b border-orange">
    Mail service provider is not configured in <a href="/admin/settings#mail">settings</a>. 
    Please configure mail service provider first before using mailing.
</div>
@else

<div class="px-6 mt-3">

        <div class="flex border-b">
                <span @click="selectedTab=1" class="no-underline text-grey-dark cursor-pointer hover:bg-white px-4 py-3 mr-2" :class="selectedTab===1?'border-t-2 border-indigo bg-white -mb-1 text-indigo':''">
                        Standard 
                </span>    
        </div>

        <div v-if="selectedTab==1" class="bg-white shadow">
            <div class="px-6 pt-1 pb-4">
                <table class="w-full mt-2 rounded text-left table-collapse">
                    <thead class="text-xs font-semibold text-grey-darker border-b-2">
                            <tr>
                                <th class="p-4">Activate</th>
                                <th class="p-4">Email</th>
                                <th class="p-4">Event</th>
                                <th class="p-4 hidden lg:table-cell">File</th>
                                <th class="p-4"></th>
                            </tr>
                    </thead>
                    <tbody class="align-baseline text-sm">
                        <tr v-for="template in templates" class="border-b border-dotted">

                            <td class="px-4 py-2 text-xs align-middle text-right">
                                <flip-switch :state="template.active==1" @toggle="changeState(template)"></flip-switch>
                            </td>
                            <td class="px-4 py-2 text-xs">
                                <a v-bind:href="template.url" class="no-underline text-sm font-medium text-blue">
                                    @{{ template.name }}
                                </a>
                            </td>
                            <td class="px-4 py-2 text-sm text-purple-dark">
                                @{{ template.event }}
                            </td>
                            <td class="hidden lg:table-cell px-4 py-2 font-mono text-sm text-grey-dark">
                                @{{ template.file }}
                            </td>

                            <td class="px-4 py-2 font-mono text-sm whitespace-no-wrap align-middle text-right">
                                <a v-bind:href="template.url" class="mb-1 cursor-pointer text-blue no-underline">
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
        </div>
</div>
@endif
@endsection

@section('script')

<script>
    new Vue({
        el: 'main',
        data: {
            selectedTab: 1,
            needle: '',
            templates: @json($templates)
        },

        methods: {

            changeState: function (template) {
                

                newState = template.active=='1'?'0':'1';

                util.ajax('post', '/admin/mails/' + template.slug, {
                    active: newState
                }, function () {

                    template.active = newState
                },
                )
            }
        }
    })
</script>

@endsection 