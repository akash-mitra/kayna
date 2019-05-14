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
                        <button class="mx-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="h-8 w-8 p-2 text-grey-dark fill-current border rounded-full"><path d="M13 10v6H7v-6H2l8-8 8 8h-5zM0 18h20v2H0v-2z"/></svg>
                        </button>
                </div>
                
                <div v-show="pane==='gallery'" class="w-full flex flex-wrap px-4 thumbnail-container overflow-y-scroll">
                        <div v-for="photo in photos" :key="photo.id" class="w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/5">

                                <div class="bg-white shadow mr-4 mb-4 cursor-pointer" @click="select(photo)">                
                                        <div class="w-full flex items-center justify-center thumbnail">
                                                <img :src="photo.url" class="mg-photo"/>
                                        </div>
                                        <div class="w-full flex bg-white justify-between text-grey-dark text-xs p-2">
                                                <span v-text="photo.storage.toUpperCase()"></span>
                                                <span>{{ photo.size }} KB</span>
                                        </div>
                                </div>
                        </div>
                </div>


                <div v-if="pane==='photo'" class="w-full mx-auto py-4 px-4 bg-grey-lighter flex">
                        <button class="flex items-center" @click="pane='gallery'">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="fill-current h-8 w-8 rounded-full border p-2 text-grey-dark mr-2"><polygon points="3.828 9 9.899 2.929 8.485 1.515 0 10 .707 10.707 8.485 18.485 9.899 17.071 3.828 11 20 11 20 9 3.828 9"/></svg>
                                <p class="text-blue-darker text-xl" v-text="selectedPhoto.name"></p>
                        </button>
                </div>

                <div v-if="pane==='photo'" class="w-full flex justify-center items-center px-4 postcard-container overflow-y-scroll">
                        <div class="w-full bg-white shadow mr-4 mb-4 xl:flex">                
                                <div class="w-full xl:w-4/5 flex items-center justify-center postcard">
                                        <img :src="selectedPhoto.url" class="mg-photo"/>
                                </div>
                                <div class="w-full xl:w-1/5 text-xs p-2 flex flex-no-wrap xl:flex-wrap xl:content-between justify-between items-center" style="background-color: aliceblue">

                                        <button class="h-10 xl:mx-auto mb-2 xl:w-full py-2 px-6 bg-green text-white rounded shadow text-xl" @click="choose">Choose</button>

                                        <div class="xl:w-full flex xl:flex-wrap justify-start content-start">
                                                <div class="w-full m-2">
                                                        <p class="text-grey-dark uppercase">Name</p>
                                                        <p class="text-blue-darker" v-text="selectedPhoto.name"></p>
                                                </div>
                                                <div class="w-full m-2 hidden lg:block">
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
                                        
                                </div>
                        </div>
                </div>

                <div class="p-2 bg-white w-full text-sm text-grey-dark rounded" id="message" v-if="message">
                        <span v-text="message"></span>
                </div>
        </div>
</template>

<script>
export default {
        props: ['readonly'],
        data: function () {
                return {
                        photos: [],
                        message: 'Loading Images...',
                        query: '',
                        searchResult: null,
                        pane: 'gallery',
                        selectedPhoto: {}
                }
        },
        created: function () {
                this.getFromServer()
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
                        this.$emit('selected', this.selectedPhoto)
                },

                getFromServer: function (query) {
                        const p = this
                        let url = '/api/media' + (typeof query != 'undefined'? '?query=' + encodeURIComponent(query):'')
                        axios.get(url)
                        .then(function (response) {
                                p.photos = response.data.data
                                p.message = null
                                p.searchResult = response.data.total + ' image(s)'
                        })
                        .catch(function (error) {
                                p.message = 'Request failed with ' + error.response.status + ': ' + error.response.statusText
                                if (error.response.status == '403') { // special helpful message for loggedout situations
                                        p.message += '. Make sure you are logged in or refresh the page.'
                                }
                        })
                }
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

