
<template>
    <div :class="{'form-group': grouped}">
        <label v-if="labeled" :for="name" :class="['control-label', labelColumn]">
            <slot></slot>
        </label>
        <div :class="[controlColumn]">
            <div class="input-group">
                <span class="input-group-addon">{{ currency }}</span>
                <input
                    type="text"
                    ref="element"
                    class="form-control currency-input"
                    :id="name"
                    :name="name" 
                    :value="formatted" 
                    :required="required"
                    :disabled="disabled"
                    :autofocus="autofocus"
                    @input="input($event.target.value)"
                    @blur="format">
            </div>
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

            currency: {
                type: String,
                default: 'Rp',
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
                type: [String, Number]
            },

        },

        data() {
            return {
                element: null,
                privateValue: this.value,
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

            formatted: {
                
                get() {
                    
                    var counter = 0
                    var value = String(this.privateValue)
                    var formatted = ''
                    var checkpoint = 0

                    for (let i = value.length - 1; i >= 0; i--) {

                        if (counter > 0 && counter % 3 === 0) {
                            formatted += '.'
                        }

                        formatted += value[i]

                        counter++
                    }

                    return formatted.split('').reverse().join('')
                },

                set(newVal) {
                    this.privateValue = Number(newVal.split('.').join(''))
                },

            },

        },

        watch: {
            value(newVal) {
                this.privateValue = newVal
            },
        },

        mounted() {
            this.prepareComponent()
        },

        methods: {

            prepareComponent() {
                this.element = this.$refs.element
            },

            input(value) {

                let cleaned = value.split('.').join('')

                if (isNaN(cleaned)) {
                    this.element.value = this.formatted
                    return
                }

                this.$emit('input', cleaned)

            },

            format() {
                this.formatted = this.element.value
            },

        },

    }

</script>
