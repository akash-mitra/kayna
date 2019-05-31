<div class="w-full bg-white border-b z-20 sticky pin-t py-1">
        <div class="max-w-lg mx-auto px-4">
                <div class="flex justify-between items-center">
                        <div class="inline-block relative rounded">
                                <select class="py-2 rounded-lg block appearance-none w-full hover:bg-grey-lightest text-sm text-blue pr-8 cursor-pointer leading-tight focus:outline-none" v-model="category.value">
                                        <option :value="0" selected='selected'>Select Category</option>
                                        
                                        <option v-for="category in flat" v-if="category.id>0" :value="category.id" v-bind:key="category.id">                        
                                                @{{ category.name }}
                                        </option>
                                </select>
                                <div class="pointer-events-none absolute pin-y pin-r flex items-center px-2 text-grey-darker ">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" /></svg>
                                </div>
                        </div>

                        <div class="">
                                <button class="m-2 py-2 px-4 text-sm text-blue-light hover:text-blue" v-on:click="show_gallery=true">Gallery</button>
                                <button class="m-2 py-2 px-4 text-sm text-blue-light hover:text-blue" v-on:click="show_info_modal=true; qa = checkQuality()">Review</button>
                                <button class="m-2 py-2 px-4 text-sm1 font-bold rounded text-teal border-teal hover:text-white hover:bg-teal" v-on:click="confirm">Save</button>
                        </div>
                </div>
        </div>
</div>

<div class="w-full max-w-lg mx-auto p-4 mt-2">

        <div class="w-full flex flex-col">
                <span class="uppercase tracking-wide text-grey-dark text-sm">Title</span>
                <textarea name="title" id="ta_title" v-model="title" placeholder="Title" rows="1" @input="handleTitleInput" class="w-full resize-y p-4 text-2xl bg-blue-lightest rounded my-4 border border-blue-lighter font-serif"></textarea>

                <ul class="-ml-5 mt-2">
                        <li v-for="e in validations.title" v-text="e" class="text-xs font-normal text-red"></li>
                </ul>
        </div>

        <div class="flex flex-col py-2">
                <span class="uppercase tracking-wide text-grey-dark text-sm">Summary</span>
                <textarea name="summary" id="ta_summary" v-model="summary" placeholder="Short Summary" rows="4" @input="handleSummaryInput" class="w-full resize-y p-4 italic bg-blue-lightest rounded my-4 border border-blue-lighter font-sans"></textarea>
                <ul class="-ml-5 mt-2">
                        <li v-for="e in validations.summary" v-text="e" class="text-xs font-normal text-red"></li>
                </ul>
        </div>


        <div class="w-full py-2">
                <span class="uppercase tracking-wide text-grey-dark text-sm">Content</span>
                <textarea name="body" id="ta_body" v-model="body" placeholder="Tell your story..." rows="20" @input="handleBodyInput" class="w-full h-64 resize-y--unuse p-4 text-sm bg-blue-lightest rounded my-4 border border-blue-lighter font-mono"></textarea>

        </div>
</div>


<base-modal :show="show_gallery" cover="3/4" @close="show_gallery=null">
        <h4 slot="header" class="w-full text-blue-dark font-semibold bg-grey-lightest border-blue-lighter border-b py-4 px-8">
                Media Gallery
        </h4>
        <div class="w-full bg-grey-lighter">
                <media-gallery @selected="insertMedia" choosable></media-gallery>
        </div>
        
</base-modal>
<base-modal :show="show_info_modal" cover="2/3" @close="show_info_modal=null">

        <h4 slot="header" class="w-full text-blue-dark font-semibold bg-grey-lightest border-blue-lighter border-b qshadow py-4 px-8 mb-2">
                Review Page Information
        </h4>

        <div class="w-full max-w-lg mx-auto px-8 py-2">
                <div class="w-full flex items-center px-4">
                        <p class="text-blue-dark text-xl" v-text="title"></p>
                        <p class="rounded-lg p-2 ml-2" :class="statusColor" v-text="status">Draft</p>
                </div>
                <div class="w-full flex justify-left flex-wrap my-1 px-4">

                        <div class="pr-2 rounded-lg text-center">
                                <p>
                                        <span class="text-xs  font-bold text-grey">Last Updated </span>
                                        <span class="text-xs text-grey-darker" v-text="ago">Tue 6 Nov 2018</span>
                                </p>
                        </div>
                        <div class="pr-2 rounded-lg text-center">
                                <p>
                                        <span class="text-xs  font-bold text-grey">By </span>
                                        <span class="text-xs text-grey-darker">{{ Auth::user()->name }}</span>
                                </p>
                        </div>
                        <div class="pr-2 rounded-lg text-center">
                                <p>
                                        <span class="text-xs  font-bold text-grey">Under </span>
                                        <span class="text-xs text-grey-darker" v-text="getCategoryTextFromValue(category.value)"></span>
                                </p>
                        </div>

                </div>

                <div class="w-full flex flex-no-wrap mt-4 px-4">

                        <span class="text-blue cursor-pointer text-xs p-2" v-bind:class="show_quality_checks ? 'border-b-4 border-teal' : ''" @click="showQAChecks()">
                                Quality Check <span v-text="qa.length" v-if="qa.length" class="ml-1 py-1 px-2 bg-indigo-lightest text-xs text-indigo font-bold rounded-full"></span>
                        </span>
                        <span class="text-blue cursor-pointer text-xs p-2" v-bind:class="show_meta_info ? 'border-b-4 border-teal' : ''" @click="showMetaInfo()">Meta Info</span>
                        <span class="text-blue cursor-pointer text-xs p-2" v-bind:class="show_se_preview ? 'border-b-4 border-teal' : ''" @click="showSEPreview()">Search Engine Preview</span>
                        <span class="text-blue cursor-pointer text-xs p-2" v-text="status === 'Draft' ? 'Publish Now' : 'Unpublish'" @click="showStatus()"></span>
                </div>

                <div class="border-t -mt-1 mx-4"></div>

                <div class="w-full" v-show="show_quality_checks">
                        <div class="p-4">
                                <p class="text-xs text-grey-dark mb-2 py-1">Quality Checks</p>
                                <div class="flex flex-wrap text-xs text-grey-darker mb-4">
                                        <div v-if="!qa.length">
                                                <svg class="fill-current h-4 w-4 mr-2 text-green" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                        <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM6.7 9.29L9 11.6l4.3-4.3 1.4 1.42L9 14.4l-3.7-3.7 1.4-1.42z" /></svg>
                                                <span class="align-top">Well done! All quality checks passed</span>
                                        </div>
                                        <div class="m-1 w-full md:w-2/5" v-for="ele in qa">
                                                <svg class="fill-current h-4 w-4 mr-2" :class="ele.type === 'warning'? 'text-orange' : 'text-green'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                        <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z" /></svg>
                                                <span class="align-top" v-text="ele.message"></span>
                                        </div>
                                </div>
                                <p class="text-xs text-grey-dark mt-6 mb-2 py-1">Keyword Scanner</p>
                                <div class="flex flex-wrap text-xs text-grey-darker mb-4">
                                        <span v-for="word in getKeywords()" v-text="word" class="p-1 border border-blue bg-blue-lightest text-blue text-xs m-1"></span>
                                </div>
                        </div>

                </div>

                <div class="w-full sm:flex" v-show="show_meta_info">

                        <div class="sm:w-1/2 p-4">
                                <h4 class="w-full text-grey-dark font-semibold pb-2">Description</h4>
                                <p class="text-xs text-grey-darker mb-4">
                                        Provide a summary of the page's content in 160 characters for search engines.
                                        <span v-if="summary.length > 0">
                                                You may also
                                                <span class="hover:underline text-blue cursor-pointer" @click="metadesc=summary">copy it from summary</span>
                                                above.
                                        </span>
                                </p>

                                <textarea class="w-full text-xs p-2 mb-2 border" v-model="metadesc" v-if="edit_metadesc" placeholder="Provide a summary of the page's content in 160 characters for search engines">
                                </textarea>

                                <div class="w-full text-xs p-2 mb-2 bg-grey-lighter" v-if="!edit_metadesc" v-text="metadesc.length ? metadesc : 'No meta description available'">
                                </div>

                                <span class="w-full hover:underline text-blue cursor-pointer text-xs" @click="edit_metadesc=!edit_metadesc" v-text="(edit_metadesc)?'Done':'Add or Edit'">
                                </span>
                        </div>

                        <div class="sm:w-1/2 p-4">
                                <h4 class="w-full text-grey-dark font-semibold pb-2">Tags</h4>
                                <p class="text-xs text-grey-darker mb-4">
                                        Add few keywords to tell search engines what the topic of the page is. Keywords will also be used as tags.
                                </p>

                                <div class="w-full text-xs p-2 mb-2 bg-grey-lighter" v-if="!edit_metakey">
                                        <span v-if="!metakey.length">No meta keywords added yet</span>
                                        <p v-if="metakey.length" v-for="key in metakey" v-text="key"></p>
                                </div>

                                <textarea class="w-full text-xs p-2 mb-2 border" v-model="metakey_string" v-if="edit_metakey" placeholder="Sports, Tennis, Wimbledon">
                                </textarea>

                                <span class="w-full hover:underline text-blue cursor-pointer text-xs" @click="edit_metakey=!edit_metakey" v-text="(edit_metakey)?'Done':'Add or Edit'">
                                </span>
                        </div>
                </div>

                <div class="w-full" v-show="show_se_preview">

                        <h4 class="w-full text-grey-dark font-semibold p-4">Search Engine Preview</h4>

                        <p class="text-xs text-grey-darker px-4">
                                This is how your page may appear in search engine results
                        </p>

                        <div style="font-family: arial,sans-serif; font-weight: normal" class="m-4 p-4 bg-grey-lightest shadow-inner">
                                <h3 style="color: #1a0dab; font-size: 18px; font-weight: normal" v-text="title.length > 0 ? title : '[Page title goes here]'"></h3>
                                <div style="color: #006621; font-size: 14px" v-text="page_url"></div>
                                <div style="font-size: small; line-height: 1.4">
                                        <span style="color: #808080">{{ date('d D, Y') }}</span>
                                        <span style="color: #545454" v-text="metadesc.substring(0, 170)"></span>
                                </div>
                        </div>

                </div>

        </div>

        <div slot="footer" class="py-4 px-8 border-t">
                <button @click="show_info_modal=null" class="py-2 px-8 rounded border hover:bg-grey-lightest">Close</button>
                <button v-if="id === ''" @click="createAtServer" class="py-2 px-8 pull-right text-white rounded bg-teal hover:bg-teal-dark">Confirm</button>
        </div>
</base-modal>