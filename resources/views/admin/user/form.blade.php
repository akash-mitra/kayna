@extends('admin.layout')



@section('main')

<div class="w-full bg-grey-lightest h-1screen">
    <div class="w-full p-8 flex flex-wrap items-center justify-between">
        <div class="flex flex-wrap1 items-center">
            <img :src="profile.avatar" class="rounded-full h-16 w-16 border-white border-4 shadow mr-4" />

            <div>
                <h1 class="w-full text-2xl font-light text-grey-darker">
                    @{{ profile.name }}
                    <span class="bg-purple text-white text-xs rounded-lg shadow px-2 py-1 ml-2">@{{ profile.type }}</span>
                </h1>
                <span class="mt-2 text-grey-dark text-sm">Joined @{{ profile.created_ago }}</span>
            </div>
        </div>
        <!-- <button class="bg-teal text-white rounded shadow px-8 py-2 my-4">Save</button> -->
    </div>

    <div class="w-full bg-grey-lighter md:flex">

        <div class="w-full md:w-1/2 p-8">

            <div class="py-2 flex justify-between border-b border-dotted items-center">
                <span class="text-indigo text-sm">User Type</span>

                <div>
                    <span class="text-blue text-xs cursor-pointer" v-if="!showTypeInput" @click="makeTypeEditable">Change</span>
                    <span class="text-blue text-xs cursor-pointer mr-4" v-if="showTypeInput" @click="cancelTypeEdit">Cancel</span>
                    <span class="text-blue text-xs cursor-pointer" v-if="showTypeInput" @click="changeType">Save</span>
                </div>
            </div>

            <select v-show="showTypeInput" v-model="profile.type" class="w-full bg-grey-lightest p-2 border rounded shadow-inner text-grey-dark text-sm">
                <option value="admin">Admin</option>
                <option value="registered">Registered</option>
            </select>
            <p v-show="!showTypeInput" v-text="profile.type" class="w-full py-2 h-16 text-grey-dark text-sm"></p>

            

            <div class="py-2 flex justify-between border-b border-dotted items-center">
                <span class="text-indigo text-sm">Bio / About</span>
                <div>
                    <span class="text-blue text-xs cursor-pointer" v-if="!showBioInput" @click="makeBioEditable">Edit</span>
                    <span class="text-blue text-xs cursor-pointer mr-4" v-if="showBioInput" @click="cancelBioEdit">Cancel</span>
                    <span class="text-blue text-xs cursor-pointer" v-if="showBioInput" @click="saveBio">Save</span>
                </div>
            </div>
            <p v-show="!showBioInput" class="w-full py-2 h-16 text-grey-dark text-sm" v-text="about"></p>
            <textarea v-show="showBioInput" v-model="profile.bio" class="w-full bg-grey-lightest p-2 h-24 border rounded shadow-inner text-grey-dark text-sm"></textarea>

            

            @if($profile->id === auth()->user()->id)
            <div class="py-2 flex justify-between border-b border-dotted items-center">
                <span class="text-indigo text-sm">Password</span>
                <div>
                    <span class="text-blue text-xs cursor-pointer" v-if="!showPasswordInput" @click="togglePasswordEditable">Change</span>
                    <span class="text-blue text-xs cursor-pointer mr-4" v-if="showPasswordInput" @click="togglePasswordEditable">Cancel</span>
                    <span class="text-blue text-xs cursor-pointer" v-if="showPasswordInput" @click="savePassword">Save</span>
                </div>
            </div>

            <input type="password" placeholder="Must be 8 characters" v-show="showPasswordInput" class="w-full bg-grey-lightest p-2 border rounded shadow-inner text-sm" v-model="passwordHolder" autocomplete="off" />
            <p v-show="!showPasswordInput" class="text-grey-dark text-sm">Change your password</p>
            @endif
        </div>

        <div class="w-full md:w-1/2 p-8">
            <div class="flex border-b border-dotted py-3 text-sm">
                <div class="w-1/3 font-light text-indigo">Email</div>
                <div class="w-2/3" v-text="profile.email"></div>
            </div>
            <div class="flex border-b border-dotted py-3 text-sm">
                <div class="w-1/3 font-light text-indigo">Joined</div>
                <div class="w-2/3" v-text="profile.created_at"></div>
            </div>
            <div class="flex border-b border-dotted py-3 text-sm">
                <div class="w-1/3 font-light text-indigo">Social Auth</div>
                <div class="w-2/3">
                    <p v-for="provider in profile.providers" v-text="provider.provider"></p>
                </div>
            </div>

            <div class="flex border-b border-dotted py-3 text-sm">
                <div class="w-1/3 font-light text-indigo">Publications</div>
                <div class="w-2/3" v-text="profile.publications.length"></div>
            </div>
            <div class="flex border-b border-dotted py-3 text-sm">
                <div class="w-1/3 font-light text-indigo">Comments</div>
                <div class="w-2/3" v-text="profile.comments.length"></div>
            </div>
            <div class="flex border-b border-dotted py-3 text-sm">
                <div class="w-1/3 font-light text-indigo">Last Updated</div>
                <div class="w-2/3" v-text="profile.updated_ago"></div>
            </div>
        </div>

    </div>
</div>

@endsection

@section('script')

<script>
    new Vue({

        el: 'main',

        data: {
            profile: @json($profile),
            passwordHolder: null,
            showPasswordInput: false,

            showBioInput: false,
            previous_bio: null,

            showTypeInput: false,
            previous_type: null,
        },

        computed: {
            about: function() {
                return (this.profile.bio != null && this.profile.bio.length > 0 ? this.profile.bio : 'Apparently this user likes to keep an air of mistry around himself/herself')
            }
        },

        methods: {

            makeTypeEditable: function() {
                this.showTypeInput = !this.showTypeInput;
                this.previous_type = this.profile.type
            },

            cancelTypeEdit: function() {
                this.showTypeInput = !this.showTypeInput;
                this.profile.type = this.previous_type
            },

            changeType: function() {
                this.showTypeInput = !this.showTypeInput
                axios.patch('/admin/users/' + this.profile.id, {
                    type: this.profile.type
                }).then(function(response) {

                    flash({
                        message: response.data.message
                    })
                }).catch(function(error) {

                    flash({
                        message: error.response.status + ' ' + error.response.statusText + ': ' + error.response.data.message
                    })
                })
            },

            makeBioEditable: function() {
                this.showBioInput = !this.showBioInput
                this.previous_bio = this.profile.bio
            },

            cancelBioEdit: function() {
                this.showBioInput = !this.showBioInput
                this.profile.bio = this.previous_bio
            },

            saveBio: function() {
                this.showBioInput = !this.showBioInput

                axios.patch('/admin/users/' + this.profile.id, {
                    bio: this.profile.bio
                }).then(function(response) {

                    flash({
                        message: response.data.message
                    })
                }).catch(function(error) {

                    flash({
                        message: error.response.status + ' ' + error.response.statusText + ': ' + error.response.data.message
                    })
                })
            },

            togglePasswordEditable: function() {
                this.passwordHolder = null
                this.showPasswordInput = !this.showPasswordInput
            },

            savePassword: function() {
                this.showPasswordInput = !this.showPasswordInput;
                axios.post('/admin/users/' + this.profile.id + '/password', {
                    password: this.passwordHolder
                }).then(function(response) {
                    flash({
                        message: response.data.message
                    })
                }).catch(function(error) {
                    alert("Failed to save the password. Retry later.")
                    console.log(error);
                })
            },

        }
    })
</script>

@endsection 