
<template>
        <div class="flex items-center cursor-pointer" @click="toggle">
                <div class="h-6 border rounded-l-full rounded-r-full flex items-center mr-2" title="Toggle the value" :class="flipStyle">
                <!-- <transition>         -->
                                <div class="w-6 h-6 rounded-full shadow" :class="'bg-' + styleColor"></div>
                        
                <!-- </transition> -->
                </div>
                <div>
                        <slot></slot>
                </div>
        </div>
</template>
<script>
    export default {
            
        props: {
                state: {
                        type: Boolean,
                        default: false
                },
                color: {
                        type: String,
                        default: 'green'
                },
                width: {
                        type: String,
                        default: '16'
                }
        },

        computed: {
                
                styleColor: function () {
                        if (this.state) {
                                return this.color
                        }
                        return 'grey'
                },
                flipStyle: function () {
                        return 'w-' + this.width + ' bg-' + this.styleColor + '-lightest border-' + this.styleColor + ' ' + (this.state?'justify-end':'justify-start')
                }
        },

        methods: {
                toggle: function () {
                        this.$emit('toggle')
                }
        }
    }
</script>
