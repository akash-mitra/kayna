@extends('admin.pageform')

@section('css')

        <link rel="stylesheet"  href="/css/admin/trix.css">
        <style>
                /* trix-toolbar { display: none; } */
                h2 { color: red }
        </style>
@endsection

@section('header')
        
        
@endsection


@section('main')


<div class="w-full max-w-lg mx-auto p-8">

        <div class="w-full flex justify-between items-center mb-4">
                <div class="inline-block relative border rounded">
                        <select class="p-2 rounded-lg block appearance-none w-full hover:bg-grey-lightest text-sm text-grey pr-8 cursor-pointer leading-tight focus:outline-none focus:shqadow-outline"
                                v-model="category.value">
                                <option :value="0" selected='selected'>Uncategorised</option>
                                <option v-for="c in categories" v-bind:value="c.id">
                                        @{{ c.name }}
                                </option>
                        </select>
                        <div class="pointer-events-none absolute pin-y pin-r flex items-center px-2 text-grey-darker">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                </div>

                <div>
                        <button class="m-2 py-2 px-4 text-blue-light hover:text-blue" 
                                v-on:click="show_info_modal=true">Review</button>

                        <button class="m-2 py-2 px-4 rounded text-teal border border-teal hover:text-white hover:bg-teal" 
                                v-on:click="confirm">Save</button>
                </div>
        </div>

        <div class="w-full flex flex-col px-2">
                <textarea name="title"  
                        v-model="title" 
                        placeholder="Type page title here" 
                        rows="1" 
                        @input="clearValidations"
                        class="w-full py-2 default-page-title"></textarea>
                <!-- </span> -->
                <ul class="-ml-5 mt-2"><li v-for="e in validations.title" v-text="e" class="text-xs font-normal text-red"></li></ul>
        </div>

        <div class="flex flex-col py-2 px-2 text-sm font-light text-grey-dark">
                <textarea 
                        name="summary"
                        v-model="summary" 
                        placeholder="Provide a short Summary in 2-3 lines" 
                        rows="3" 
                        @input="clearValidations"
                        class="w-full py-2 default-page-summary"></textarea>
                <ul class="-ml-5 mt-2"><li v-for="e in validations.summary" v-text="e" class="text-xs font-normal text-red"></li></ul>
        </div>
        
        
        <editor  
                name="body" 
                v-model="body" 
                :value="body" 
                :autohide=false 
                placeholder="Have your say here...">
        </editor>
        <!-- <textarea v-model="body" class="w-full"></textarea> -->
        
</div>  

<div class="w-full max-w-lg mx-auto flex justify-between my-2 p-4">
        
</div>


<base-modal :show="show_info_modal" cover="2/3" @close="show_info_modal=null">

        <h4 slot="header" class="w-full text-blue-dark font-semibold bg-grey-lightest border-blue-lighter border-b qshadow py-4 px-8 mb-2">
                        Review Page Information
        </h4>

        <div  class="w-full max-w-lg mx-auto px-8 py-2">
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
                        
                        <span class="text-blue cursor-pointer text-xs p-2"
                                v-bind:class="show_quality_checks ? 'border-b-4 border-teal' : ''"
                                @click="showQAChecks()">
                                Quality Check <span v-text="qa.length" v-if="qa.length" class="ml-1 py-1 px-2 bg-indigo-lightest text-xs text-indigo font-bold rounded-full"></span>
                        </span>
                        <span class="text-blue cursor-pointer text-xs p-2"
                                v-bind:class="show_meta_info ? 'border-b-4 border-teal' : ''"
                                @click="showMetaInfo()">Meta Info</span>
                        <span class="text-blue cursor-pointer text-xs p-2"
                                v-bind:class="show_se_preview ? 'border-b-4 border-teal' : ''"
                                @click="showSEPreview()">Search Engine Preview</span>
                        <span class="text-blue cursor-pointer text-xs p-2" 
                                v-text="status === 'Draft' ? 'Publish Now' : 'Unpublish'" 
                                @click="showStatus()"></span>
                </div>

                <div class="border-t -mt-1 mx-4"></div>

                <div class="w-full" v-show="show_quality_checks">
                        <div class="p-4">
                                
                                <div class="flex flex-wrap text-xs text-grey-darker mb-4">
                                        <div v-if="!qa.length">
                                                <svg class="fill-current h-4 w-4 mr-2 text-green"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM6.7 9.29L9 11.6l4.3-4.3 1.4 1.42L9 14.4l-3.7-3.7 1.4-1.42z"/></svg>
                                                <span class="align-top">Well done! All quality checks passed</span>
                                        </div>
                                        <div class="m-1 w-full md:w-2/5" v-for="ele in qa">
                                                <svg class="fill-current h-4 w-4 mr-2" :class="ele.type === 'warning'? 'text-orange' : 'text-green'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg>
                                                <span class="align-top" v-text="ele.message"></span>
                                        </div>     
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
                                                <span   class="hover:underline text-blue cursor-pointer" 
                                                        @click="metadesc=summary">copy it from summary</span> 
                                                above.
                                        </span>
                                </p>

                                <textarea class="w-full text-xs p-2 mb-2 border" 
                                        v-model="metadesc" 
                                        v-if="edit_metadesc" 
                                        placeholder="Provide a summary of the page's content in 160 characters for search engines">
                                </textarea>

                                <div class="w-full text-xs p-2 mb-2 bg-grey-lighter"
                                        v-if="!edit_metadesc" 
                                        v-text="metadesc.length ? metadesc : 'No meta description available'">
                                </div>

                                <span class="w-full hover:underline text-blue cursor-pointer text-xs" 
                                        @click="edit_metadesc=!edit_metadesc"
                                        v-text="(edit_metadesc)?'Done':'Add or Edit'">
                                </span>
                        </div>

                        <div class="sm:w-1/2 p-4" >
                                <h4 class="w-full text-grey-dark font-semibold pb-2">Tags</h4>
                                <p class="text-xs text-grey-darker mb-4">
                                        Add few keywords to tell search engines what the topic of the page is. Keywords will also be used as tags.
                                </p>
                                
                                <div class="w-full text-xs p-2 mb-2 bg-grey-lighter"
                                        v-if="!edit_metakeys">
                                        <span v-if="!metakeys.length">No meta keywords added yet</span>
                                        <p v-if="metakeys.length" v-for="key in metakeys" v-text="key"></p>
                                </div>

                                <textarea class="w-full text-xs p-2 mb-2 border" 
                                        v-model="metakeys_string" 
                                        v-if="edit_metakeys" 
                                        placeholder="Sports, Tennis, Wimbledon">
                                </textarea>

                                <span class="w-full hover:underline text-blue cursor-pointer text-xs" 
                                        @click="edit_metakeys=!edit_metakeys"
                                        v-text="(edit_metakeys)?'Done':'Add or Edit'">
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
                                <div  style="font-size: small; line-height: 1.4">
                                        <span style="color: #808080" >{{ date('d D, Y') }}</span>
                                        <span style="color: #545454" v-text="metadesc.substring(0, 170)"></span>
                                </div>
                        </div>
                        
                </div>
                
        </div>

        <div slot="footer" class="py-4 px-8 border-t">
                <button @click="show_info_modal=null" class="py-2 px-8 rounded border hover:bg-grey-lightest">Close</button>
                <button v-if="id === ''" 
                        @click="createAtServer"
                class="py-2 px-8 pull-right text-white rounded bg-teal hover:bg-teal-dark">Confirm</button>
        </div>
</base-modal>

        
@endsection

@section('script')

    <script src="/js/editor.js"></script>
        
    
    <script>

        let data = {
                id: '{{data_get($page, "id")}}',
                category: { text: '{{ data_get($page, "category.name") }}', value: {{ data_get($page, "category.id", 0) }} },
                title: '{{data_get($page, "title")}}',
                summary: '{{data_get($page, "summary")}}',
                metadesc: '{{data_get($page, "metadesc")}}',
                metakeys_string: '{{data_get($page, "metakeys")}}',
                media_url: '{{data_get($page, "media_url")}}',
                page_url: '{{data_get($page, "url")}}',
                status: '{{data_get($page, "status", "Live")}}',
                body: `{!! data_get($page, "content.body") !!}`,
                ago: '{!! data_get($page, "ago") ?? "Just Now" !!}', 
                categories: @json($categories),

                // validations are used for mandatory checks.
                // If any validation checks fail, form is not saved.
                validations: {
                        title: [], summary: []
                },

                // qa object stores the quality check information.
                qa: [],

                show_info_modal: false,
                show_quality_checks: true,
                show_meta_info: false,
                show_se_preview: false,
                edit_metadesc: false,
                edit_metakeys: false,
                has_error: false,
        };


        new Vue({
                el: 'main',
                data: data,
                computed: {
                        statusColor: function() {
                                switch (this.status) 
                                {
                                        case 'Draft': return 'bg-blue-lightest text-grey-darker'
                                        case 'Live': return 'bg-green-lightest text-green'
                                }
                        },

                        metakeys: function () {
                                return (this.metakeys_string === null) ? [] : this.metakeys_string.split(',').map( item => item.trim() );
                        },
                },

                methods: {
                        /**
                         * This method is invoked when user press the "save" button.
                         * All the mandatory checks are done before saving.
                         * 
                         * If this is an existing article, the article 
                         * is saved immediately. If this is a new 
                         * article, a confirm box is shown.
                         */
                        confirm: function () {
                                if (this.checkMandatory ()) {

                                        if (this.id === '') {
                                                this.showSummary ()
                                        }
                                        else {
                                                this.updateAtServer ()
                                        }
                                }
                        },

                        showSummary: function () {

                                this.qa = this.checkQuality ()
                                this.show_info_modal = true
                        },

                        createAtServer: function (event) {
                                let p = this
                                event.target.innerText = "Saving"
                                
                                axios.post( '/admin/pages', {
                                        category_id: this.category.value,
                                        title: this.title,
                                        summary: this.summary,
                                        metadesc: this.metadesc,
                                        metakeys: this.metakeys_string,
                                        media_url: this.media_url,
                                        page_url: this.page_url,
                                        status: this.status,
                                        body: this.body,
                                }).then (function (response) {
                                        
                                        event.target.innerText = "Save"
                                        
                                        if (response.data.page_id > 0) {
                                                p.id = response.data.page_id
                                                flash({message: response.data.flash.message})
                                                p.show_info_modal = false
                                        }
                                        else {
                                                console.log('something went wrong')
                                                console.log(response)
                                        }
                                });
                        },

                        updateAtServer: function () {
                                console.log(this.category)
                                axios.patch( '/admin/pages/' + this.id, {
                                        id: this.id,
                                        category_id: this.category.value,
                                        title: this.title,
                                        summary: this.summary,
                                        metadesc: this.metadesc,
                                        metakeys: this.metakeys_string,
                                        media_url: this.media_url,
                                        page_url: this.page_url,
                                        status: this.status,
                                        body: this.body,
                                }).then (function (response) {
                                        flash({message: response.data.flash.message})
                                        console.log(response);
                                });
                        },

                        showQAChecks: function () {
                                this.show_quality_checks = true
                                this.show_meta_info = false
                                this.show_se_preview = false
                                this.qa = this.checkQuality()
                        },

                        showMetaInfo: function () {
                                this.show_quality_checks = false
                                this.show_meta_info = true
                                this.show_se_preview = false
                        },

                        showSEPreview: function () {
                                this.show_quality_checks = false
                                this.show_meta_info = false
                                this.show_se_preview = true
                        },

                        showStatus: function () {
                                this.status = (this.status === 'Draft' ? 'Live' : 'Draft')
                        },

                        getCategoryTextFromValue(value) {
                                for(let i = 0; i < this.categories.length; i++)
                                if (this.categories[i].id === value) return this.categories[i].name
                                return 'Uncategorised'
                        },

                        /**
                         * Clears all mandatory check issues
                         */
                        resetValidations: function () {
                                this.validations = { title: [], summary: [] }
                        },

                        /**
                         * Perform mandatory checks on the mandatory
                         * columns stored under "validations" array
                         */
                        checkMandatory: function () {
                                
                                this . resetValidations()
                                let passed = true
                                
                                if (this.title.length === 0) {
                                        this.validations.title.push('No title provided')        
                                        passed = false
                                } 
                                
                                if (this.summary.length === 0) {
                                        this.validations.summary.push('No summary provided')
                                        passed = false
                                }
                                
                                return passed
                        },


                        /**
                         * Clears a specific mandatory error
                         */
                        clearValidations: function (event) {
                                
                                this.validations[event.target.name].length = 0
                        },

                        checkQuality: function () {
                                let checks = []

                                if (this.category.value == 0) checks.push({ type: 'warning', message: 'This page is not part of any category'})
                                if (this.title.length < 5) checks.push ({ type: 'warning', message: 'Title is too short.' })
                                if (this.title.length > 65) checks.push ({ type: 'warning', message: 'Title is a bit too long.' })
                                if (this.title [this.title.length - 1] === '.') checks.push ({ type: 'warning', message: 'Remove the full stop from the title' })
                                if (this.metadesc.length === 0) checks.push ({ type: 'warning', message: 'No meta description available' })

                                return checks
                                
                        },
                        
                        getKeywords: function () {

                                let txt = this.body

                                let singleWordTag = {}, doubleWordTag = {}
                                let l = txt.length, previousCharWasSeperator = false
                                let c = '', word = '', previousWord = ''
                                let ignoreWords = {
                                        'a': true, 'an': true, 'the': true, 'in': true, 'into': true, 'of': true, 'on': true, 'onto': true, 
                                        'between': true, 'and': true, 'to': true, 'at': true, 'if': true, 'but': true, 'this': true, 'that': true, 
                                        'what': true, 'who': true, 'why': true, 'how': true, 'when': true, 'where': true, 'there': true, 'here': true, 
                                        'is': true, 'am': true, 'was': true, 'were': true, 'are': true, 'will': true, 'may': true, 'might': true, 
                                        'should': true, 'would': true, 'than': true, 'by': true, 'it': true, 'I': true, 'you': true, 'we': true, 'he':true, 
                                        'she':true, 'her':true, 'his':true, 'us': true, 'be':true, 'too':true, 'with':true, 'hence':true, 'thus':true, 'let':true, 
                                        'whether':true, 'there': true, 'they':true, 'as':true, 'any':true, 'their':true, 'all':true, 'has':true, 'have':true, 
                                        'had':true, 'either':true, 'having':true, 'up':true, 'down':true, 'must': true, 'for': true, 'i': true
                                }

                                for (let i = 0; i < l; i++)
                                {
                                        c = txt.charAt(i).toLowerCase() // all letters are changed to lower case
                                        
                                        if (c === ' ' || c === '.' || c === ',' || c === '!' || c === ';' || c === '-' || c === '—')  // all separators 
                                        {   
                                                /*
                                                * This code ensures that consecutive punctuations or
                                                * punctuation with space are ignored
                                                */
                                                if (previousCharWasSeperator) {
                                                        continue
                                                }

                                                /*
                                                * If the word we built is one of the ignorable words
                                                * we continue the loop without storing the word
                                                */
                                                if (word in ignoreWords) {
                                                        word = ''
                                                        previousWord = ''
                                                        continue
                                                }
                                        
                                                /*
                                                * Here we build double word tags by concatenating
                                                * the current word with the previous word
                                                */
                                                if (previousWord != '') {
                                                        let twoWords = previousWord + ' ' + word

                                                        /*
                                                        * We store the double word tags and their frequency here
                                                        */
                                                        if (doubleWordTag.hasOwnProperty(twoWords)) {
                                                                doubleWordTag[twoWords] = doubleWordTag[twoWords] + 1;
                                                        } else {
                                                                doubleWordTag[twoWords] = 1;
                                                        }
                                                }

                                                /*
                                                * This code make sure that we do not make a double word
                                                * tag where there is a punctuation in between those words
                                                */
                                                if (c === '.' || c === ',' || c === '!' || c === ';') {
                                                        previousWord = ''
                                                }
                                                else {
                                                        previousWord = word
                                                }


                                                /*
                                                * We store the single word tags and their frequency here
                                                */
                                                if (singleWordTag.hasOwnProperty(word)) {
                                                        singleWordTag[word] = singleWordTag[word] + 1;
                                                } 
                                                else {
                                                        singleWordTag[word] = 1;
                                                }
                                        
                                                /* empty out the variables */
                                                word = ''
                                                previousCharWasSeperator = true
                                        }
                                        else {
                                                /*
                                                * This is where we build the words from the 
                                                * individual characters (except punctuation chars)
                                                */
                                                word += c
                                                previousCharWasSeperator = false
                                        }
                                        
                                }
                                let singleTags = Object.keys(singleWordTag).sort(function (a, b) { return singleWordTag[a] < singleWordTag[b] }).slice(0, 5)
                                let doubleTags = Object.keys(doubleWordTag).sort(function (a, b) { return doubleWordTag[a] < doubleWordTag[b] }).slice(0, 5)

                                return doubleTags.concat(singleTags)

                        }
                }
        })

    </script>

@endsection