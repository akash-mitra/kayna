@extends('admin.layout')

@section('header')
<div class="py-4 px-6">
    <h1 class="w-full p-2">
        <span class="text-lg font-semibold text-indigo uppercase">
            User Management
        </span>
    </h1>

    <h3 class="px-2 text-sm font-light text-indigo-darker">
        Create or Edit User
    </h3>
</div>
@endsection


@section('main')

<div class="px-6 py-4 flex justify-between">

    <input type="text" v-model="needle" id="txtSearch" class="p-3 w-2/3 lg:w-1/2 text-sm bg-white border-grey-lighter rounded border shadow" placeholder="Search name or description...">

    <!-- <a href="{{ route('users.create') }}" id="btnNew" class="border border-teal px-3 py-3 rounded text-sm bg-teal no-underline hover:bg-orange hover:border-orange text-white shadow">
        New User
    </a> -->

</div>

<div class="w-full px-6">
    <table class="w-full bg-white shadow rounded text-left table-collapse">
        <thead class="uppercase text-xs font-semibold text-grey-darker border-b-2">
            <tr>
                <th class="p-4">Name</th>
                <th class="p-4">Email</th>
                <th class="p-4 hidden sm:table-cell">Joined</th>
                <th class="p-4 hidden sm:table-cell">Profile</th>
            </tr>
        </thead>
        <tbody class="align-baseline">
            <tr v-for="user in users" class="border-b border-dotted">

                <td class="px-4 py-2 flex items-center flex-no-wrap text-puqrple-dark">
                    <a :href="user.url" class="no-underline" title="Public Profile">
                        <img v-if="user.avatar" v-bind:src="user.avatar" class="w-8 h-8 rounded-full mr-4">
                        <svg v-if="!user.avatar" class="w-8 h-8 rounded-full border mr-4 fill-current text-grey-lighter" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                            <path class="heroicon-ui" d="M12 12a5 5 0 1 1 0-10 5 5 0 0 1 0 10zm0-2a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm9 11a1 1 0 0 1-2 0v-2a3 3 0 0 0-3-3H8a3 3 0 0 0-3 3v2a1 1 0 0 1-2 0v-2a5 5 0 0 1 5-5h8a5 5 0 0 1 5 5v2z" /></svg>
                    </a>
                    <a :href="editUser(user.id)" class="py-1 text-sm font-semibold no-underline text-blue hover:text-blue-dark" v-text="user.name"></a>


                </td>
                <td class="px-4 py-2 align-middle font-mono text-xs text-purple-dark whitespace-no-wrap">
                    <p class="text-xs text-grey-darker" v-text="user.email"></p>
                </td>
                <td class="hidden sm:table-cell px-4 py-2 align-middle font-mono text-xs text-purple-dark whitespace-no-wrap" v-text="user.created_ago">
                </td>
                <td class="hidden sm:table-cell px-4 py-2 align-middle font-mono text-sm whitespace-no-wrap">
                    <a v-bind:href="editUser(user.id)" class="mb-1 cursor-pointer text-blue no-underline">
                        <svg viewBox="0 0 20 20" class="fill-current h-3 w-3 text-blue-light" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <path d="M12.2928932,3.70710678 L0,16 L0,20 L4,20 L16.2928932,7.70710678 L12.2928932,3.70710678 Z M13.7071068,2.29289322 L16,0 L20,4 L17.7071068,6.29289322 L13.7071068,2.29289322 Z" id="Combined-Shape"></path>
                        </svg>
                        View
                    </a>
                </td>

            </tr>
        </tbody>
    </table>

</div>

<p class="px-6 text-xs text-right py-4 text-grey-darker">
    @{{ users.length }} records found
</p>

@endsection

@section('script')

<script>
    new Vue({
        el: 'main',
        data: {
            needle: '',
            users: @json($users)
        },

        computed: {

        },

        methods: {
            editUser: function(id) {
                return "/admin/users/" + id + "/edit"
            },

            deleteUser: function(id) {
                let p = this
                axios.delete('/admin/users/' + id)
                    .then(function(response) {
                        p.removeuserById(response.data.user_id)
                        flash({
                            message: response.data.flash.message
                        })
                    })
            },

            removeuserById: function(user_id) {
                for (let i = 0; i < this.users.length; i++) {
                    if (this.users[i].id === user_id)
                        this.users.splice(i, 1)
                }
            }
        }
    })
</script>

@endsection 