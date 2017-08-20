
<template>
    <button type="button" ref="element" :class="[ 'btn', stateClass ]" @click="check" :disabled="disabled">
        <slot></slot>
    </button>
</template>

<script>

    export default {

        props: {
            
            id: {
                required: true,
            },

            state: {
                type: Boolean,
                default: false,
            },

            disabled: {
                type: Boolean,
                default: false,
            },

        },

        data() {
            return {
                list: null,
                checked: this.state,
            }
        },

        computed: {

            stateClass() {
                return this.checked ? 'btn-primary' : 'btn-default'
            },

        },

        mounted() {
            this.prepareComponent()
            this.registerListeners()
        },

        methods: {

            prepareComponent() {
                this.list = this.$parent
            },

            registerListeners() {
                this.list.$on('input', this.changeState)
            },

            changeState(id) {
                this.checked = this.id == id
            },

            check() {
                if (this.disabled) {
                    return
                }

                this.$emit('check', this.id)
            },

        },

    }

</script>
