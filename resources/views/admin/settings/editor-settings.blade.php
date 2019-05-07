<div class="w-full md:w-1/31 px-6 py-10">
        <div class="w-full block">
                <label class="border py-2 px-4 rounded-lg cursor-pointer bg-grey-lighter">
                        <input name="editor" type="radio" value="plain" v-model="editor" />
                        <span class="text-lg1 px-4">Plain Editor</span>
                </label>
                <div class="mt-4 text-grey-darker">Simple text box that allows you to input plain text or raw HTML.</div>
        </div>

        <div class="w-full block mt-8">
                <label class="border py-2 px-4 rounded-lg cursor-pointer bg-grey-lighter">
                        <input name="editor" type="radio" value="rich" v-model="editor"  />
                        <span class="text-lg1 px-4">Rich Editor</span>
                </label>
                <div class="mt-4 text-grey-darker">This is a WYSIWYG Editor that uses HTML5 <code>contenteditable</code> feature.</div>
        </div>

        <div class="w-full block mt-8">
                <label class="border py-2 px-4 rounded-lg cursor-pointer bg-grey-lighter">
                        <input name="editor" type="radio" value="html" v-model="editor" disabled />
                        <span class="text-lg1 px-4 text-grey">HTML Editor</span>
                </label>
                <div class="mt-4 text-grey-darker">This is a good ol' HTML editor with all the bells and whistles so that you never feel limited. </div>
        </div>

        <div class="mt-8">
                <button @click="save('editorStateClass', ['editor'])" :class="editorStateClass" class="px-4 py-2 rounded text-white">Save</button>
        </div>
</div>