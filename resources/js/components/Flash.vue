<template>
    <div class="w-1/3 md:w-1/3 lg:w-1/4 text-sm shadow-md border rounded-lg p-2 alert-position"
         :class="'border-'+color+' text-'+color+'-dark bg-'+color+'-lightest'"
         role="alert"
         v-show="show"
        >
                <p v-text="body" class="p-2"></p>       
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
            }
        },

        computed: {
            color: function () {
                if (this.type === 'warning') return 'orange'
                if (this.type === 'error') return 'red'
                return 'teal'
            }
        }
    };
</script>

<style>
    .alert-position {
        position: fixed;
        right: 25px;
        bottom: 100px;
    }
</style>