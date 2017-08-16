
<template>
    <div :class="{'form-group': grouped}">
        <label v-if="labeled" :for="name" :class="['control-label', labelColumn]">
            <slot></slot>
        </label>
        <div :class="[controlColumn]">
            <input
                ref="datetimepicker"
                type="text" 
                class="form-control"
                :id="name"
                :name="name" 
                :value="value" 
                :required="required"
                :disabled="disabled"
                :autofocus="autofocus">
        </div>
    </div>
</template>

<script>

    import moment from 'moment'

    const DEFAULT_FORMAT = 'YYYY-MM-DD HH:mm:ss'

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

            autofocus: {
                type: Boolean,
                default: false
            },

            disabled: {
                type: Boolean,
                default: false
            },

            format: {
                type: String,
                default: DEFAULT_FORMAT,
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
                type: String,
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

        },

        mounted() {
            this.prepareComponent()
        },

        methods: {

            prepareComponent() {
                this.datetimepicker = $(this.$refs.datetimepicker).datetimepicker({
                    format: this.format
                })
                this.datetimepicker.on('dp.change', this.input)
            },

            input(e) {
                this.$emit('input', e.date.format(this.format))
            },

        },

    }

</script>
