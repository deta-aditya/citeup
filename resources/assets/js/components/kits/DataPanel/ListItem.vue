
<template>
    <a 
        ref="listElement" 
        :class="['list-group-item', 'data-panel-list-item', 'clearfix', checkableClass, sizeClass]" 
        @click="click">
        <div class="pull-right item-control">
            <slot name="controls"></slot>
            <dropdown align="right" variant="link" :caret="false" v-if="controls">
                <i class="fa fa-lg fa-ellipsis-h"></i>
                <template slot="menu">
                    <li v-if="updatable">
                        <router-link :to="update">Sunting</router-link>
                    </li>
                    <li v-if="deletable">
                        <a @click="runDelete">Hapus</a>
                    </li>
                    <slot name="actions"></slot>
                </template>
            </dropdown>
        </div>
        <h4 class="list-title">
            <small v-if="showId">#{{ id }}</small>
            <slot name="title"></slot>
        </h4>
        <div ref="expandableElement" :class="{ 'expandable-content': expandable, 'list-content': true }">
            <slot></slot>
        </div>
    </a>
</template>

<script>

    import Dropdown from '../Dropdown.vue'

    export default {

        props: {

            id: {
                type: [Number, String],
                required: true
            },

            showId: {
                type: Boolean,
                default: true,
            },

            size: {
                type: String,
                default: '',
            },

            controls: {
                type: Boolean,
                default: true,
            },

            update: {
                type: [Object, Boolean, String],
                default() {
                    return false
                },
            },

            delete: {
                type: [Boolean, String],
                default: false,
            },

        },

        data() {
            return {
                listElement: null,
                expandableElement: null,
                dataPanel: null,
                expandable: false,
                checkable: false,
                checked: false,
                expanded: false,
            }
        },

        computed: {

            updatable() {
                return this.update !== false
            },

            deletable() {
                return this.delete !== false
            },

            checkableClass() {
                return this.checkable ? '' : 'checkable'
            },

            sizeClass() {
                return this.size ? this.size : ''
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
                this.listElement = this.$refs.listElement

                if (this.expandable) {
                    this.expandableElement = this.$refs.expandableElement
                }

                this.dataPanel.listItems.push(this)
            },

            click(e) {
                this.$emit('click', { id: this.id })

                if (this.checkable) {
                    this.check()
                }
            },

            check() {
                this.listElement.classList.toggle('checked')
                this.checked = this.listElement.classList.contains('checked')
            },

            expand() {

                if (! this.expandable) {
                    return
                }

                this.expandableElement.classList.toggle('expanded')
                this.expanded = this.expandableElement.classList.contains('expanded')
            },

            runDelete() {
                this.dataPanel.delete(this.id, this.delete)
            }

        },

        components: {
            'dropdown': Dropdown
        }

    }

</script>
