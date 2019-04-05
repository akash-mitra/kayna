<template>
        <div v-if="show" @click="closeModal" class="absolute pin-t pin-l h-screen w-screen z-50" style="background-color: rgba(0,0,0,0.5)">
                <div class="container mx-auto h-full flex justify-center items-center">
                        <div :class="widthClass" @click.stop class="bg-white shadow-lg border border-grey-darker">

                                <div class="w-full flex items-center justify-between">
                                        <slot name="header"></slot>
                                        <span @click="closeModal" class="hover:text-grey-darkest cursor-pointer p-4 -ml-12">
                                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M10 8.586L2.929 1.515 1.515 2.929 8.586 10l-7.071 7.071 1.414 1.414L10 11.414l7.071 7.071 1.414-1.414L11.414 10l7.071-7.071-1.414-1.414L10 8.586z"/></svg>
                                        </span>
                                </div>

                                <div class="w-full">
                                        <slot></slot>
                                </div>

                                <div class="w-full">
                                    <slot name="footer"></slot>
                                </div>
                        </div>
                </div>
        </div>
</template>

<script>
    export default {

        props: ['show', 'cover'],

        computed: {

                widthClass: function () {
                        return 'sm:min-w-fill w-full lg:w-' + this.cover
                }
        },

        created: function () {
                document.addEventListener("keydown", (e) => {
                        if (this.show && e.keyCode == 27) {
                                this.closeModal()
                        }
                })
        },

        methods: {
                closeModal: function () {
                        
                        this.$emit('close')

                }
        }
    }
</script>
