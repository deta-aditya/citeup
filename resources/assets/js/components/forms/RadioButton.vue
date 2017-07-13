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
             * The input's initial value.
             */
            value: {
                type: [String, Number],
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
                name: '',
                container: '',
                checked: false,
                selectedClass: 'active',
                defaultClasses: 'clearfix list-group-item'
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
                var parent = this.$parent;

                let identifierClass = 'radio-button-item-' + parent.name;

                self.name = parent.name;

                // Attach an identifier class to the wrapper element.
                self.$refs.wrapper.classList.add(identifierClass);

                // Listens to other radios input under the parent's scope.
                parent.$on('radio-checked', function (value) {

                    var radioValue = self.$refs.realRadio.value;

                    // If the checked radio is not this, uncheck this.
                    // Difference determined by its value.
                    if (Number(radioValue) !== value) {
                        self.uncheck();
                    }
                });
            },

            /**
             * Check the radio.
             */
            check() {

                // Check the real radio button.
                this.$refs.realRadio.checked = true;

                // Add .selected class.
                this.$refs.wrapper.classList.add(this.selectedClass);

                // Change the checked state.
                this.checked = true;

                // Emit parent component's radio-checked event.
                this.$parent.$emit('radio-checked', this.value);
            },

            /**
             * Uncheck the radio.
             */
            uncheck() {

                // We don't need to set false on 'checked' manually since it 
                // will automaticaly uncheck itself.

                // Change the checked state.
                this.checked = false;

                // Remove .selected class.
                this.$refs.wrapper.classList.remove(this.selectedClass);
            },
        }
    }
</script>
