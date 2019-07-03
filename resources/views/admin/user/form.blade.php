@extends('admin.layout')
@section('css')
<style>
.cropper-crop-box, .cropper-view-box {
    border-radius: 50%;
}

.cropper-view-box {
    box-shadow: 0 0 0 1px #39f;
    outline: 0;
}
</style>
@endsection

@section('header')
<div class="py-2 px-6 flex items-center">
    <div>
        <h1 class="w-full p-2">
            <span class="text-lg font-light text-indigo uppercase">
                User Profile
            </span>
        </h1>
    </div>
</div>
@endsection
@section('main')

<div class="w-full bg-grey-lightest">
    <div class="w-full p-8 flex flex-wrap items-center justify-between border-t border-b">
        <div class="flex flex-wrap1 items-center">
            <div @click="changeImage" class="cursor-pointer" title="Change Profile Picture">
                <img v-if="profile.avatar" :src="profile.avatar" class="rounded-full h-16 w-16 border-white border-4 shadow mr-4" />
                <svg v-else class="w-16 h-16 rounded-full border-4 mr-4 fill-current text-grey-light" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                    <path class="heroicon-ui" d="M12 12a5 5 0 1 1 0-10 5 5 0 0 1 0 10zm0-2a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm9 11a1 1 0 0 1-2 0v-2a3 3 0 0 0-3-3H8a3 3 0 0 0-3 3v2a1 1 0 0 1-2 0v-2a5 5 0 0 1 5-5h8a5 5 0 0 1 5 5v2z" />
                </svg>
            </div>
            <div class="flex flex-col">
                <h1 class="w-full text-2xl font-light text-grey-darker">
                    @{{ profile.name }}
                    <span class="align-middle bg-purple text-white text-xs rounded-lg shadow px-2 py-1 ml-2 uppercase">@{{ profile.type }}</span>
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

    @if(auth()->user()->type === 'admin')
    <div class="flex w-full justify-end items-center p-6 border-t">
        @if(auth()->user()->id != $profile->id)
        <button @click="impersonate" class="py-2 m-2 px-3 bg-white border border-orange text-orange rounded hover:bg-orange hover:text-white hover:border-orange">Impersonate</button>
        @endif
        <!-- <button @click="impersonate" class="py-2 m-2 px-3 bg-white border border-red text-red rounded hover:bg-red-dark hover:text-white hover:border-red-dark">Delete</button> -->
    </div>
    @endif
</div>

@include('admin.user.image-upload-modal')

@endsection

@section('script')

<script src="{{ mix('/js/cropper.js') }}"></script>

<script>
    // let image_crop = document.getElementById('image_demo').croppie();
    
</script>

<script>


    new Vue({

        el: 'main',

        data: {
            profile: @json($profile),
            passwordHolder: null,
            showPasswordInput: false,

            showImageChangeModal: false,

            showBioInput: false,
            previous_bio: null,

            showTypeInput: false,
            previous_type: null,
            /* below are required to facilitate profile image cropping facility */
            imgSrc: '',
            cropImg: '',
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

            // for changinf profile image
            changeImage: function () {
                @if($profile->id === auth()->user()->id)
                this.imgSrc = this.profile.avatar
                this.showImageChangeModal = true
                @endif
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

            // reads the uploaded profile image and set the same
            setImage(e) {
                const file = e.target.files[0];
                if (!file.type.includes('image/')) {
                    alert('Please select an image file');
                    return;
                }
                if (typeof FileReader === 'function') {
                    const reader = new FileReader();
                    reader.onload = (event) => {
                        this.imgSrc = event.target.result;
                        // rebuild cropperjs with the updated source
                        this.$refs.cropper.replace(event.target.result);
                    };
                    reader.readAsDataURL(file);
                } else {
                    alert('Sorry, FileReader API not supported');
                }
            },

            cropImage() {
                // get image data for post processing, e.g. upload or setting image src
                this.cropImg = this.$refs.cropper.getCroppedCanvas().toDataURL();
            },

            // rotates the image
            rotate() {
                this.$refs.cropper.rotate(90);
            },

            // save the profile image to server
            saveCropImage() {
                let p = this
                const url = '/api/users/' + '{{ auth()->user()->slug }}'

                let form = new FormData;
                form.append("photo", this.cropImg)

                let xhr = new XMLHttpRequest
                xhr.open("POST", url, true)
                xhr.setRequestHeader("X-CSRF-Token", document.head.querySelector('meta[name="csrf-token"]').content)
                xhr.onload = function () {
                    let data = JSON.parse(xhr.responseText)
                    if (xhr.status === 201) {
                        p.profile.avatar = data.url + '?version=' + Math.random()
                        p.showImageChangeModal = false
                    } else {
                        console.log(data)
                        alert(data.message)
                    }
                }
                return xhr.send(form)
            },

            /**
             * Let the logged in user become the user who owns this profile
             */
            impersonate: function () {
                
                @if($profile->type === 'admin')
                // if the profile user is admin, no need to go to frontend
                util.submit("{{ route('profiles.impersonate') }}", {
                    user_id: '{{$profile->id}}'
                });

                @else 
                    // if the profile user is not admin, redirect to frontpage
                    util.ajax('post', "{{ route('profiles.impersonate') }}", {
                        user_id: '{{$profile->id}}'
                    }, function () {
                        location.href="/";
                    })
                @endif
            },

        }
    })
</script>

@endsection