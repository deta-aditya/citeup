
<template>
    <div :class="{'form-group': grouped}">
        <label v-if="labeled" :for="name" :class="['control-label', labelColumn]">
            <slot></slot>
        </label>
        <div :class="[controlColumn]">
            <div class="checkbox">
                <input 
                    class="switch-button" 
                    ref="switch" 
                    type="checkbox" 
                    :id="name" 
                    :name="name" 
                    :value="value" 
                    :checked="checked" 
                    :disabled="disabled">
            </div>
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

            disabled: {
                type: Boolean,
                default: false
            },

            labeled: {
                type: Boolean,
                default: true
            },

            checked: {
                type: Boolean,
                default: false
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
                required: true
            },

        },

        model: {
            prop: 'checked',
        },

        data() {
            return {
                invoked: false,
                switch: null,
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

        },

        watch: {
            checked(newVal) {

                if (this.invoked) {
                    return
                }

                this.invoked = true
                this.switch.bootstrapSwitch('toggleState', newVal)
            },
        },

        mounted() {
            this.prepareComponent()
        },

        methods: {

            prepareComponent() {
                this.switch = $(this.$refs.switch).bootstrapSwitch()
                this.switch.on('switchChange.bootstrapSwitch', this.check)
            },

            check(e, state) {
                this.$emit('input', state)
            },

        },

    }

</script>
