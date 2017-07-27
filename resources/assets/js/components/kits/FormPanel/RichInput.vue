
<template>
    <div :class="{'form-group': grouped}">
        <label v-if="labeled" :for="name" :class="['control-label', labelColumn]">
            <slot></slot>
        </label>
        <div :class="[controlColumn]">
            <wysiwyg v-model="privateValue"></wysiwyg>
            <slot name="help-block"></slot>
        </div>
    </div>
</template>

<script>

    import wysiwyg from 'vue-wysiwyg'
    import Vue from 'vue'

    Vue.use(wysiwyg, {
        hideModules: { image: true }
    })

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
                }
            },

        },

        mounted() {
            this.prepareComponent()
        },

        methods: {

            prepareComponent() {
                //
            },

        },

    }

</script>
