<template>
        <div class="w-full">

                <div class="w-full mx-auto py-4 px-4 bg-grey-lighter flex">
                        <input class="p-2 w-full rounded-l-lg rounded-r-lg sm:rounded-r-none border-l border-r sm:border-r-0 border-t border-b border-blue-lighter bg-white" 
                                type="text" 
                                v-model="query" 
                                @keyup.enter="doSearch" 
                                placeholder="search..."/>
                        <div class="hidden sm:flex relative pin-r rounded-r-lg border-r border-t border-b border-blue-lighter bg-white py-1 px-2  items-center">
                                <span v-if="searchResult" class="py-1 px-2 bg-grey-lighter rounded-lg text-xs whitespace-no-wrap" v-text="searchResult"></span>
                        </div>
                </div>
                
                <div class="w-full flex flex-wrap px-4 image-container overflow-y-scroll">
                        <div v-for="photo in photos" :key="photo.id" class="w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/5">
                                <div class="bg-white shadow mr-4 mb-4">
                                        
                                        <div class="w-full flex items-center justify-center image-contain">
                                                <img :src="'/' + photo.path"/>
                                        </div>

                                        <div class="w-full flex bg-white justify-between text-grey-dark text-xs p-2">
                                                <span v-text="photo.storage.toUpperCase()"></span>
                                                <span>{{ photo.size }} KB</span>
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
                        searchResult: null
                }
        },
        created: function () {
                this.getFromServer()
        },

        methods: {
                doSearch: function () {
                        this.getFromServer(this.query)
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
        .image-contain {
                max-height: 100px;
                min-height: 100px;
                overflow: hidden;
        }

        .image-container {
                max-height: 300px;
        }
</style>

