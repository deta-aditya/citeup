<!--

RadioVerticalLg
===============
An eye candy replacement for radio inputs with vertically stacked large buttons.
The slots should be filled with a group of RadioButton components.

-->

<template>
    <div class="list-group">
        <slot></slot>
    </div>
</template>

<script>
    export default {
        /**
         * The component's props.
         */
        props: {

            /**
             * The input's name.
             */
            name: {
                type: String,
                required: true
            },
        },

        /**
         * The component's data.
         */
        data() {
            return {
                //
            };
        },

        /**
         * Prepare the component (Vue 1.x).
         */
        ready() {
            this.prepareComponent();
        },

        /**
         * Prepare the component (Vue 2.x).
         */
        mounted() {
            this.prepareComponent();
        },

        methods: {
            /**
             * Prepare the component.
             */
            prepareComponent() {
                this.sopChildren();
            },

            /**
             * Give the children some props.
             */
            sopChildren() {
                var self = this;

                // Give each children container information.
                this.$children.forEach(function (child) {
                    child.container = 'radio-vertical-lg';
                });
            }
        }
    }
</script>
