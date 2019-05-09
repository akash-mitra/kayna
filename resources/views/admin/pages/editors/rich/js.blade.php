<script src="/js/editor.js"></script>


<script>

let data = {
        id: '{{data_get($page, "id")}}',
        category: { text: '{{ data_get($page, "category.name") }}', value: {{ data_get($page, "category.id", 0) }} },
        title: '{{data_get($page, "title")}}',
        
        summary: `{{data_get($page, "summary")}}`,
        metadesc: `{{data_get($page, "metadesc")}}`,
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
        el: '#trix-main',
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
                        
                        axios.post( '/admin/pages', this.mapData()).then (function (response) {
                                
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
                        axios.patch( '/admin/pages/' + this.id, this.mapData()).then (function (response) {
                                flash({message: response.data.flash.message})
                                console.log(response);
                        });
                },

                mapData: function () {
                        this.title = this.strip(this.title)
                        this.summary = this.strip(this.summary)
                        let mappedData = {
                                // id: this.id,
                                category_id: this.category.value,
                                title: this.title,
                                summary: this.summary,
                                metadesc: this.metadesc,
                                metakeys: this.metakeys_string,
                                media_url: this.media_url,
                                page_url: this.page_url,
                                status: this.status,
                                body: this.body,
                        }
                        
                        if (this.id !== '') mappedData['id'] = this.id

                        return mappedData
                },

                strip: function (html) {
                        var doc = new DOMParser().parseFromString(html, 'text/html');
                        return doc.body.textContent || "";
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

                handleTitleInput: function (event) {
                        let element = event.target;
                        element.style.height = 'auto';
                        element.style.height = (element.scrollHeight) + 'px';
                        this.clearValidations(event);
                },

                handleSummaryInput: function (event) {
                        let element = document.getElementById('ta_summary');
                        element.style.height = 'auto';
                        element.style.height = (element.scrollHeight) + 'px';
                        this.clearValidations(event);
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