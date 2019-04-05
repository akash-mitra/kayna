/*
 * This is to make Vue ignore custom element 'trix-editor' used
 * inside Editor.vue file. Otherwise, Vue throws a warning 
 * about an Unknown custom element, assuming that you 
 * forgot to register a global component.
 */ 
Vue.config.ignoredElements = ['trix-editor', 'trix-toolbar']

// add the Vue file for the Editor application
Vue.component('editor', require('./app/Editor.vue').default)