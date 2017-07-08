<!--

RadioButton
===========
The button item used on fancy radio buttons components.

-->

<style lang="scss" scoped>
    .list-group-item {
        padding: 0;

        :hover {
            cursor: pointer;
        }

        .side-img {
            img {
                width: 100px;
            }
        }

        .side-body {
            padding: 10px 15px;
        }
    }
</style>

<template>
    <a href="#"
        ref="wrapper"
        @click.prevent="check" 
        :class="[defaultClasses]">
        <div class="side-img visible-lg-block pull-left">
            <img :src="img">
        </div>
        <div class="side-body pull-left">
            <h4><slot name="header"></slot></h4>
            <p><slot name="text"></slot></p>
        </div>
        <input 
            ref="realRadio"
            class="hidden real-radio" 
            type="radio" 
            :name="name" 
            :value="value">
    </a>
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

            /**
             * The input's initial value.
             */
            value: {
                type: [String, Number],
                required: true
            },

            /**
             * The input's parent container.
             */
            container: {
                type: String,
                required: true
            },

            /**
             * The optional image.
             */
            img: {
                type: String,
                default() {
                    return '/storage/image/default.jpg';
                }
            }
        },

        /**
         * The component's model modifier.
         */
        model: {
            prop: 'checked',
        },

        /**
         * The component's data.
         */
        data() {
            return {
                checked: false,
                defaultClasses: 'clearfix list-group-item radio-button-item-' + this.name,
                selectedClass: 'active'
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
                
                var self = this;
                // This one listens to other radio using jQuery
                // Yeah. It's not beautiful. But for god's sake these are just 
                // simple radio buttons, so no need for complexity.
                $('.radio-button-item-' + this.name).on('click', function (e) {

                    var radioValue = this.getElementsByClassName('real-radio')[0].value;

                    // If the checked radio is not this, uncheck this.
                    // Difference determined by its value.
                    if (Number(radioValue) !== self.value) {
                        self.uncheck();
                    }
                })
            },

            /**
             * Check the radio.
             */
            check() {

                this.$refs.realRadio.checked = true;

                this.$refs.wrapper.classList.add(this.selectedClass);

                this.checked = true;

                this.$emit('input', this.value);
            },

            /**
             * Uncheck the radio.
             */
            uncheck() {

                // We don't need to set false on 'checked' manually since it 
                // will automaticaly uncheck when other radio button is checked.

                this.checked = false;

                this.$refs.wrapper.classList.remove(this.selectedClass);
            }
        }
    }
</script>
