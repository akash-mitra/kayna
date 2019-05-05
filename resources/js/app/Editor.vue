<style>
    trix-toolbar .trix-button-group, trix-toolbar .trix-button, trix-toolbar .trix-button:not(:first-child) {
        border: none
    }

    trix-toolbar .trix-button:hover {
        color: #000
    }

    .trix-button--icon-increase-nesting-level,
    .trix-button--icon-decrease-nesting-level { display: none; }

    trix-toolbar trix-button-group--block-tools {
        border-right: 1px solid #ccc;
        border-left: 1px solid #ccc;
    }
    
</style>
<template>
    <div>
        
        <input type="hidden" id="trix" :name="name" :value="value">

        <trix-editor 
            ref="trix" 
            input="trix" 
            toolbar="my_toolbar" 
            :placeholder="placeholder" 
            class="trix border-none default-page-content" 
            :class="css_class">
        </trix-editor>

    </div>
</template>

<script>

    import Trix from 'trix';

    Trix.config.attachments.preview.caption = {
        name: false,
        size: false
    }
    Trix.config.blockAttributes.heading1.tagName = "h2"
    Trix.config.blockAttributes.heading2 = {
	  tagName: "h3",
	  terminal: true,
	  breakOnReturn: true,
	  group: false
	}
    
    Trix.config.lang.heading2 = 'Sub-heading'


    export default {

        props: {

                name: String,

                value: String,

                placeholder: String,

                css_class: String,

                autohide: Boolean
        },

        mounted() {

            let t = this.$refs.trix
            
            // Things to do when trix initialize
            t.addEventListener('trix-initialize', e => {
                
                if (this.autohide) e.target.toolbarElement.style.display = "none";
                this.addSubHeadingButton(e)
                return this.addUploadButton (e)

            });

            // auto hiding code
            if (this.autohide) {
                
                t.addEventListener("trix-focus", function(event) {

                        event.target.toolbarElement.style.display = "block";
                });
                
                t.addEventListener("trix-blur", function(event) {
                        
                        // do not hide toolbar if there is selected texts
                        let selection = t.editor.getSelectedRange()
                        if (selection[0] == selection[1]) {
                            event.target.toolbarElement.style.display = "none";
                        }
                });
            }

            t.addEventListener('trix-change', e => {
                
                this.$emit('input', e.target.innerHTML)

            });


            t.addEventListener('trix-attachment-add', e => {
                
                var attachment = e.attachment;

                if (attachment.file) {
                    return this.uploadAttachment (attachment)
                }

            });


            t.addEventListener('trix-attachment-remove', e => {
                
                if (confirm("Delete this from the server as well?"))
                    return this.deleteAttachment(e.attachment.attachment.attributes.values.url)
            });

        },

        methods: {

            uploadAttachment: function (attachment) {

                window.onbeforeunload = function(e) {
                    var e = e || window.event;
                    var warn = 'Uploads are pending. If you quit this page they may not be saved.';
                    if (e) {
                        e.returnValue = warn;
                    }
                    return warn;
                };


                let file = attachment.file

                if (file.size == 0) {
                    window.onbeforeunload = function() {};
                    attachment.remove();
                    alert("The file you submitted looks empty.");
                    return;
                    
                } 
                else if (file.size > 37000000) {
                    window.onbeforeunload = function() {};
                    attachment.remove();
                    alert("Your file seems too big for uploading.");
                    return;
                }

                let form = new FormData;
                form.append("Content-Type", file.type)
                form.append("name", file.name)
                form.append("media", file)

                let xhr = new XMLHttpRequest
                xhr.open("POST", "/media", true)
                xhr.setRequestHeader("X-CSRF-Token", document.head.querySelector('meta[name="csrf-token"]').content)
                
                xhr.upload.onprogress = function (event) {
                    let progress = (event.loaded / event.total) * 100
                    return attachment.setUploadProgress(progress) 
                }

                xhr.onload = function () {
                    let data = JSON.parse(xhr.responseText)
                    if (xhr.status === 201) {
                        window.onbeforeunload = function() {};
                        attachment.setAttributes({
                            url: data.url,
                            href: data.url
                        })
                    } else {
                        window.onbeforeunload = function() {};
                        attachment.remove();
                        if (typeof data.message != 'undefined')
                            alert (data.message)
                        else alert("Upload failed. Try to reload the page.")
                    }
                }

                return xhr.send(form)
            },


            deleteAttachment: function (url) {
                axios.post('/media/destroy', { 'url': url })
                .then (function (e) {
                    console.log('Attachement media deleted from the server');
                });
            },

            addUploadButton: function (e) {
                let trix = e.target;
                let toolBar = trix.toolbarElement;

                // Creation of the button
                let button = document.createElement("button");
                button.setAttribute("type", "button");
                button.setAttribute("class", "attach trix-button trix-button--icon trix-button--icon--attach");
                button.setAttribute("data-trix-action", "x-attach");
                button.setAttribute("title", "Attach a file");
                button.setAttribute("tabindex", "-1");
                button.innerText = "Insert an Image";

                // Attachment of the button to the toolBar
                let uploadButton = toolBar.querySelector('.trix-button-group.trix-button-group--block-tools').appendChild(button);

                // When the button is clicked
                uploadButton.addEventListener('click', function() {
                    // Create a temporary file input
                    let fileInput = document.createElement("input");
                    fileInput.setAttribute("type", "file");
                    fileInput.setAttribute("multiple", "");
                    
                    // Add listener on change for this file input
                    fileInput.addEventListener("change", function(event) {
                            var file, _i, _len, _ref, _results;
                            _ref = this.files;
                            _results = [];
                            // Getting files
                            for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                                file = _ref[_i];
                                // pushing them to Trix
                                _results.push(trix.editor.insertFile(file));
                            }
                            return _results;
                    }),
                    
                    // Then virtually click on it
                    fileInput.click()
                });
                return;
            },

            addSubHeadingButton: function (e) {
                let trix = e.target;
                let toolBar = trix.toolbarElement;
                let buttonHTML = "<button type=\"button\" style='color: #666;font-size: 20px;' data-trix-attribute='heading2' title=\"Sub-Heading\">H2</button>";
                toolBar.querySelector(".trix-button--icon-heading-1").insertAdjacentHTML("afterend", buttonHTML);
            }
        }
    }
</script>
