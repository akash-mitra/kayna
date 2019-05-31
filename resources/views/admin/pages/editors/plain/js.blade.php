<script src="/js/media-gallery.js"></script>
<script>
        let data = {
                id: '{{data_get($page, "id")}}',
                category: {
                        text: "{{ data_get($page, 'category.name') }}",
                        value: "{{data_get($page, 'category.id', 0)}}"
                },
                title: "{{data_get($page, 'title')}}",
                summary: `{!! data_get($page, 'summary') !!}`,
                metadesc: `{{data_get($page, 'metadesc')}}`,
                metakey_string: "{{data_get($page, 'metakey')}}",
                media_url: '{{data_get($page, "media_url")}}',
                page_url: '{{data_get($page, "url")}}',
                status: '{{data_get($page, "status", "Live")}}',
                body: `{!! data_get($page, "content.body") !!}`,
                ago: '{!! data_get($page, "ago") ?? "Just Now" !!}',
                categories: @json($categories),
                flat: [],
                // validations are used for mandatory checks.
                // If any validation checks fail, form is not saved.
                validations: {
                        title: [],
                        summary: [],
                        body: []
                },

                // qa object stores the quality check information.
                qa: [],
                show_gallery: false,
                show_info_modal: false,
                show_quality_checks: true,
                show_meta_info: false,
                show_se_preview: false,
                edit_metadesc: false,
                edit_metakey: false,
                has_error: false,
        };


        new Vue({
                el: 'main',
                data: data,
                computed: {
                        statusColor: function() {
                                switch (this.status) {
                                        case 'Draft':
                                                return 'bg-blue-lightest text-grey-darker'
                                        case 'Live':
                                                return 'bg-green-lightest text-green'
                                }
                        },

                        metakey: function() {
                                return (this.metakey_string === null) ? [] : this.metakey_string.split(',').map(item => item.trim());
                        },
                },

                created: function() {
                        // console.log('from created')
                        // this.adjustTextAreaHeight('ta_title');
                        // this.adjustTextAreaHeight('ta_summary');
                        // this.adjustTextAreaHeight('ta_body');
                        let root = { 
                                id: 0,
                                name: 'root',
                                children: this.createDataTree(this.categories)
                        }       
                        this.createFlatIndent(this.flat, root) ;
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
                        confirm: function() {
                                if (this.checkMandatory()) {

                                        if (this.id === '') {
                                                this.showSummary()
                                        } else {
                                                this.updateAtServer()
                                        }
                                }
                        },

                        showSummary: function() {

                                this.qa = this.checkQuality()
                                this.show_info_modal = true
                        },

                        createAtServer: function(event) {
                                let p = this
                                event.target.innerText = "Saving"

                                axios.post('/admin/pages', this.mapData()).then(function(response) {

                                        event.target.innerText = "Save"

                                        if (response.data.page_id > 0) {
                                                p.id = response.data.page_id
                                                flash({
                                                        message: response.data.flash.message
                                                })
                                                p.show_info_modal = false
                                        } else {
                                                console.log('something went wrong')
                                                console.log(response)
                                        }
                                });
                        },

                        updateAtServer: function() {
                                //console.log(this.category)
                                axios.patch('/admin/pages/' + this.id, this.mapData()).then(function(response) {
                                        flash({
                                                message: response.data.flash.message
                                        })
                                        //console.log(response);
                                });
                        },

                        mapData: function() {
                                this.title = this.strip(this.title)
                                this.summary = this.strip(this.summary)
                                let mappedData = {
                                        // id: this.id,
                                        category_id: this.category.value,
                                        title: this.title,
                                        summary: this.summary,
                                        metadesc: this.metadesc,
                                        metakey: this.metakey_string,
                                        media_url: this.media_url,
                                        page_url: this.page_url,
                                        status: this.status,
                                        body: this.body,
                                }

                                if (this.id !== '') mappedData['id'] = this.id

                                return mappedData
                        },

                        strip: function(html) {
                                var doc = new DOMParser().parseFromString(html, 'text/html');
                                return doc.body.textContent || "";
                        },

                        insertMedia: function (media) {
                                this.show_gallery = false
                                const ta = document.getElementById('ta_body')
                                let url = '\n<img src="' + media.url + '" alt="' + (media.caption || '') +  '" />\n'
                                this.insertAtCursor(ta, url)
                        },

                        showQAChecks: function() {
                                this.show_quality_checks = true
                                this.show_meta_info = false
                                this.show_se_preview = false
                                this.qa = this.checkQuality()
                        },

                        showMetaInfo: function() {
                                this.show_quality_checks = false
                                this.show_meta_info = true
                                this.show_se_preview = false
                        },

                        showSEPreview: function() {
                                this.show_quality_checks = false
                                this.show_meta_info = false
                                this.show_se_preview = true
                        },

                        showStatus: function() {
                                this.status = (this.status === 'Draft' ? 'Live' : 'Draft')
                        },

                        getCategoryTextFromValue(value) {
                                for (let i = 0; i < this.categories.length; i++)
                                        if (this.categories[i].id === value) return this.categories[i].name
                                return 'Uncategorised'
                        },

                        handleTitleInput: function(event) {
                                this.adjustTextAreaHeight('ta_title');
                                if (event) this.clearValidations(event);
                        },

                        handleSummaryInput: function(event) {
                                this.adjustTextAreaHeight('ta_summary');
                                if (event) this.clearValidations(event);
                        },

                        handleBodyInput: function(event) {
                                // this.adjustTextAreaHeight('ta_body') // use fix height for body
                                // console.log(event.target)
                                if (event) this.clearValidations(event);
                        },

                        adjustTextAreaHeight: function(el) {
                                let element = document.getElementById(el);
                                //element.style.height = 'auto';
                                element.style.height = (element.scrollHeight) + 'px';
                        },

                        /**
                         * Clears all mandatory check issues
                         */
                        resetValidations: function() {
                                this.validations = {
                                        title: [],
                                        summary: []
                                }
                        },

                        /**
                         * Perform mandatory checks on the mandatory
                         * columns stored under "validations" array
                         */
                        checkMandatory: function() {

                                this.resetValidations()
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
                        clearValidations: function(event) {

                                this.validations[event.target.name].length = 0
                        },

                        checkQuality: function() {
                                let checks = []

                                if (this.category.value == 0) checks.push({
                                        type: 'warning',
                                        message: 'This page is not part of any category'
                                })
                                if (this.title.length < 5) checks.push({
                                        type: 'warning',
                                        message: 'Title is too short.'
                                })
                                if (this.title.length > 65) checks.push({
                                        type: 'warning',
                                        message: 'Title is a bit too long.'
                                })
                                if (this.title[this.title.length - 1] === '.') checks.push({
                                        type: 'warning',
                                        message: 'Remove the full stop from the title'
                                })
                                if (this.metadesc.length === 0) checks.push({
                                        type: 'warning',
                                        message: 'No meta description available'
                                })

                                return checks

                        },

                        insertAtCursor: function (txtarea, myValue) {
                                // var scrollPos = txtarea.scrollTop
                                //IE support
                                if (document.selection) {
                                        txtarea.focus();
                                        sel = document.selection.createRange();
                                        sel.text = myValue;
                                }
                                //MOZILLA and others
                                else if (txtarea.selectionStart || txtarea.selectionStart == '0') {
                                        //console.log(txtarea.selectionStart + ' and ' + txtarea.selectionEnd)
                                        var startPos = txtarea.selectionStart;
                                        var endPos = txtarea.selectionEnd;
                                        
                                        // txtarea.value = txtarea.value.substring(0, startPos)
                                        // + myValue
                                        // + txtarea.value.substring(endPos, txtarea.value.length);
                                        this.body = this.body.substring(0, startPos)
                                        + myValue
                                        + this.body.substring(endPos, this.body.length);
                                        // txtarea.selectionStart = endPos + myValue.length;
                                        // txtarea.selectionEnd = endPos + myValue.length;
                                        
                                        // console.log('Before focus selections: (' + txtarea.selectionStart + ', ' + txtarea.selectionEnd + ')');
                                        txtarea.focus();
                                        // txtarea.selectionEnd += myValue.length;
                                        // console.log('After focus new selection end: (' + txtarea.selectionStart + ', ' + txtarea.selectionEnd + ')');
                                        // this.setInputSelection(txtarea, startPos, endPos)
                                        // document.getElementById('ta_body').selectionStart = 0
                                        // document.getElementById('ta_body').selectionEnd = 0
                                        // document.getElementById('ta_body').selectionStart = 0
                                        // document.getElementById('ta_body').focus()
                                        txtarea.setSelectionRange(startPos, endPos + endPos.length)
                                } else {
                                        txtarea.value += myValue;
                                }

                                // txtarea.scrollTop = scrollPos;
                                
                        },

                        createDataTree:  function (dataset) {
                                let hashTable = Object.create(null)
                                dataset.forEach( aData => hashTable[aData.id] = { ...aData, children : [] } )
                                let dataTree = []
                                dataset.forEach( aData => {
                                        if( aData.parent_id ) hashTable[aData.parent_id].children.push(hashTable[aData.id])
                                        else dataTree.push(hashTable[aData.id])
                                } )
                                return dataTree
                        },

                        /**
                         * This function takes a tree structure and flattens it with indentation
                         */
                        createFlatIndent: function (struct, tree, level) {
                                if (typeof level === 'undefined') level = 0;
                                let indentation = '';
                                for (let i =1; i < level; i++) indentation += "\u2014";
                                struct.push({
                                        id: tree.id,
                                        name: indentation + ' ' + tree.name,
                                        level: level
                                });
                                // struct.push("name=" + tree.name + " at level=" + level)
                                if (tree.children.length > 0) {
                                        level += 1;
                                        for(let i = 0; i < tree.children.length; i++) {
                                                let t = tree.children[i]
                                                // indentedStructure.push (this.createFlatIndent(t, level))
                                                this.createFlatIndent(struct, t, level)
                                        }
                                } 

                                // return indentedStructure;
                                
                        },

                        getKeywords: function() {

                                var span = document.createElement('span');
                                span.innerHTML = this.body;
                                let txt = span.textContent || span.innerText;

                                let singleWordTag = {},
                                        doubleWordTag = {}
                                let l = txt.length,
                                        previousCharWasSeperator = false
                                let c = '',
                                        word = '',
                                        previousWord = ''
                                let ignoreWords = {
                                        'a': true,
                                        'an': true,
                                        'the': true,
                                        'in': true,
                                        'into': true,
                                        'of': true,
                                        'on': true,
                                        'or': true,
                                        'onto': true,
                                        'between': true,
                                        'and': true,
                                        'to': true,
                                        'at': true,
                                        'if': true,
                                        'but': true,
                                        'this': true,
                                        'that': true,
                                        'what': true,
                                        'who': true,
                                        'why': true,
                                        'how': true,
                                        'when': true,
                                        'where': true,
                                        'there': true,
                                        'here': true,
                                        'is': true,
                                        'am': true,
                                        'was': true,
                                        'were': true,
                                        'are': true,
                                        'will': true,
                                        'may': true,
                                        'might': true,
                                        'should': true,
                                        'would': true,
                                        'than': true,
                                        'by': true,
                                        'it': true,
                                        'I': true,
                                        'my': true,
                                        'me': true,
                                        'you': true,
                                        'your': true,
                                        'we': true,
                                        'he': true,
                                        'she': true,
                                        'her': true,
                                        'his': true,
                                        'our': true,
                                        'us': true,
                                        'be': true,
                                        'too': true,
                                        'with': true,
                                        'hence': true,
                                        'thus': true,
                                        'let': true,
                                        'whether': true,
                                        'there': true,
                                        'they': true,
                                        'as': true,
                                        'any': true,
                                        'their': true,
                                        'all': true,
                                        'has': true,
                                        'have': true,
                                        'had': true,
                                        'either': true,
                                        'having': true,
                                        'up': true,
                                        'down': true,
                                        'must': true,
                                        'for': true,
                                        'i': true,
                                        // verbs
                                        'go': true,
                                        'going': true,
                                        'went': true,
                                        'gone': true,
                                        'write': true,
                                        'wrote': true,
                                        'written': true,
                                        'come': true,
                                        'coming': true,
                                        'came': true,
                                        'call': true,
                                        'calling': true,
                                        'called': true,
                                        'see': true,
                                        'seen': true,
                                        'saw': true,
                                        'eat': true,
                                        'eating': true,
                                        'eaten': true,
                                        'talk': true,
                                        'talking': true,
                                        'talked': true,
                                        'make': true,
                                        'making': true,
                                        'made': true,
                                        'give': true,
                                        'giving': true,
                                        'gave': true,
                                        'take': true,
                                        'taking': true,
                                        'taken': true,
                                        'like': true,
                                        'liking': true,
                                        'liked': true,
                                        'do': true,
                                        'doing': true,
                                        'done': true,
                                        'begin': true,
                                        'beginning': true,
                                        'began': true,
                                        'end': true,
                                        'ending': true,
                                        'ended': true,
                                        'look': true,
                                        'looking': true,
                                        'looked': true,
                                        'first': true,
                                        'firstly': true,
                                        'change': true,
                                        'changing': true,
                                        'changed': true,
                                        'discuss': true,
                                        'discussed': true,
                                        'discussing': true,
                                        'follow': true,
                                        'followed': true,
                                        'following': true,
                                        'suppose': true,
                                        'imagine': true,
                                        'under': true,
                                        'over': true,
                                        'now': true,
                                        'then': true,
                                        'later': true,
                                }

                                for (let i = 0; i < l; i++) {
                                        c = txt.charAt(i).toLowerCase() // all letters are changed to lower case

                                        if (c === ' ' || c === '.' || c === ',' || c === '!' || c === ';' || c === '-' || c === '—' || c === '\n' || c === '\r' || c === '\t') // all separators 
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
                                                if ((word in ignoreWords) || !isNaN(word)) {
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
                                                } else {
                                                        previousWord = word
                                                }


                                                /*
                                                 * We store the single word tags and their frequency here
                                                 */
                                                if (singleWordTag.hasOwnProperty(word)) {
                                                        singleWordTag[word] = singleWordTag[word] + 1;
                                                } else {
                                                        singleWordTag[word] = 1;
                                                }

                                                /* empty out the variables */
                                                word = ''
                                                previousCharWasSeperator = true
                                        } else {
                                                /*
                                                 * This is where we build the words from the 
                                                 * individual characters (except punctuation chars)
                                                 */
                                                word += c
                                                previousCharWasSeperator = false
                                        }

                                }
                                let singleTags = Object.keys(singleWordTag).sort(function(a, b) {
                                        return singleWordTag[a] < singleWordTag[b]
                                }).slice(0, 3)
                                let doubleTags = Object.keys(doubleWordTag).sort(function(a, b) {
                                        return doubleWordTag[a] < doubleWordTag[b]
                                }).slice(0, 3)
                                
                                return singleTags.concat(doubleTags)

                        }
                }
        })
</script>