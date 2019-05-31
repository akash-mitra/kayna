<template>
        <div class="w-full">
                <div v-show="pane==='gallery'" class="w-full mx-auto py-4 px-4 bg-grey-lighter flex flex-no-wrap">
                        <div class="flex w-full">
                                <input class="p-2 w-full rounded-l-lg rounded-r-lg sm:rounded-r-none border-l border-r sm:border-r-0 border-t border-b border-blue-lighter bg-white" 
                                        type="text" 
                                        v-model="query" 
                                        @keyup.enter="doSearch" 
                                        placeholder="search..."/>
                                <div class="hidden sm:flex relative pin-r rounded-r-lg border-r border-t border-b border-blue-lighter bg-white py-1 px-2  items-center">
                                        <span v-if="searchResult" class="py-1 px-2 bg-grey-lighter rounded-lg text-xs whitespace-no-wrap" v-text="searchResult"></span>
                                </div>
                        </div>
                        <button class="mx-2" title="Upload Image" @click="pane='upload'">
                                <svg class="h-10 w-8 text-blue-dark fill-current hover:bg-blue-lightest hover:text-blue" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                                </svg>
                        </button>
                </div>
                
                <div v-show="pane==='gallery'" class="w-full flex flex-wrap px-4 thumbnail-container overflow-y-scroll">
                        <div v-for="photo in photos" :key="photo.id" class="w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/5">

                                <div class="bg-white shadow mr-4 mb-4 cursor-pointer" @click="select(photo)">                
                                        <div class="w-full flex items-center justify-center thumbnail">
                                                <img v-bind:data-src="photo.url" class="mg-photo"/>
                                        </div>
                                        <div class="w-full flex bg-white justify-between text-grey-dark text-xs p-2">
                                                <span v-text="photo.storage.toUpperCase()"></span>
                                                <span>{{ photo.size }} KB</span>
                                        </div>
                                </div>
                        </div>
                </div>


                <div v-if="pane==='photo'" class="w-full mx-auto py-4 px-4 bg-grey-lighter flex justify-between items-center">
                        <button class="flex items-center" @click="pane='gallery'">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="fill-current h-8 w-8 rounded-full border p-2 text-grey-dark mr-2"><polygon points="3.828 9 9.899 2.929 8.485 1.515 0 10 .707 10.707 8.485 18.485 9.899 17.071 3.828 11 20 11 20 9 3.828 9"/></svg>
                                <p class="text-blue-darker text-xl" v-text="selectedPhoto.name"></p>
                        </button>
                        <span @click="destroy(selectedPhoto.id)" v-if="deletable" class="text-red mr-4 px-2 text-sm py-1 hover:border border-red hover:text-white hover:bg-red rounded cursor-pointer">Delete </span>
                </div>

                <div v-if="pane==='photo'" class="w-full flex justify-center items-center px-4 postcard-container overflow-y-scroll">
                        <div class="w-full bg-white shadow mr-4 mb-4 xl:flex">                
                                <div class="w-full xl:w-4/5 flex items-center justify-center postcard">
                                        <img :src="selectedPhoto.url" class="mg-photo border-2 border-blue-lightest"/>
                                </div>
                                <div class="w-full xl:w-1/5 text-xs px-2 py-2 flex flex-no-wrap xl:flex-wrap xl:content-between justify-between items-center" style="background-color: aliceblue">

                                        <div class="xl:w-full flex xl:flex-wrap justify-start content-start">
                                                <div class="w-full m-2 hidden sm:block">
                                                        <p class="text-grey-dark uppercase">Name</p>
                                                        <p class="text-blue-darker" v-text="selectedPhoto.name"></p>
                                                </div>
                                                <div class="w-full m-2 hidden md:block">
                                                        <p class="text-grey-dark uppercase">Type</p>
                                                        <p class="text-blue-darker" v-text="selectedPhoto.type.toUpperCase()"></p>
                                                </div>
                                                <div class="w-full m-2">
                                                        <p class="text-grey-dark uppercase">Size</p>
                                                        <p class="text-blue-darker">{{ selectedPhoto.size }} KB</p>
                                                </div>
                                                <div class="w-full m-2 hidden lg:block">
                                                        <p class="text-grey-dark uppercase">Storage</p>
                                                        <p class="text-blue-darker" v-text="selectedPhoto.storage.toUpperCase()"></p>
                                                </div>

                                                
                                        </div>
                                        <button v-if="choosable" class="h-10 xl:mx-auto mb-2 xl:w-full1 py-2 px-6 bg-green text-white rounded shadow text-xl" @click="choose">Choose</button>
                                </div>
                        </div>
                </div>

                <div v-if="pane==='upload'" class="w-full p-4 postcard-container overflow-y-scroll">
                        
                        <div class="flex justify-between">
                                <button class="flex items-center" @click="pane='gallery'">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="fill-current h-8 w-8 rounded-full border p-2 text-grey-dark mr-2"><polygon points="3.828 9 9.899 2.929 8.485 1.515 0 10 .707 10.707 8.485 18.485 9.899 17.071 3.828 11 20 11 20 9 3.828 9"/></svg>
                                        <p class="text-grey-dark font-light text-lg hidden sm:block">Back to Gallery</p>
                                </button>
                                <form id='file-catcher' enctype="multipart/form-data" method="post">
                                        <div class="w-full flex bg-grey-lighter">
                                                <label class="flex items-center px-4 py-2 rounded-lg border border-blue bg-white text-blue tracking-wide cursor-pointer hover:bg-blue hover:text-white">
                                                        <svg class="w-8 h-8 mr-4" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                                <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                                                        </svg>
                                                        <p class="text-base leading-normal ">Upload <span class="hidden sm:inline">Media Files</span></p>
                                                        <input id='files' type='file' name="files" multiple class="hidden" @change="uploadFiles" />
                                                </label>
                                        </div>
                                </form>
                        </div>
                        <div id='file-list-display' class="w-full my-4" v-if="uploadableFiles.length > 0">
                                <table class="w-full my-2 text-sm">
                                        <thead>
                                                <tr class="bg-white text-left">
                                                        <th class="p-2 font-light hidden md:block">#</th>
                                                        <th class="p-2 font-light">File Name</th>
                                                        <th class="p-2 font-light">Status</th>
                                                        <th class="p-2 font-light">Progress</th>
                                                </tr>
                                        </thead>
                                        <tbody>
                                                <tr class="p-2 border-b" v-for="(f, index) in uploadableFiles" v-bind:key="index">
                                                        <td v-text="index+1" class="text-left p-2 hidden md:block"></td>
                                                        <td class="text-left p-2" v-text="f.name"></td>
                                                        <td>
                                                                <span v-text="f.status"></span>
                                                        </td>
                                                        <td>
                                                                <progress id="progressBar" :value="f.completion" max="100" class="my-2 w-full"></progress>
                                                        </td>
                                                </tr>
                                        </tbody>
                                </table>
                        </div>
                </div>

                <div class="p-2 bg-white w-full text-sm text-grey-dark rounded" id="message" v-if="message">
                        <span v-text="message"></span>
                </div>
        </div>
</template>

<script>
export default {
        props: {
                deletable: {
                        type: Boolean,
                        default: false
                },
                choosable: {
                        type: Boolean,
                        default: false
                },
                lazyload: {
                        type: Boolean,
                        default: true
                }
        },
        data: function () {
                return {
                        photos: [],
                        message: 'Loading Images...',
                        query: '',
                        searchResult: null,
                        pane: 'gallery',
                        selectedPhoto: {},
                        uploadableFiles: [],
                }
        },
        created: function () {
                this.getFromServer()
        },

        updated: function () {
                this.enableLazyLoad()
        },

        methods: {
                doSearch: function () {
                        this.getFromServer(this.query)
                },

                select: function (photo) {
                        this.pane = 'photo'
                        this.selectedPhoto = photo
                },

                choose: function () {
                        
                        // remove file name extensions
                        let caption = this.selectedPhoto.name.replace(/\.[^/.]+$/, "") 
                        
                        // remove special characters with space
                        caption = caption.replace(/[^\w\s]/gi, ' ') 

                        // uppercase first letter of each word
                        caption = caption.toLowerCase()
                                .split(' ')
                                .map((s) => s.charAt(0).toUpperCase() + s.substring(1))
                                .join(' ');

                        var captionChosen = prompt('Enter an caption for this image', caption);
                        //TODO we should remove any double quote in captionChosen
                        this.selectedPhoto['caption'] = captionChosen;
                        console.log('emit: ');
                        console.log(this.selectedPhoto);
                        this.$emit('selected', this.selectedPhoto)
                },

                uploadFiles: function () {
                        let files = document.getElementById('files').files, p = this;
                        for(let i = 0; i < files.length; i++) {
                                let upf = {
                                        name: files[i].name,
                                        formdata: new FormData(),
                                        ajax: new XMLHttpRequest(),
                                        status: 'Not Started',
                                        completion: 0
                                };
                                
                                upf.formdata.append('media', files[i])
                                upf.formdata.append('name', files[i].name)
                                // upf.formdata.append("Content-Type", files[i].type);
                                
                                upf.ajax.upload.onprogress = function (e) {
                                        upf.status = 'Uploaded ' + Math.round(e.loaded/1000) + ' KB...'
                                        upf.completion = Math.round((e.loaded/e.total)*100)
                                }
                                upf.ajax.upload.onload = function (e) {
                                        upf.status = 'Complete'
                                        upf.completion = 100
                                }
                                upf.ajax.upload.onerror = function (e) {
                                        upf.status = 'Error uploading the file'
                                        upf.completion = 0
                                }
                                // ajax.upload.addEventListener('abort', abortHandler, false);
                                
                                upf.ajax.open('POST', '/admin/media')
                                upf.ajax.setRequestHeader("X-CSRF-Token", document.head.querySelector('meta[name="csrf-token"]').content)
                                upf.ajax.onreadystatechange = function () {
                                        if (upf.ajax.readyState === 4 && upf.ajax.status === 201) {
                                                let photo = JSON.parse(upf.ajax.responseText)
                                                p.photos.push(photo)
                                        }
                                        if (upf.ajax.readyState === 4 && upf.ajax.status != 201) {
                                                upf.status = 'Error uploading the file (Status = ' + upf.ajax.status + ')'
                                                upf.completion = 0
                                        }
                                };
                                upf.ajax.send(upf.formdata)
                                this.uploadableFiles.push(upf)
                        }
                },

                // Gets media data from the server. If a query string is 
                // provided then only returns the data that fulfill
                // the search conditions in query string.
                getFromServer: function (query, callback) {
                        const p = this
                        let url = '/api/media' + ((typeof query != 'undefined' && query != null) ? '?query=' + encodeURIComponent(query):'')
                        axios.get(url)
                        .then(function (response) {
                                p.photos = response.data.data
                                p.message = null
                                p.searchResult = response.data.total + ' image(s)'
                                if (typeof callback != 'undefined') callback.call()
                        })
                        .catch(function (error) {
                                p.message = 'Request failed with ' + error.response.status + ': ' + error.response.statusText
                                if (error.response.status == '403') { // special helpful message for loggedout situations
                                        p.message += '. Make sure you are logged in or refresh the page.'
                                }
                        })
                },


                destroy: function (id) {
                       
                       if (confirm("Are you sure that you want to delete this? \nThis will permanently delete this media. This action is unrecoverable.")) {
                                let p = this
                                axios.delete('/admin/media/' + id)
                                .then(function(response) {
                                        flash({ message: response.data.flash.message })
                                        let id = response.data.photo_id, l = p.photos.length
                                        for (let i = 0; i < l; i++) {
                                                if (p.photos[i].id === id) {
                                                        p.photos.splice(i, 1)
                                                        break
                                                }
                                        }
                                        p.pane = 'gallery'
                                })
                        }      
                },


                // This is an experimental function that enables
                // lazy-loading. This can be toggled via the
                // optional "lazyloading" attribute
                enableLazyLoad: function () {
                        let images = document.querySelectorAll('.mg-photo');
                        
                        const config = {
                                root: document.querySelector('.thumbnail-container'),
                                // If the image gets within 100px in the Y axis, start the download.
                                rootMargin: '0px 0px 50px 0px'
                        };
                        
                        // check if intersection observer is supported via browser
                        if (!('IntersectionObserver' in window) || this.lazyload === false) {
                                // if not, just load all immediately
                                Array.from(images).forEach(function(image) {
                                        console.log('IntersectionObserver unsupported loading')
                                        if(! image.src) image.src = image.dataset.src
                                })
                        } else {
                                // The observer is supported
                                let observer = new IntersectionObserver(function (entries) {
                                        // Loop through the entries
                                        entries.forEach(image => {
                                                // Are we in viewport?
                                                if (image.isIntersecting) {
                                                        // Stop watching and load the image
                                                        //console.log('Loading: ' + image.target.dataset.src)
                                                        observer.unobserve(image.target)
                                                        image.target.src = image.target.dataset.src
                                                }
                                        })
                                }, config)

                                // start observing...
                                images.forEach(image => {
                                        observer.observe(image)
                                })
                        }
                },
        }
}
</script>

<style>
        .thumbnail-container {
                max-height: 450px;
        }
        .thumbnail {
                height: 100px;
                overflow: hidden;
        }

        .postcard-container {
                max-height: 450px;
                
        }
        .postcard {
                max-height: 400px;
                overflow: scroll;
        }

        .mg-photo {
                width: 100%;
                height: 100%;
                object-fit: cover;
        }
        
</style>

