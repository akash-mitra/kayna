<template>
    <div>
        <input type="hidden" v-model="code">
        <div id="editor" class="appearance-none block w-full h-64  border border-grey-lighter rounded py-3 px-4 mb-3 leading-tight focus:outline-none"></div>
    </div>
</template>

<script>

    import Editor from '@tinymce/tinymce-vue'

    export default {

        props: {
                name: String,
                code: String,
        },

        methods: {
            
        }
    }
</script>
