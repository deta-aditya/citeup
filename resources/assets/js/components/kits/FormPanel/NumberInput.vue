
<template>
    <div :class="{'form-group': grouped}">
        <label v-if="labeled" :for="name" :class="['control-label', labelColumn]">
            <slot></slot>
        </label>
        <div :class="[controlColumn]">
            <input
                type="number" 
                class="form-control"
                :id="name"
                :name="name" 
                :value="value" 
                :step="step"
                :min="min"
                :max="max"
                :required="required"
                :disabled="disabled"
                :autofocus="autofocus"
                @input="input($event.target.value)">
            <slot name="help-block"></slot>
        </div>
    </div>
</template>

<script>

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

            labeled: {
                type: Boolean,
                default: true
            },

            step: {
                type: Number,
                default: 1
            },

            min: {
                type: Number,
                default: -128
            },

            max: {
                type: Number,
                default: 128
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
                type: Number
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
                //
            },

            input(value) {
                this.$emit('input', value)
            },

        },

    }

</script>
