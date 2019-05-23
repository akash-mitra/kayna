<base-modal :show="showImageChangeModal" cover="1/3" @close="showImageChangeModal=null">
        
                <h4 slot="header" class="w-full text-blue-dark font-semibold bg-grey-lightest border-blue-lighter border-b py-4 px-8">
                        Profile Picture
                </h4>
                <div class="w-full bg-grey-lighter px-6 py-2 flex flex-col">
                        <p class="py-2">Upload or change your profile picture here</p>

                        <div class="border block w-full" v-show="imgSrc && !cropImg">
                                <vue-cropper
                                        ref='cropper'
                                        :guides="true"
                                        :view-mode="2"
                                        drag-mode="crop"
                                        :auto-crop-area="0.5"
                                        :min-container-width="250"
                                        :min-container-height="180"
                                        :background="true"
                                        :rotatable="true"
                                        :src="imgSrc"
                                        alt="Profile Image"
                                        :img-style="{ 'width': '400px', 'height': '300px' }">
                                </vue-cropper>
                                
                        </div>

                        <!-- <form enctype="multipart/form-data" method="post"> -->
                                <div v-if="!cropImg" class="flex justify-between">
                                        <label class="m-2 w-24 text-center px-4 py-2 rounded-lg bg-grey-dark text-white hover:bg-blue-dark cursor-pointer">
                                                <p class="text-sm">Browse</p>
                                                <input type='file' name="image" accept="image/*" class="hidden" @change="setImage" />
                                        </label>
                                        <div>
                                                <button @click="rotate" v-if="imgSrc" class="m-2 text-center px-4 py-2 rounded-lg cursor-pointer text-grey-dark border border-grey-dark hover:bg-grey-darker hover:text-white">Rotate</button>
                                                <button @click="cropImage" v-if="imgSrc" class="m-2 text-center px-4 py-2 rounded-lg border border-blue bg-blue text-white hover:bg-blue-dark cursor-pointer">Crop</button>
                                        </div>
                                </div>
                        <!-- </form> -->

                        <img v-if="cropImg" :src="cropImg" style="width: 200px; height: 150px;" class="border my-2" alt="Cropped Image" />
                        <div class="flex justify-between">
                                <button v-if="cropImg" @click="cropImg=null" class="m-2 text-center px-4 py-2 rounded-lg cursor-pointer text-grey-dark border border-grey-dark hover:bg-grey-darker hover:text-white">Back</button>
                                <button v-if="cropImg" @click="saveCropImage" class="m-2 w-24 text-center px-4 py-2 rounded-lg border border-blue bg-blue text-white hover:bg-blue-dark cursor-pointer">Save</button>
                        </div>

                </div>
        
</base-modal>