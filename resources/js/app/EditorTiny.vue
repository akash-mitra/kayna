<template>
    <div>
        
        <textarea 
            :placeholder="placeholder" 
            class="trix border-none pt-1">
        </textarea>

    </div>
</template>

<script>

    import Editor from '@tinymce/tinymce-vue'

    export default {

        props: {

                name: String,

                value: String,

                placeholder: String

        },

        methods: {
            uploadAttachment: function (attachment) {
                console.log(attachment)
            }
        }
    }
</script>
