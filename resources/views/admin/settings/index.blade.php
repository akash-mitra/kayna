@extends('admin.layout')

@section('header')
<div class="py-4 px-6">
    <h1 class="w-full p-2">
        <span class="text-lg font-semibold text-indigo uppercase">
            Settings
        </span>
    </h1>

    <h3 class="px-2 text-sm font-light text-indigo-darker">
        Tweak your blog as you want
    </h3>
</div>
@endsection


@section('main')

<div class="pt-4 flex flex-cols border-b">

    <div class="w-48 uppercase text-sm font-bold border-t">
        <div :class="active_tab!=1? 'cursor-pointer text-grey-dark':'text-indigo-dark bg-white border-l-2 border-indigo'" class="py-4 pl-8" @click="select('general', $event)">General</div>
        <div :class="active_tab!=2? 'cursor-pointer text-grey-dark':'text-indigo-dark bg-white border-l-2 border-indigo'" class="py-4 pl-8" @click="select('social', $event)">Login</div>
        <div :class="active_tab!=3? 'cursor-pointer text-grey-dark':'text-indigo-dark bg-white border-l-2 border-indigo'" class="py-4 pl-8" @click="select('storage', $event)">Storage</div>
        <div :class="active_tab!=4? 'cursor-pointer text-grey-dark':'text-indigo-dark bg-white border-l-2 border-indigo'" class="py-4 pl-8" @click="select('editor', $event)">Editor</div>
        <div :class="active_tab!=5? 'cursor-pointer text-grey-dark':'text-indigo-dark bg-white border-l-2 border-indigo'" class="py-4 pl-8" @click="select('cache', $event)">Cache</div>
        <div :class="active_tab!=6? 'cursor-pointer text-grey-dark':'text-indigo-dark bg-white border-l-2 border-indigo'" class="py-4 pl-8" @click="select('feed', $event)">Feeds</div>
    </div>

    <div v-show="active_tab===1" class="w-full md:flex text-sm bg-white border-t">
        @include('admin.settings.general-settings')
    </div>
    
    <div v-show="active_tab===2" class="w-full md:flex text-sm bg-white border-t">
        @include('admin.settings.login-settings')
    </div>

    <div v-show="active_tab===3" class="w-full flex flex-wrap text-sm px-2 p-4 bg-white border-t">
        @include('admin.settings.storage-settings')
    </div>

    <div v-show="active_tab===4" class="w-full md:flex text-sm bg-white border-t">
        @include('admin.settings.editor-settings')
    </div>

    <div v-show="active_tab===5" class="w-full md:flex text-sm bg-white border-t">
        @include('admin.settings.cache-settings')
    </div>

    <div v-show="active_tab===6" class="w-full md:flex text-sm bg-white border-t">
        @include('admin.settings.feed-settings')
    </div>
</div>
@endsection

@section('script')

<script>
    new Vue({
        el: 'main',
        data: {
            active_tab: 1,
            tabs: ['general', 'social', 'storage', 'editor', 'cache', 'feed'],
            /* storage related variables */
            storageS3StateClass: 'bg-grey',

            /* Login related variables */
            loginFBStateClass: 'bg-grey',
            loginGoogleStateClass: 'bg-grey',
            loginNativeStateClass: 'bg-grey',

            /* editor related variable */
            editorStateClass: 'bg-green shadow hover:bg-green-dark',

            /* parameters */
            @foreach($settings as $key => $value)
                    {{ $key }} {!! ": '" !!}{{ $value }}{!! "'," !!}
            @endforeach
        },
        methods: {
            select: function(choice, event) {
                this.active_tab = this.tabs.indexOf(choice) + 1
            },



            /*
             * Given a target class variable and a "enable" or "disable" state,
             * this method will change the classes to represent 
             * enable or disabe colors.
             * If no "state" parameter is passed, state is considered enabled.
             */
            change: function(targetClassProperty, state = "enable") {
                this[targetClassProperty] = state === 'disable' ? 'bg-grey' : 'bg-green shadow hover:bg-green-dark'
            },

            /**
             * This function should only be used if paramters are binary
             * and target class properties are required to be set. If
             * parameter is a generic value, use "update" method.
             */
            save: function(targetClassProperty, parameters) {

                let vm = this,
                    l = parameters.length,
                    settings = {}

                for (let i = 0; i < l; i++) {
                    let param = parameters[i]
                    settings[param] = vm[param]
                }
                vm.change(targetClassProperty, 'disable')
                axios.patch('/admin/settings', settings)
                    .then(response => {
                        vm.change(targetClassProperty, 'enable')
                        flash({
                            message: response.data.message,
                            type: response.data.status
                        })
                    })
                    .catch(error => {
                        flash('Error! Could not reach the API. ' + error)
                    })
            },

            /**
             * Accepts an array of keys. For each member of the keys array
             * it checks the current value from vue data array, and sends
             * the values to server for saving against the key
             */
            update: function (keys) {
                
                let settings = {}, vm = this

                for (let i = 0; i < keys.length; i++) {
                    let param = keys[i]
                    settings[param] = vm[param]
                }

                axios.patch('/admin/settings', settings)
                    .then(response => {
                        flash({
                            message: response.data.message,
                            type: response.data.status
                        })
                    })
                    .catch(error => {
                        flash('Error! Could not reach the API. ' + error)
                    })
            },

        }
    })
</script>

@endsection 