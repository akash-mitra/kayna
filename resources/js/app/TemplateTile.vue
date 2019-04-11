<template>
        <div class="shadow border rounded">
                <div class="w-full px-6 py-4 border-b flex justify-between items-center">
                        <span class="font-bold text-grey-darker" v-text="template.name"></span>
                </div>
                <div class="w-full px-6 py-4">
                        <p class="text-indigo-darker" v-text="template.description"></p>
                </div>
                <div class="w-full px-6 py-4 bg-grey-lighter">
                        <div v-if="template.active==='Y'">
                                <span class="py-1 px-2 bg-green text-white rounded">In Use</span>
                                <a class="py-1 px-2 text-blue no-underline hover:text-blue-darker" v-bind:href="'/admin/templates/' + template.id">Edit</a>
                        </div>
                        <div v-else>
                                <div v-if="typeof template.source_id != 'undefined'">
                                        <span class="py-1 px-2 text-blue cursor-pointer border border-blue rounded hover:bg-green hover:text-white hover:border-green" v-on:click="$emit('apply-template', template.id)">Apply</span>
                                        <a class="py-1 px-2 text-blue no-underline hover:text-blue-darker" v-bind:href="'/admin/templates/' + template.id">Edit</a>
                                </div>
                                <div v-else>
                                        <span v-on:click="$emit('install-template', template.id)" class="py-1 px-2 text-blue no-underline cursor-pointer border border-blue rounded hover:bg-green hover:text-white hover:border-green" href="#">Install</span>
                                </div>
                        </div>
                </div>
        </div>
</template>

<script>
export default {

        props: ['template']
}
</script>

