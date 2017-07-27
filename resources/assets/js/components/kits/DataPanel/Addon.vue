
<template>
    <div class="data-panel-addon">
        <input type="text" class="form-control" placeholder="Cari..." v-if="searchable">
        <div class="btn-group" v-if="checkable">
            <button type="button" class="btn btn-default" @click="checkAll">{{ checkBtnText }}</button>
            <dropdown variant="default" align="right">
                <template slot="menu">
                    <slot></slot>
                </template>
            </dropdown>
        </div>
        <div class="btn-group">
            <button type="button" class="btn btn-default" v-if="expandable" @click="expand">{{ expandBtnText }}</button>
            <button type="button" class="btn btn-default" v-if="refresh" @click="refresh">Segarkan</button>
        </div>
        <router-link class="btn btn-primary" :to="create" v-if="create !== null">Buat</router-link>
    </div>
</template>

<script>

    import Dropdown from '../Dropdown.vue'

    export default {

        props: {

            source: {
                type: String,
                validator: value => {
                    if (this.searchable || this.refreshable) {
                        return value !== ''
                    }
                    
                    return true
                }
            },

            create: {
                type: [Object, String],
                default() {
                    return null
                }
            },

            searchable: {
                type: Boolean,
                default: false,
            },

            refresh: {
                type: [Function, Boolean],
                default: false,
            },

        },

        data() {
            return {
                dataPanel: null,
                expandable: false,
                checkable: false,
            }
        },

        computed: {

            checkBtnText() {
                return this.dataPanel.allChecked ? 'Hapus Tanda' : 'Tandai Semua'
            },

            expandBtnText() {
                return this.dataPanel.allExpanded ? 'Kempiskan' : 'Bentangkan'
            },

        },

        mounted() {
            this.prepareComponent()
        },

        methods: {

            prepareComponent() {
                this.dataPanel = this.$parent
                this.expandable = this.dataPanel.expandable
                this.checkable = this.dataPanel.checkable
            },

            checkAll() {
                this.dataPanel.checkAll()
            },

            expand() {
                this.dataPanel.expand()
            },

        },

        components: {
            'dropdown': Dropdown
        },

    }

</script>
