<base-modal :show="showImageChangeModal" cover="1/3" @close="showImageChangeModal=null">
        
                <h4 slot="header" class="w-full text-blue-dark font-semibold bg-grey-lightest border-blue-lighter border-b py-4 px-8">
                        Profile Picture
                </h4>
                <div class="w-full bg-grey-lighter">
                        <p class="py-2 px-6">Upload or change your profile picture here</p>

                        <div class="block w-full py-2 px-6" v-show="imgSrc && !cropImg">
                                <vue-cropper
                                        ref='cropper'
                                        :guides="true"
                                        :view-mode="2"
                                        drag-mode="crop"
                                        :auto-crop-area="0.9"
                                        :aspect-ratio="1"
                                        :min-container-width="100"
                                        :min-container-height="100"
                                        :background="true"
                                        :rotatable="true"
                                        :src="imgSrc"
                                        alt="Profile Image"
                                        :img-style="{ 'width': '300px', 'height': '300px' }">
                                </vue-cropper>
                                
                        </div>

                        <!-- <form enctype="multipart/form-data" method="post"> -->
                        <div v-if="!cropImg" class="flex justify-between bg-white border-t px-4 py-1 mt-2">
                                <label class="m-2 w-24 text-center px-4 py-2 rounded-lg bg-grey-dark text-white hover:bg-blue-dark cursor-pointer">
                                        <p class="text-sm">Browse</p>
                                        <input type='file' name="image" accept="image/*" class="hidden" @change="setImage" />
                                </label>
                                <div>
                                        <button @click="rotate" v-if="imgSrc" class="h-8 m-2 text-center px-4 py-2 rounded-lg cursor-pointer text-grey-dark border border-grey-dark hover:bg-grey-darker hover:text-white">Rotate</button>
                                        <button @click="cropImage" v-if="imgSrc" class="h-8 m-2 text-center px-4 py-2 rounded-lg border border-blue bg-blue text-white hover:bg-blue-dark cursor-pointer">Crop</button>
                                </div>
                        </div>
                        <!-- </form> -->

                        <img v-if="cropImg" :src="cropImg" style="width: 100px; height: 100px;" class="block border my-2 rounded-full mx-auto" alt="Cropped Image" />
                        <div v-if="cropImg" class="flex justify-between bg-white border-t px-4 py-1 mt-2">
                                <button @click="cropImg=null" class="h-8 m-2 text-center px-4 py-2 rounded-lg cursor-pointer text-grey-dark border border-grey-dark hover:bg-grey-darker hover:text-white">Back</button>
                                <button @click="saveCropImage" class="h-8 m-2 w-24 text-center px-4 py-2 rounded-lg border border-blue bg-blue text-white hover:bg-blue-dark cursor-pointer">Save</button>
                        </div>

                </div>
        
</base-modal>