
<template>
    <div class="data-panel">

        <message-box ref="deleteBox" name="data-panel-delete" v-show="deletable">
            <template slot="title">Konfirmasi Penghapusan</template>
            <p>Anda akan menghapus data berikut:</p>
            <slot name="delete-preview" :data="deleteData"></slot>
            <template slot="buttons">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" @click="confirmDelete">Hapus</button>
            </template>
        </message-box>

        <div class="panel panel-default">
            <div class="panel-body" v-if="headed">
                <div class="pull-right panel-control">
                    <slot name="control"></slot>
                </div>
                <h1 :class="{'page-title': true, 'small-title': smallTitle}">
                    <slot></slot>
                </h1>
            </div>
            <div class="list-group panel-list">
                <template v-if="model.length > 0">
                    <slot name="list" v-for="item in model" :data="item"></slot>
                </template>
                <template v-else>
                    <div class="list-group-item data-panel-list-item text-center">
                        Tidak Ada Data
                    </div>
                </template>
            </div>
        </div>

    </div>
</template>

<script>

    import Citeup from '../../../citeup'
    import MessageBox from '../MessageBox.vue'

    export default {

        props: {

            expandable: {
                type: Boolean,
                default: false,
            },

            checkable: {
                type: Boolean,
                default: false,
            },

            deletable: {
                type: Boolean,
                default: false,
            },

            headed: {
                type: Boolean,
                default: true,
            },

            model: {
                type: Array,
                required: true,
            },

            smallTitle: {
                type: Boolean,
                default: false,
            },

        },

        data() {
            return {
                listItems: [],
                deleteData: {},
                deleteBox: null,
                deleteLink: null,
            }
        },

        computed: {

            checked() {
                return this.listItems
                    .filter(item => item.checked)
                    .map(item => item.id)
            },

            expanded() {
                return this.listItems
                    .filter(item => item.expanded)
                    .map(item => item.id)
            },

            allChecked() {
                return this.checked.length === this.listItems.length
            },

            allExpanded() {
                return this.expanded.length === this.listItems.length
            },

        },

        model: {
            prop: 'model',
        },

        mounted() {
            this.prepareComponents()
        },

        methods: {

            prepareComponents() {
                this.deleteBox = this.$refs.deleteBox
            },

            listItem(id) {
                return this.listItems.find(item => item.id === id)
            },

            checkAll() {

                if (this.allChecked) {
                    this.listItems.forEach(item => item.check())
                    return
                }

                this.listItems
                    .filter(item => ! item.checked)
                    .forEach(item => item.check())

            },

            expand() {
                
                if (this.allExpanded) {
                    this.listItems.forEach(item => item.expand())
                    return
                }

                this.listItems
                    .filter(item => ! item.expanded)
                    .forEach(item => item.expand())

            },

            'delete'(id, link) {
                this.deleteData = this.model.find(item => item.id === id)
                this.deleteLink = link
                this.deleteBox.open()
            },

            confirmDelete() {
                Citeup.delete(this.deleteLink).then(this.afterDelete)
            },

            afterDelete() {
                
                this.model.splice(this.model.findIndex(
                    item => item.id === this.deleteData.id
                ), 1)

                this.deleteBox.close()

                this.deleteData = {}
                this.deleteLink = null

            },

        },

        components: {
            'message-box': MessageBox,
        }

    }

</script>
