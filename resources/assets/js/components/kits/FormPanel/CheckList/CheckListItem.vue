
<template>
    <div ref="element" :class="{'list-group-item': true, 'check-list-item': true, 'active': checked}" role="button" @click="check">
        <slot></slot>
    </div>
</template>

<script>

    export default {

        props: {
            
            name: {
                type: String,
                required: true,
            },

            state: {
                type: Boolean,
                default: false,
            },

        },

        data() {
            return {
                checked: this.state,
            }
        },

        mounted() {
            this.prepareComponent()
        },

        methods: {

            prepareComponent() {
                //
            },

            check() {
                this.checked = ! this.checked
                this.$emit('check', { name: this.name, state: this.checked })
            },

        },

    }

</script>
