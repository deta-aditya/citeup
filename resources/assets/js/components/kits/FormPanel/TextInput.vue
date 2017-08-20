
<template>
    <div :class="{'form-group': grouped, 'has-error': hasError}">
        <label v-if="labeled" :for="name" :class="['control-label', labelColumn]">
            <slot></slot>
        </label>
        <div :class="[controlColumn]">
            <input
                type="text" 
                class="form-control"
                :id="name"
                :name="name" 
                :value="value" 
                :required="required"
                :disabled="disabled"
                :placeholder="placeholder"
                :autofocus="autofocus"
                :maxlength="maxlength"
                @input="input($event.target.value)">
            <span class="help-block" v-show="hasError">
                <strong>{{ localError.message }}</strong>
            </span>
            <slot name="help-block"></slot>
        </div>
    </div>
</template>

<script>

    import CanShowError from '../../Citeup/Error/CanShowError'

    export default {

        mixins: [CanShowError],

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

            placeholder: {
                type: String,
                default: ''
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
