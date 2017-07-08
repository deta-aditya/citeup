<!--

RadioVerticalLg
===============
An eye candy replacement for radio inputs with vertically stacked large buttons.

-->

<template>
    <div class="list-group">
        <radio-button 
            v-for="radio in radios"
            v-model="current"
            container="RadioVerticalLg"
            :key="radio.id"
            :name="name"
            :value="radio.value"
            :img="radio.img || null">

            <template slot="header">{{ radio.header || radio.value }}</template>
            <template slot="text">{{ radio.text }}</template>

        </radio-button>
    </div>
</template>

<script>
    import RadioButton from './RadioButton.vue'

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

            /**
             * The radio items.
             * Structure: {
             *   id: Number,
             *   value: Mixed,
             *   text: String,
             *   header: String (optional),
             *   img: String (optional),
             * }
             */
            radios: {
                type: Array,
                required: true,
                validator(value) {

                    for (let item of value) {
                        if (! ((item instanceof Object) && (
                            _.has(item, 'id') &&
                            _.has(item, 'value') &&
                            _.has(item, 'text')
                        ))) {
                            return false;
                        };
                    }

                    return true;
                }
            }
        },

        /**
         * The supporting components.
         */
        components: {
            'radio-button': RadioButton
        },

        /**
         * The component's data.
         */
        data() {
            return {

                /**
                 * The current value of the radio button.
                 */
                current: '',
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
                //
            },
        }
    }
</script>
