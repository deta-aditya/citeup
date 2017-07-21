
<template>
    <div class="form-group">
        <label v-if="labeled" :for="name" class="control-label">
            <slot></slot>
        </label>
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
</template>

<script>

    export default {

        props: {

            name: {
                type: String,
                required: true
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
