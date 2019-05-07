<div class="w-full">
            <div class="w-full px-8 pt-4 mb-2 text-indigo font-bold">Amazon Web Services - S3</div>
            <transition name="fade">
                <div v-show="storage_s3_active === 'yes'" class="p-4 w-full flex flex-wrap justify-between">
                    <label class="w-full md:w-1/2 px-4">
                        <span class="uppercase text-xs text-grey-darkest font-medium">AWS Key</span>
                        <input type="text" v-model="storage_s3_key" class="mt-2 mb-4 w-full p-2 bg-grey-lighter rounded" @change="change('storageS3StateClass')">
                    </label>

                    <label class="w-full md:w-1/2 px-4">
                        <span class="uppercase text-xs text-grey-darkest font-medium">AWS Secret</span>
                        <input type="text" v-model="storage_s3_secret" class="mt-2 mb-4 w-full p-2 bg-grey-lighter rounded" @change="change('storageS3StateClass')">
                    </label>

                    <label class="w-full md:w-1/2 px-4">
                        <span class="uppercase text-xs text-grey-darkest font-medium">Region</span>
                        <input type="text" v-model="storage_s3_region" class="mt-2 mb-4 w-full p-2 bg-grey-lighter rounded" @change="change('storageS3StateClass')">
                    </label>

                    <label class="w-full md:w-1/2 px-4">
                        <span class="uppercase text-xs text-grey-darkest font-medium">Bucket</span>
                        <input type="text" v-model="storage_s3_bucket" class="mt-2 mb-4 w-full p-2 bg-grey-lighter rounded" @change="change('storageS3StateClass')">
                    </label>
                </div>
            </transition>

            <div class="py-4 px-8 w-full flex justify-between items-center">
                <label class="text-sm text-grey-darker">
                    <input class="mr-2 leading-tight" v-model="storage_s3_active" @change="change('storageS3StateClass')" type="checkbox" true-value="yes" false-value="no">
                    <span>
                        Enable Amazon S3 for Storage
                    </span>
                </label>

                <div class="my-2">
                    <button @click="save('storageS3StateClass', ['storage_s3_active', 'storage_s3_key', 'storage_s3_secret', 'storage_s3_bucket', 'storage_s3_region'])" :class="storageS3StateClass" class="px-4 py-2 rounded text-white">Save</button>
                </div>
            </div>
        </div><!-- end of s3 -->