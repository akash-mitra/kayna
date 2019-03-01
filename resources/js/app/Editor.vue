<style>
    trix-toolbar .trix-button-group, trix-toolbar .trix-button, trix-toolbar .trix-button:not(:first-child) {
        border: none
    }

    trix-toolbar .trix-button:hover {
        color: #000
    }
</style>
<template>
    <div>
        
        <input type="hidden" id="trix" :name="name" :value="value">

        <trix-editor 
            ref="trix" 
            input="trix" 
            :placeholder="placeholder" 
            class="trix border-none mt-2 -ml-1 font-sans default-page-content">
        </trix-editor>

    </div>
</template>

<script>

    import Trix from 'trix';

    Trix.config.attachments.preview.caption = {
        name: false,
        size: false
    }

    export default {

        props: {

                name: String,

                value: String,

                placeholder: String,

                autohide: Boolean
        },

        mounted() {


            this.$refs.trix.addEventListener('trix-initialize', e => {
                
                if (this.autohide) e.target.toolbarElement.style.display = "none";
                
                return this.addUploadButton (e)

            });

            if (this.autohide) {
                
                this.$refs.trix.addEventListener("trix-focus", function(event) {

                        event.target.toolbarElement.style.display = "block";
                });
                
                this.$refs.trix.addEventListener("trix-blur", function(event) {

                        event.target.toolbarElement.style.display = "none";
                });
            }

            this.$refs.trix.addEventListener('trix-change', e => {
                
                this.$emit('input', e.target.innerHTML)

            });


            this.$refs.trix.addEventListener('trix-attachment-add', e => {
                
                var attachment = e.attachment;

                if (attachment.file) {
                    return this.uploadAttachment (attachment)
                }

            });


            this.$refs.trix.addEventListener('trix-attachment-remove', e => {
                
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
                button.innerText = "Attach a file";

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
            }
        }
    }
</script>
