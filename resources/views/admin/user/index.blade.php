@extends('admin.layout')

@section('header')
<div class="py-4 px-6">
    <h1 class="w-full p-2">
        <span class="text-lg font-semibold text-indigo uppercase">
            User Management
        </span>
    </h1>

    <h3 class="px-2 text-sm font-light text-indigo-darker">
        Create, Edit and Manage Registered Users
    </h3>
</div>
@endsection


@section('main')

<div class="px-6 py-4 flex justify-between">

    <div class="w-full md:w-3/4 xl:w-4/5 flex justify-between items-center text-sm bg-white border-grey-lighter rounded-lg border shadow">
        <input type="text" v-model="needle" id="txtSearch" ref="txtSearchRef" class="p-3 w-full" placeholder="Search name or email...">
        <p v-if="needle.length>0" v-text="filter_users.length + ' item(s)'" class="hidden sm:flex bg-yellow-lighter text-right text-xs text-orange cursor-pointer whitespace-no-wrap px-2 py-1 mr-2 rounded-lg" @click="needle=''"></p>
    </div>

</div>

<div class="w-full px-6">
    <table class="w-full bg-white shadow rounded text-left table-collapse">
        <thead class="uppercase text-xs font-semibold text-grey-darker border-b-2">
            <tr>
                <th class="p-4">Name</th>
                <th class="p-4">Email</th>
                <th class="p-4 hidden sm:table-cell">Type</th>
                <th class="p-4 hidden sm:table-cell">Joined</th>
                <th class="p-4"></th>
            </tr>
        </thead>
        <tbody class="align-baseline">
            <tr v-for="user in filter_users" class="border-b border-dotted">

                <td class="px-4 py-2 flex items-center flex-no-wrap text-puqrple-dark">
                
                    <img v-if="user.avatar" v-bind:src="user.avatar" class="w-8 h-8 rounded-full mr-4">
                    <svg v-else class="w-8 h-8 rounded-full border mr-4 fill-current text-grey-lighter" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                        <path class="heroicon-ui" d="M12 12a5 5 0 1 1 0-10 5 5 0 0 1 0 10zm0-2a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm9 11a1 1 0 0 1-2 0v-2a3 3 0 0 0-3-3H8a3 3 0 0 0-3 3v2a1 1 0 0 1-2 0v-2a5 5 0 0 1 5-5h8a5 5 0 0 1 5 5v2z" />
                    </svg>
                    
                    <a :href="editUser(user.id)" class="py-1 text-sm font-semibold no-underline text-blue hover:text-blue-dark" v-text="user.name"></a>

                </td>
                <td class="px-4 py-2 align-middle font-mono text-xs text-purple-dark whitespace-no-wrap">
                    <p class="text-xs text-grey-darker" v-text="user.email"></p>
                </td>
                <td class="hidden sm:table-cell px-4 py-2 align-middle font-mono text-sm whitespace-no-wrap">
                    <p class="text-xs" v-text="user.type"></p>
                </td>
                <td class="hidden sm:table-cell px-4 py-2 align-middle font-mono text-xs text-purple-dark whitespace-no-wrap" v-text="user.created_ago">
                </td>
                <td class="px-4 py-2 font-mono text-sm whitespace-no-wrap align-middle text-right">
                    <a v-bind:href="user.url" class="mb-1 cursor-pointer text-blue no-underline">
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

            filter_users: function() {
                return this.users.filter(user => {
                    
                    let n = user.name.toLowerCase()
                    let e = (user.email === null? '': user.email.toLowerCase())
                    return n.indexOf(this.needle.toLowerCase()) != -1 
                            || e.indexOf(this.needle.toLowerCase()) != -1

                })
            }

        },

        mounted: function () {
            this.$nextTick(() => this.$refs.txtSearchRef.focus())
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