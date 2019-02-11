@extends('layouts.template')


@section('header')
<div class="px-6 py-4">
        <h1 class="w-full p-2">
                <span class="text-lg font-semibold text-grey-darker uppercase">
                        Create new Template
                </span>
        </h1>

        <!-- <h3 class="p-2 text-sm font-light text-grey-dark">
                Use blade syntax to create a new template
        </h3> -->
</div>
        
@endsection


@section('main')
<div class="w-full flex justify-between px-6 mb-2 items-center">
        <span>Use Tailwind classes to design your template</span>
        <div>
                <button type="button" class="py-1 px-4 border border-teal text-teal rounded">Back</button>
                <button type="button" class="py-1 px-4 bg-teal text-white rounded">Save</button>
        </div>
</div>        
<div class="w-full flex flex-wrap">
        
        <div class="w-full px-2">
                <div v-show="selected.length > 0" 
                        class="absolute bg-black text-white text-sm font-mono shadow-lg"
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
                                        <p>Assign Position(s)</p>
                                        <p class="text-xs py-2 text-grey">Add one or more position names separated by comma</p>
                                        <textarea class="w-full p-2 bg-grey-darkest text-white rounded"
                                                v-model="rows[selected[0].r].cols[selected[0].c].positionNames"
                                        ></textarea>
                                </div>
                                
                        </div>

                        <div v-if="sameRowSelection() === true" class="w-full flex flex-no-wrap px-2 py-2 border-b border-grey-darkest max-w-sm">
                                
                                <div v-if="selected.length >= 1 && selected.length === rows[selected[0].r].cols.length" class="w-full m-2">
                                        <p class="w-full pt-2">Divisions</p>
                                        <p class="text-xs py-2 text-grey">Divisions are horizontal rows. You can add a new division below the selected cell(s) or delete the current division</p>
                                        <div class="w-full flex">
                                                <button @click="addRow" class="w-1/2 p-2 mr-1 bg-grey-darkest hover:bg-grey-darker text-grey text-xs" type="button">+ Add</button>
                                                <button @click="removeRow" class="w-1/2 p-2 bg-grey-darkest hover:bg-grey-darker text-grey text-xs" type="button">- Delete</button>
                                        </div>
                                </div>

                                <div  class="w-full m-2">
                                        <p class="w-full pt-2">Sections</p>
                                        <p class="text-xs py-2 text-grey">Sections are cells within division. You can add new section on right of the selected cell or delete current section</p>
                                        <div class="w-full flex">
                                                <button @click="addCol" class="w-1/2 p-2 mr-1 bg-grey-darkest hover:bg-grey-darker text-grey text-xs" type="button">+ Add</button>
                                                <button @click="removeCol" class="w-1/2 p-2 bg-grey-darkest hover:bg-grey-darker text-grey text-xs" type="button">- Delete</button>
                                        </div>
                                </div>
                        </div>

                        <div v-if="selected.length >= 1">
                                <div class="w-full px-4 py-2" v-if="selected.length === rows[selected[0].r].cols.length">
                                        <p class="py-2">Division Class</p>
                                        <textarea 
                                                class="w-full p-2 bg-grey-darkest text-white rounded mb-2"
                                                v-model="rows[selected[0].r].class"
                                        ></textarea>
                                </div>
                        </div>

                </div>


                <div v-show="selectedPosition != null" 
                        class="absolute bg-black text-white text-sm font-mono shadow-lg"
                        id="position">
                        <div id="positionheader" class="flex justify-between w-full p-4 border-b border-grey-darkest items-center cursor-move">
                                <div class="font-bold">Items for @{{ selectedPosition }}</div>
                                <svg class="w-6 h-6 fill-current text-grey-lighter cursor-pointer" @mousedown="selectedPosition=null" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path class="heroicon-ui" d="M4.93 19.07A10 10 0 1 1 19.07 4.93 10 10 0 0 1 4.93 19.07zm1.41-1.41A8 8 0 1 0 17.66 6.34 8 8 0 0 0 6.34 17.66zM13.41 12l1.42 1.41a1 1 0 1 1-1.42 1.42L12 13.4l-1.41 1.42a1 1 0 1 1-1.42-1.42L10.6 12l-1.42-1.41a1 1 0 1 1 1.42-1.42L12 10.6l1.41-1.42a1 1 0 1 1 1.42 1.42L13.4 12z"/></svg>
                        </div>
                        <div class="w-full p-2">

                                <table class="w-full text-xs text-grey text-left table-collapse">
                                        <thead class="uppercase text-xs font-semibold text-grey border-b-1">
                                                <tr>
                                                        <th class="p-2">Items</th>
                                                        <th class="p-2">Description</th>
                                                        <th class="p-2">Action</th>
                                                        
                                                </tr>
                                        </thead>
                                        <tbody class="align-baseline">
                                                <tr v-for="item in items">
                                                        <td class="p-2 border-t border-grey-darker whitespace-no-wrap" v-text="item.name"></td>
                                                        <td class="p-2 border-t border-grey-darker whitespace-no-wrap" v-text="item.description"></td>
                                                        <td class="p-2 border-t border-grey-darker whitespace-no-wrap">
                                                                <span v-show="item.positions.indexOf(selectedPosition) >= 0"
                                                                        class="py-1 px-2 text-white bg-red cursor-pointer rounded"
                                                                        @click="item.positions.splice(item.positions.indexOf(selectedPosition), 1)">Unload</span>
                                                                <span v-show="item.positions.indexOf(selectedPosition) < 0"
                                                                        class="py-1 px-2 text-white bg-green cursor-pointer rounded"
                                                                        @click="item.positions.push(selectedPosition)">Load</span>
                                                        </td>
                                                        
                                                </tr>
                                        </tbody>
                                </table>
                                
                        </div>
                </div>


                <div class="w-full checkers">
                        <div v-for="(row, row_index) in rows" class="cursor-pointer" :class="row.class">
                                <div    v-for="(col, col_index) in row.cols"
                                        @click="select(row_index, col_index, $event)"
                                        :class="col.class" 
                                        :style="styleSelected(row_index, col_index)">
                                        <div v-if="col.positionNames.length > 0" 
                                                v-for="position in col.positionNames.replace(/\s/g,'').split(',')" 
                                                class="hover:bg-grey-lighter text-green"
                                                :class="position.split('.').slice(1).join(' ')"
                                                >
                                                <div>
                                                        <label 
                                                        class="px-2 cursor-pointer bg-purple-lighter rounded-lg text-purple hover:bg-purple hover:text-white"
                                                        v-text="position.split('.').shift()"
                                                        @click.stop="addData(position)"></label>

                                                        <div v-for="item in items" v-if="item.positions.indexOf(position.split('.').shift()) >= 0" v-html="item.markup">
                                                        </div>
                                                </div> 
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

                        sameColSelection: function ()
                        {
                                return this.selected.every (s => s.c === this.selected[0].c)
                        },

                        addRow: function () {
                                let addAfterRow = this.selected[0].r
                                let newRow = {class: 'flex', cols: [{ class: 'w-full bg-white py-4', positionNames: '' }]}
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
                                this.rows[toRow].cols.splice(afterCol+1, 0, { class: 'w-1/6 bg-white py-4', positionNames: '' })
                        },
                        removeCol: function () {
                                let fromRow = this.selected[0].r
                                let colToDelete = this.selected[0].c
                                this.removeFromSelection(this.selected[0].r, this.selected[0].c)
                                this.rows[fromRow].cols.splice (colToDelete, 1)
                        },

                        addData: function (position) {

                                this.selected = []
                                this.selectedPosition = position.split('.').shift()


                        },

                        load: function (item) {
                                this.selectedItem = item.name
                                if (! this.posItemsMap.hasOwnProperty(this.selectedPosition)) {
                                        this.posItemsMap[this.selectedPosition] = []
                                }
                                this.posItemsMap[this.selectedPosition].push(this.selectedItem)
                        },

                        unload: function (item) {

                        }
                }

                let computed = {
                        itemInPosition: function () {
                                return this.posItemsMap.hasOwnProperty(this.selectedPosition) && this.posItemsMap[this.selectedPosition].indexOf(this.selectedItem) >= 0 
                        }
                }

                let data = {
                        num_rows: 3,
                        num_cols: 3,
                        selected: [],
                        selectedPosition: null,
                        selectedItem: null,
                        rows: [
                                {
                                        class: 'flex',
                                        cols: [
                                                { class: 'w-full bg-white', positionNames: 'header' },
                                        ]
                                },
                                {
                                        class: 'flex',
                                        cols: [
                                                { class: 'hidden md:block w-1/4 bg-white', positionNames: 'aside' },
                                                { class: 'w-full md:w-3/4 bg-white', positionNames: 'adblock,main, comments' }
                                        ]
                                },
                                {
                                        class: 'flex',
                                        cols: [
                                                { class: 'w-1/3 bg-white', positionNames: 'left' },
                                                { class: 'w-1/3 bg-white', positionNames: 'center' },
                                                { class: 'w-1/3 bg-white', positionNames: 'right' },
                                        ]
                                }
                        ],

                        posItemsMap: {
                            /*
                            'position1': ['title'],
                            'position2': ['author', 'summary'],
                            */
                           'main': ['title', 'summary']
                        },
                        
                        items: [
                                {
                                        'name': 'title',
                                        'description': 'Title of the Page',
                                        'positions': ['right'],
                                        'markup': '<h3 class="text-blue text-3xl my-2">Title of the page</h3>'
                                },
                                {
                                        'name': 'summary',
                                        'description': 'Summary of the Page',
                                        'positions': ['main'],
                                        'markup': '<p class="">Nibh maiorum salutatus ne vix, quod veri interesset sed ne? Mea et putent aperiam voluptaria, duo ex diceret suavitate definiebas, splendide interpretaris vis an. Eu semper phaedrum assueverit cum, facete putant inciderint ea pri. Labore alienum pericula est ut. Tractatos erroribus qui no.</p>'
                                }
                        ]
                }

                // Vue.component('module-position', {
                //         props: ['name'],
                //         template: '<span v-text="name" class="px-2 cursor-pointer bg-purple-lighter rounded-lg text-purple hover:bg-purple hover:text-white"></span>'
                // })

                new Vue({
                        el: 'main',
                        data: data,
                        methods: methods,
                        computed: computed
                })

                
        </script>
        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.1/ace.js"></script>
        <script>
                var editor = ace.edit("editor");
                editor.setTheme("ace/theme/monokai");
                editor.session.setMode("ace/mode/html");
        </script>
        <script>
                document.getElementById('btnSave').onclick = function () {
                        document.getElementById('inpBody').value = editor.getSession().getValue();
                        frm.submit();
                }
        </script> -->

        <script>

                dragElement(document.getElementById('config'));
                dragElement(document.getElementById('position'));

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
        </script>
@endsection