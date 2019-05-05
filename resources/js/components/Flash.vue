<template>
    <div class="shadow-lg rounded px-8 py-2 alert-position"
         :class="'border-'+color+' text-'+color+'-dark bg-'+color+'-lightest'"
         role="alert"
         v-show="show">
                <div class="p-2 flex items-center">
                    <span v-html="icon()"></span>
                    <span v-text="body"></span>
                </div>       
    </div>
</template>

<script>
    export default {
        props: ['message'],

        data() {
            return {
                body: this.message,
                type: 'success',
                show: false
            }
        },

        created() {
            if (this.message) {
                this.flash();
            }

            window.events.$on('flash', data => this.flash(data));
        },

        methods: {
            flash(data) {
                if (data) {
                    this.body = data.message;
                    this.type = data.type;
                }

                this.show = true;

                this.hide();
            },

            hide() {
                setTimeout(() => {
                    this.show = false;
                }, 3000);
            },

            icon() {
                if (this.type === 'error') {
                    return '<svg class="fill-current h-8 w-8 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path class="heroicon-ui" d="M4.93 19.07A10 10 0 1 1 19.07 4.93 10 10 0 0 1 4.93 19.07zm1.41-1.41A8 8 0 1 0 17.66 6.34 8 8 0 0 0 6.34 17.66zM13.41 12l1.42 1.41a1 1 0 1 1-1.42 1.42L12 13.4l-1.41 1.42a1 1 0 1 1-1.42-1.42L10.6 12l-1.42-1.41a1 1 0 1 1 1.42-1.42L12 10.6l1.41-1.42a1 1 0 1 1 1.42 1.42L13.4 12z"/></svg>';
                }

                if (this.type === 'warning') {
                    return '<svg class="fill-current h-8 w-8 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path class="heroicon-ui" d="M12 2a10 10 0 1 1 0 20 10 10 0 0 1 0-20zm0 2a8 8 0 1 0 0 16 8 8 0 0 0 0-16zm0 9a1 1 0 0 1-1-1V8a1 1 0 0 1 2 0v4a1 1 0 0 1-1 1zm0 4a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/></svg>';
                }
                
                return '<svg class="fill-current h-8 w-8 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path class="heroicon-ui" d="M12 22a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm0-9a1 1 0 0 1 1 1v4a1 1 0 0 1-2 0v-4a1 1 0 0 1 1-1zm0-4a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>';
            }
        },

        computed: {
            color: function () {
                if (this.type === 'warning') return 'orange'
                if (this.type === 'error') return 'red'
                return 'green'
            }
        }
    };

</script>

<style>
    .alert-position {
        position: absolute;
        top: 80px;
        right: 40px;
    }
</style>