
<template>
    <div :class="{'form-group': grouped}">
        <label v-if="labeled" :for="name" :class="['control-label', labelColumn]">
            <slot></slot>
        </label>
        <div :class="[controlColumn]">
            <trix-editor ref="trix" @trix-change="privateValue = $event.target.innerHTML"></trix-editor>
            <slot name="help-block"></slot>
        </div>
    </div>
</template>

<script>

    require('trix')

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

            required: {
                type: Boolean,
                default: false
            },

            labeled: {
                type: Boolean,
                default: true
            },

            maxlength: {
                type: Number,
                default: 191
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
                type: String
            },

        },

        data() {
            return {
                trixed: false,
                trix: null,
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

            privateValue: {
                get() {
                    return this.value
                },

                set(newVal) {
                    this.$emit('input', newVal)
                },
            },

        },

        watch: {

            value(newVal) {
                if (this.trixed) {
                    return
                }

                this.trix.editor.setSelectedRange([0, 0])
                this.trix.editor.insertHTML(newVal)
                this.trixed = true
            },
            
        },

        mounted() {
            this.prepareComponent()
        },

        methods: {

            prepareComponent() {
                this.trix = this.$refs.trix
            },

        },

    }

</script>
