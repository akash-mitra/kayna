@extends('layouts.template')


@section('css')
        <link rel="stylesheet" href="/storage/css/main.css">
        
@endsection


@section('main')

<div class="bg-black p-4 -mt-20">
        <h1 class="w-full p-2">
                <span class="text-lg font-semibold text-grey-light uppercase">
                        <span v-text="id===null?'Create':'Update'"></span> {{ $template->type }} Template
                </span>
        </h1>
</div>

<div class="w-full bg-black sm:flex pb-4 px-4 mb-6">
        <div class="w-1/2">
                <p v-show="name!== ''" class="text-xs text-grey">Template Name</p>
                <div class="flex justify-between border-b border-grey border-dashed">
                        <input type="text" v-model="name" class="py-2 text-grey-light bg-black text-2xl" placeholder="Template Name" /> 
                        <div class="flex items-center">
                                <button type="button" class="py-1 px-4 bg-teal text-white rounded" @click="save">Save</button>                  
                        </div>
                </div>
        </div>
        <div class="w-1/2 flex justify-end items-end">
                <button type="button" class="py-1 px-4 content-end text-white bg-green rounded mr-2" @click="show_property=true">Properties</button>
                <button type="button" class="py-1 px-4 content-end text-white bg-orange rounded mr-2" @click="cancel">Cancel</button>
        </div>
</div>        



<div class="w-full flex flex-wrap">

        
        
        <div class="w-full flex justify-center">

                <div v-show="show_property" class="absolute  bg-black text-grey-lightest text-sm shadow-lg border-t-4 border-orange" id="properties">
                        <div id="propertiesheader" class="flex justify-between w-full p-4 border-b border-grey-darkest items-center cursor-move">
                                <div class="font-bold">Document Property</div>
                                <svg class="w-6 h-6 fill-current text-grey-lighter cursor-pointer" @mousedown="show_property=false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path class="heroicon-ui" d="M4.93 19.07A10 10 0 1 1 19.07 4.93 10 10 0 0 1 4.93 19.07zm1.41-1.41A8 8 0 1 0 17.66 6.34 8 8 0 0 0 6.34 17.66zM13.41 12l1.42 1.41a1 1 0 1 1-1.42 1.42L12 13.4l-1.41 1.42a1 1 0 1 1-1.42-1.42L10.6 12l-1.42-1.41a1 1 0 1 1 1.42-1.42L12 10.6l1.41-1.42a1 1 0 1 1 1.42 1.42L13.4 12z"/></svg>
                        </div>
                        <div class="max-w-lg w-full p-4">
                                <label>
                                        <span class="">CSS Library</span>
                                        <input type="text" class="bg-grey-darker text-grey w-full p-2 rounded my-2" v-model="fnMainCSS"/>
                                </label>
                                <label>
                                        <span class="">JS Library</span>
                                        <input type="text" class="bg-grey-darker text-grey w-full p-2 rounded my-2" v-model="fnMainJS"/>
                                </label>
                                <label>
                                        <span class="">Template CSS</span>
                                        <input type="text" class="bg-grey-darker text-grey w-full p-2 rounded my-2" v-model="fnTemplateCSS"/>
                                </label>
                        </div>
                </div>
                
                <div v-show="selected.length > 0" 
                        class="absolute bg-black text-white text-sm font-mono shadow-lg border-t-4 border-orange"
                        id="config"
                        >
                        <div id="configheader" class="flex justify-between w-full p-4 border-b border-grey-darkest items-center cursor-move">
                                <div class="font-bold">Settings</div>
                                <svg class="w-6 h-6 fill-current text-grey-lighter cursor-pointer" @mousedown="selected=[]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path class="heroicon-ui" d="M4.93 19.07A10 10 0 1 1 19.07 4.93 10 10 0 0 1 4.93 19.07zm1.41-1.41A8 8 0 1 0 17.66 6.34 8 8 0 0 0 6.34 17.66zM13.41 12l1.42 1.41a1 1 0 1 1-1.42 1.42L12 13.4l-1.41 1.42a1 1 0 1 1-1.42-1.42L10.6 12l-1.42-1.41a1 1 0 1 1 1.42-1.42L12 10.6l1.41-1.42a1 1 0 1 1 1.42 1.42L13.4 12z"/></svg>
                        </div>

                        <div class="w-full px-4 py-2 border-b border-grey-darkest" v-if="selected.length === 1">
                                <div>
                                        <p>Section Class</p>
                                        <p class="text-xs py-2 text-grey">Classes to be applied on the selected section</p>
                                        <textarea 
                                                class="w-full p-2 bg-grey-darkest text-white rounded"
                                                v-model="rows[selected[0].r].cols[selected[0].c].class"
                                        ></textarea>
                                </div>
                                <div class="mt-4">
                                        <p>Positions</p>
                                        <!-- <p class="text-xs py-2 text-grey">Add one or more position names separated by comma</p> -->

                                        <table class="w-full text-xs text-grey text-left table-collapse">
                                                <thead class="uppercase text-xs font-semibold text-grey border-b-1">
                                                        <tr>
                                                                <th class="py-2">Name</th>
                                                                <th class="py-2">Class</th>
                                                                <th class="py-2">Action</th>
                                                        </tr>
                                                </thead>
                                                <tbody class="align-baseline">
                                                        <tr>
                                                                <td class="p-2 border-t border-grey-darker whitespace-no-wrap">
                                                                        <input class="w-full p-2 bg-grey-darkest text-white rounded" placeholder="e.g. logo" v-model="new_pos_name"/>
                                                                </td>
                                                                <td class="p-2 border-t border-grey-darker whitespace-no-wrap">
                                                                        <input class="w-full p-2 bg-grey-darkest text-white rounded" placeholder="e.g. rounded" v-model="new_pos_class"/>
                                                                </td>
                                                                <td class="p-2 border-t border-grey-darker whitespace-no-wrap align-middle">
                                                                        <svg class="w-4 h-4 fill-current text-grey-lighter cursor-pointer" @click="addPosition" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path class="heroicon-ui" d="M12 22a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm1-9h2a1 1 0 0 1 0 2h-2v2a1 1 0 0 1-2 0v-2H9a1 1 0 0 1 0-2h2V9a1 1 0 0 1 2 0v2z"/></svg>
                                                                </td>
                                                        </tr>
                                                        <tr v-for="position in rows[selected[0].r].cols[selected[0].c].positions">
                                                                <td class="p-2 border-t border-grey-darker whitespace-no-wrap">
                                                                        <input class="w-full p-2 bg-transparent border border-grey-darkest text-white rounded" 
                                                                                v-model="position.name" />
                                                                </td>
                                                                <td class="p-2 border-t border-grey-darker whitespace-no-wrap">
                                                                        <input class="w-full p-2 bg-transparent border border-grey-darkest text-white rounded" 
                                                                                v-model="position.class" />
                                                                </td>
                                                                <td class="p-2 border-t border-grey-darker whitespace-no-wrap align-middle">
                                                                        <svg class="w-4 h-4 fill-current text-grey-lighter cursor-pointer" @click="removePosition(position)" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path class="heroicon-ui" d="M8 6V4c0-1.1.9-2 2-2h4a2 2 0 0 1 2 2v2h5a1 1 0 0 1 0 2h-1v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V8H3a1 1 0 1 1 0-2h5zM6 8v12h12V8H6zm8-2V4h-4v2h4zm-4 4a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0v-6a1 1 0 0 1 1-1zm4 0a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0v-6a1 1 0 0 1 1-1z"/></svg>
                                                                </td>
                                                        </tr>
                                                        
                                                </tbody>
                                        </table>
                                </div>
                                
                        </div>

                        <div v-if="sameRowSelection() === true" class="w-full flex flex-no-wrap px-2 py-2 border-b border-grey-darkest max-w-sm">
                                
                                <div v-if="selected.length >= 1 && selected.length === rows[selected[0].r].cols.length" class="w-full m-2">
                                        <p class="w-full py-1">Divisions</p>
                                        <!-- <p class="text-xs py-2 text-grey">Divisions are horizontal rows. You can add a new division below the selected cell(s) or delete the current division</p> -->
                                        <div class="w-full flex">
                                                <button @click="addRow" class="w-1/2 p-2 mr-1 bg-grey-darkest hover:bg-grey-darker text-grey text-xs" type="button">+ Add</button>
                                                <button @click="removeRow" class="w-1/2 p-2 bg-grey-darkest hover:bg-grey-darker text-grey text-xs" type="button">- Delete</button>
                                        </div>
                                </div>

                                <div  class="w-full m-2">
                                        <p class="w-full py-1">Sections</p>
                                        <!-- <p class="text-xs py-2 text-grey">Sections are cells within division. You can add new section on right of the selected cell or delete current section</p> -->
                                        <div class="w-full flex">
                                                <button @click="addCol" class="w-1/2 p-2 mr-1 bg-grey-darkest hover:bg-grey-darker text-grey text-xs" type="button">+ Add</button>
                                                <button @click="removeCol" class="w-1/2 p-2 bg-grey-darkest hover:bg-grey-darker text-grey text-xs" type="button">- Delete</button>
                                        </div>
                                </div>
                        </div>

                        <div v-if="selected.length >= 1">
                                <div class="w-full px-4 py-1" v-if="selected.length === rows[selected[0].r].cols.length">
                                        <p class="py-1 text-blue cursor-pointer" @click="div_class_visibility = !div_class_visibility">Set Division Class</p>
                                        <textarea 
                                                v-show="div_class_visibility===true"
                                                class="w-full p-2 bg-grey-darkest text-white rounded mb-2"
                                                v-model="rows[selected[0].r].class"
                                        ></textarea>
                                </div>
                        </div>

                </div>

                <!-- ITEM block -->
                <div v-show="hasSelectedPosition()" 
                        class="absolute bg-black text-white text-sm font-mono shadow-lg border-t-4 border-orange"
                        id="position">
                        <div id="positionheader" class="flex justify-between w-full p-4 border-b border-grey-darkest items-center cursor-move">
                                <div class="font-bold">Items for @{{ selectedPosition.name }}</div>
                                <svg class="w-6 h-6 fill-current text-grey-lighter cursor-pointer" @mousedown="selectedPosition = {}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path class="heroicon-ui" d="M4.93 19.07A10 10 0 1 1 19.07 4.93 10 10 0 0 1 4.93 19.07zm1.41-1.41A8 8 0 1 0 17.66 6.34 8 8 0 0 0 6.34 17.66zM13.41 12l1.42 1.41a1 1 0 1 1-1.42 1.42L12 13.4l-1.41 1.42a1 1 0 1 1-1.42-1.42L10.6 12l-1.42-1.41a1 1 0 1 1 1.42-1.42L12 10.6l1.41-1.42a1 1 0 1 1 1.42 1.42L13.4 12z"/></svg>
                        </div>
                        <div class="w-full p-2">

                                <table class="w-full text-xs text-grey text-left table-collapse">
                                        <thead class="uppercase text-xs font-semibold text-grey border-b-1">
                                                <tr>
                                                        <th class="p-2">Load Item</th>
                                                        <th class="p-2">Class (Optional)</th>
                                                        <th class="p-2">Action</th>
                                                </tr>
                                        </thead>
                                        <tbody class="align-baseline">
                                                <tr>
                                                        <td class="p-2 border-t border-grey-darker whitespace-no-wrap mb-4">
                                                                <select v-model="new_item"
                                                                        class="block appearance-none w-full bg-grey-darkest text-grey-lighter p-2 rounded leading-tight">
                                                                        <option v-bind:value="null" class="text-white" disabled>Choose an item</option>
                                                                        <option class="" v-for="item in apiMetaData" v-bind:value="item">@{{ item.description }}</option>
                                                                </select>
                                                        </td>

                                                        <td class="p-2 border-t border-grey-darker whitespace-no-wrap">
                                                                <input class="w-full p-2 bg-grey-darkest text-white rounded" placeholder="e.g. logo" v-model="new_item.length === 0? '': new_item.class"/>
                                                        </td>
                                                        <td class="p-2 border-t border-grey-darker whitespace-no-wrap align-middle">
                                                                <svg class="w-4 h-4 fill-current text-grey-lighter cursor-pointer" @click="addItem" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path class="heroicon-ui" d="M12 22a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm1-9h2a1 1 0 0 1 0 2h-2v2a1 1 0 0 1-2 0v-2H9a1 1 0 0 1 0-2h2V9a1 1 0 0 1 2 0v2z"/></svg>
                                                        </td>
                                                </tr>
                                                <tr>
                                                        <td class="p-2 uppercase whitespace-no-wrap" >Loaded Items</td>
                                                        <td></td><td></td>
                                                </tr>

                                                <tr v-if="this.selectedPosition.hasOwnProperty('items') && this.selectedPosition.items.length === 0">
                                                        <td class="p-2 text-grey-lighter border-t border-grey-darker whitespace-no-wrap" colspan="3">0 item loaded in this position</td>
                                                        
                                                </tr>

                                                <tr v-for="item in this.selectedPosition.items">
                                                        <td class="p-2 border-t border-grey-darker whitespace-no-wrap" v-text="item.name"></td>
                                                        <td class="p-2 border-t border-grey-darker whitespace-no-wrap">
                                                                <input type="text" class="p-1 w-full bg-grey-darkest text-grey" 
                                                                        v-model="item.class" />
                                                        </td>
                                                        <td class="p-2 border-t border-grey-darker whitespace-no-wrap align-middle">
                                                                <svg class="w-4 h-4 fill-current text-grey-lighter cursor-pointer" @click="removeItem(item)" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path class="heroicon-ui" d="M8 6V4c0-1.1.9-2 2-2h4a2 2 0 0 1 2 2v2h5a1 1 0 0 1 0 2h-1v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V8H3a1 1 0 1 1 0-2h5zM6 8v12h12V8H6zm8-2V4h-4v2h4zm-4 4a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0v-6a1 1 0 0 1 1-1zm4 0a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0v-6a1 1 0 0 1 1-1z"/></svg>
                                                        </td>
                                                </tr>
                                        </tbody>
                                </table>
                                
                        </div>
                </div>

        </div>

        <div class="w-full checkers">
                <div v-for="(row, row_index) in rows" class="cursor-pointer" :class="row.class">
                        <div    v-for="(col, col_index) in row.cols"
                                @click="select(row_index, col_index, $event)"
                                style="min-height: 1em"
                                class="hover:bg-grey-lightest"
                                :class="col.class" 
                                :style="styleSelected(row_index, col_index)">
                                <div v-if="col.positions.length > 0" 
                                        v-for="position in col.positions" 
                                        
                                        :class="position.class"
                                        >
                                        <div>
                                                <label 
                                                        class="p-2 cursor-pointer bg-purple-lightest rounded text-xs text-purple hover:bg-purple shadow hover:text-white unselectable"
                                                        v-text="position.name"
                                                        @click.stop="showItemModal(position, row_index, col_index)"></label>
                                                <template v-for="item in position.items">
                                                        <span v-if="item.placeholder.tag==='span'" v-text="item.placeholder.text" v-bind:class="item.class"></span>
                                                        <p v-if="item.placeholder.tag==='p'" v-text="item.placeholder.text" v-bind:class="item.class"></p>
                                                        <div v-if="item.placeholder.tag==='div'" v-text="item.placeholder.text" v-bind:class="item.class"></div>
                                                        <img v-if="item.placeholder.tag==='img'" v-bind:src="item.placeholder.src" v-bind:class="item.class" />
                                                        <a v-if="item.placeholder.tag==='a'" v-bind:href="item.placeholder.href" v-text="item.placeholder.text" v-bind:class="item.class"></a>
                                                </template>
                                        </div> 
                                </div>
                        </div>
                </div>
        </div>

        
</div>
@endsection

@section('script')

        <script>
                let methods = {
                        /**
                         * Selects a specific cell based on given row and column numbers
                         */
                        select: function (r, c, e) 
                        {   
                                // remove add Item Modal if already opem
                                this.selectedPosition = {}

                                // if the clicked cell is already selected, then deselect it
                                // by removing the cell from the list of selected cells
                                let cellRemoved = this.removeFromSelection (r, c)

                                // otherwise when the clicked cell is not already selected,  
                                // select it by replacing the current selections with it or by 
                                // adding it to the list of current selections (if shift key is pressed)
                                if (cellRemoved === false) {
                                        if (e.shiftKey) this.selected.push({r: r, c: c})
                                        else this.selected = [{r: r, c: c}]
                                }
                        },

                        // apply a light blue boder style to depict selection
                        styleSelected: function (r, c)
                        {
                                if (this.isSelected(r, c)) 
                                        return 'border: 2px #6af solid'
                                return 'border: 1px #ddd dotted'
                        },

                        // checks if the given cell at row "r" and column "c" is already selected
                        isSelected: function (r, c)
                        {
                                for (let i = 0; i < this.selected.length; i++) {
                                        let s = this.selected[i]
                                        if (s.r === r && s.c === c) 
                                                return true
                                }
                                return false
                        },

                        // removes the cell at row "r" and column "c" from
                        // the list of selected cells
                        removeFromSelection: function (r, c) 
                        {
                                let isRemoved = false
                                this.selected = this.selected.filter(function(s) { 
                                        if (s.r === r && s.c === c) {
                                                isRemoved = true
                                                return false
                                        }
                                        return true
                                })
                                return isRemoved
                        },

                        sameRowSelection: function ()
                        {
                                return this.selected.every (s => s.r === this.selected[0].r)
                        },

                        addRow: function () {
                                let addAfterRow = this.selected[0].r
                                let newRow = {class: 'flex', cols: [{ class: 'w-full bg-white py-4', positions: [] }]}
                                this.rows.splice (addAfterRow+1, 0, newRow)
                        },
                        removeRow: function () {
                                let rowToDelete = this.selected[0].r
                                this.removeFromSelection(this.selected[0].r, this.selected[0].c)
                                this.rows.splice (rowToDelete, 1)
                        },
                        addCol: function () {
                                let toRow = this.selected[0].r
                                let afterCol = this.selected[0].c
                                this.rows[toRow].cols.splice(afterCol+1, 0, { class: 'w-1/6 bg-white py-4', positions: [] })
                        },
                        removeCol: function () {
                                let fromRow = this.selected[0].r
                                let colToDelete = this.selected[0].c
                                this.removeFromSelection(this.selected[0].r, this.selected[0].c)
                                this.rows[fromRow].cols.splice (colToDelete, 1)
                        },

                        /**
                         * Adds a new position under selected cell
                         */
                        addPosition: function () {
                                let positions = this.rows[this.selected[0].r].cols[this.selected[0].c].positions
                                let pos_name = this.new_pos_name
                                let pos_class = this.new_pos_class
                                this.new_pos_name = '', this.new_pos_class = ''
                                positions.push({name: pos_name, class: pos_class, items: []})
                                
                        },

                        /**
                         * Removes the given position from the selected cell
                         */
                        removePosition: function (position) {
                                
                                let positions = this.rows[this.selected[0].r].cols[this.selected[0].c].positions
                                for (let i = 0; i < positions.length; i++) {
                                        let p = positions[i]
                                        if (p.name === position.name) {
                                                return positions.splice(i, 1)
                                        }
                                }
                        },

                        showItemModal: function (position, r, c) {
                                this.selected = []
                                this.selectedPosition = position
                        },


                        hasSelectedPosition: function () {
                                return Object.keys(this.selectedPosition).length != 0 
                        },


                        /**
                         * Adds a given item to the selected position's item list
                         */
                        addItem: function () {
                                let item = JSON.parse(JSON.stringify(this.new_item)) // deep clone
                                this.selectedPosition.items.push(item)
                                this.new_item = []
                        },

                        
                        /**
                         * Removes the given item from selected position's item list
                         */
                        removeItem: function (item) {
                                let l = this.selectedPosition.items.length
                                for (let i = 0; i < l; i++) {
                                        if (this.selectedPosition.items[i].name === item.name) {
                                                this.selectedPosition.items.splice(i, 1)
                                                return true
                                        }
                                }
                        },

                        

                        save: function (event) {
                                let p = this, 
                                url = '{{ route("templates.store") }}',
                                onSuccess = function (response) {
                                        event.target.innerText = "Save"
                                        if (response.data.template_id > 0) {
                                                p.id = response.data.template_id
                                                flash({message: response.data.flash.message})
                                        }
                                        else {
                                                console.log('something went wrong')
                                                console.log(response)
                                        }
                                },
                                ajaxRequestData = {
                                        name: p.name,
                                        frame: JSON.stringify(p.rows),
                                        head: JSON.stringify(p.head),
                                        type: '{{ $template->type }}'
                                }

                                event.target.innerText = "Saving"
                                
                                if (this.id === null) {
                                        let token = document.head.querySelector('meta[name="csrf-token"]')
                                        ajaxRequestData['_token'] = token.content
                                        post_to_url(url, ajaxRequestData)
                                } else {
                                        axios.patch(url + '/' + this.id, ajaxRequestData).then (onSuccess)
                                }
                        },

                        cancel: function () {
                                location.href="{{ route('templates.index')}}"
                        }

                        
                }

                

                let data = {
                        id: {{data_get($template, "id", 'null')}},
                        name: '{{data_get($template, "name")}}',
                        selected: [],
                        selectedPosition: {},
                        show_property: false,
                        new_pos_name: '',
                        new_pos_class: '',
                        new_item: [],
                        div_class_visibility: false,
                        rows: {!! $template->frame !!},
                        head: {!! $template->head !!},
                        apiMetaData: {!! $props !!}
                }

                new Vue({
                        el: 'main',
                        data: data,
                        methods: methods,
                        computed: {
                                fnTemplateCSS:  {
                                        get: function () {
                                                let item = this.head.filter(item => { return item.prop === 'template-css'})
                                                if (item.length > 0) {
                                                        return item[0].value
                                                }
                                        },
                                        set: function (val) {
                                                let item = this.head.filter(item => { return item.prop === 'template-css'})
                                                if (item.length > 0) { // item found
                                                        item[0].value = val
                                                } else { // item not found
                                                        this.head.push({
                                                                prop: 'template-css',
                                                                default: '',
                                                                value: val
                                                        })
                                                }
                                        }
                                },

                                fnMainCSS:  {
                                        get: function () {
                                                let item = this.head.filter(item => { return item.prop === 'css'})
                                                if (item.length > 0) {
                                                        return item[0].value
                                                }
                                        },
                                        set: function (val) {
                                                let item = this.head.filter(item => { return item.prop === 'css'})
                                                if (item.length > 0) { // item found
                                                        item[0].value = val
                                                } else { // item not found
                                                        this.head.push({
                                                                prop: 'css',
                                                                default: '',
                                                                value: val
                                                        })
                                                }
                                        }
                                },

                                fnMainJS:  {
                                        get: function () {
                                                let item = this.head.filter(item => { return item.prop === 'js'})
                                                if (item.length > 0) {
                                                        return item[0].value
                                                }
                                        },
                                        set: function (val) {
                                                let item = this.head.filter(item => { return item.prop === 'js'})
                                                if (item.length > 0) { // item found
                                                        item[0].value = val
                                                } else { // item not found
                                                        this.head.push({
                                                                prop: 'js',
                                                                default: '',
                                                                value: val
                                                        })
                                                }
                                        }
                                },
                        }
                })

                
        </script>
        
        
        

        <script>

                dragElement(document.getElementById('config'));
                dragElement(document.getElementById('position'));
                dragElement(document.getElementById('properties'));

                function dragElement(elmnt) {
                        var pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
                        if (document.getElementById(elmnt.id + "header")) {
                                // if present, the header is where you move the DIV from:
                                document.getElementById(elmnt.id + "header").onmousedown = dragMouseDown;
                        } 
                        else {
                                // otherwise, move the DIV from anywhere inside the DIV:
                                elmnt.onmousedown = dragMouseDown;
                        }

                        function dragMouseDown(e) {
                                e = e || window.event;
                                e.preventDefault();
                                // get the mouse cursor position at startup:
                                pos3 = e.clientX;
                                pos4 = e.clientY;
                                document.onmouseup = closeDragElement;
                                // call a function whenever the cursor moves:
                                document.onmousemove = elementDrag;
                        }

                        function elementDrag(e) {
                                e = e || window.event;
                                e.preventDefault();
                                // calculate the new cursor position:
                                pos1 = pos3 - e.clientX;
                                pos2 = pos4 - e.clientY;
                                pos3 = e.clientX;
                                pos4 = e.clientY;
                                // set the element's new position:
                                elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
                                elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
                        }

                        function closeDragElement() {
                                // stop moving when mouse button is released:
                                document.onmouseup = null;
                                document.onmousemove = null;
                        }
                }


                function post_to_url(path, params, method) {
                        method = method || "post";

                        var form = document.createElement("form");
                        form.setAttribute("method", method);
                        form.setAttribute("action", path);

                        for(var key in params) {
                                if(params.hasOwnProperty(key)) {
                                var hiddenField = document.createElement("input");
                                hiddenField.setAttribute("type", "hidden");
                                hiddenField.setAttribute("name", key);
                                hiddenField.setAttribute("value", params[key]);

                                form.appendChild(hiddenField);
                                }
                        }

                        document.body.appendChild(form);
                        form.submit();

                        //console.log(form)
                }
        </script>
@endsection