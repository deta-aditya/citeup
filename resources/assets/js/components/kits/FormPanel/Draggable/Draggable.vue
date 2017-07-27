
<template>
    <div :class="{'form-group': grouped}">
        <label v-if="labeled" :for="name" :class="['control-label', labelColumn]">
            <slot></slot>
        </label>
        <div :class="[controlColumn]">
            <draggable :id="name" :list="value" :options="options" class="list-group draggable-list">
                <slot name="list"></slot>
            </draggable>
            <slot name="help-block"></slot>
        </div>
    </div>
</template>

<script>

    import Draggable from 'vuedraggable'

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
                type: Array
            },

        },

        data() {
            return {
                options: { draggable: '.draggable-list-item' }
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

        mounted() {
            this.prepareComponent()
        },

        methods: {

            prepareComponent() {
                //
            },

        },

        components: {
            'draggable': Draggable,
        }

    }

</script>
