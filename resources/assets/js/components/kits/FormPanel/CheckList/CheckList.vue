
<template>
    <div :class="{'form-group': grouped}">
        <label v-if="labeled" :for="name" :class="['control-label', labelColumn]">
            <slot></slot>
        </label>
        <div :class="[controlColumn]">
            <div class="list-group check-list">
                <check-list-item v-for="(item, index) in list" :key="index" :name="item.name" :state="item.state" @check="updateList">
                    <slot name="list" :data="item"></slot>
                </check-list-item>
            </div>
            <slot name="help-block"></slot>
        </div>
    </div>
</template>

<script>

    import _ from 'lodash'
    import CheckListItem from './CheckListItem.vue'

    export default {

        props: {

            name: {
                type: String,
                required: true
            },

            grouped: {
                type: Boolean,
                default: true,
            },

            labeled: {
                type: Boolean,
                default: true
            },

            labelWidth: {
                type: Number,
                default: 0,
            },

            controlWidth: {
                type: Number,
                default: 0,
            },

            value: {
                type: [Array, Object]
            },

        },

        data() {
            return {
                privateList: this.value
            }
        },

        computed: {

            horizontal() {
                this.labelWidth > 0 && this.controlWidth > 0
            },

            labelColumn() {
                return this.labelWidth > 0 ? 'col-sm-' + this.labelWidth : ''
            },

            controlColumn() {
                return this.controlWidth > 0 ? 'col-sm-' + this.controlWidth : ''
            },

            list: {
                
                get() {
                    if (this.privateList instanceof Object) {
                        return this.decodeObject(this.privateList)
                    }
                },

                set(payload) {

                    let encodable = this.list.slice()

                    encodable[encodable.findIndex(item => item.name === payload.name)] = payload

                    if (this.privateList instanceof Object) {
                        this.privateList = this.encodeToObject(encodable)
                    }
                },

            },

        },

        watch: {
            value(newVal) {
                this.privateList = newVal
            },
        },

        mounted() {
            this.prepareComponent()
        },

        methods: {

            prepareComponent() {
                //
            },

            updateList(payload) {
                this.list = payload
                this.$emit('input', this.privateList)
            },

            decodeObject(decodable) {
                
                let intended = []
                
                for (let key in decodable) {
                    intended.push({ name: key, state: decodable[key] })
                }

                return intended

            },

            encodeToObject(encodable) {
                
                let intended = {}

                for (let item of encodable) {
                    intended[item.name] = item.state
                }

                return intended

            },

        },

        components: {
            'check-list-item': CheckListItem,
        }

    }

</script>
