
<style lang="scss" scoped>

    .form-async {

        fieldset {

            // border-bottom: 1px solid #ddd;
            // margin-bottom: 20px;

            legend {
                // color: #aaa;
                // margin-bottom: 5px;
                // font-weight: 600;
                // font-size: 11pt;
                // border-bottom: none;
                // text-transform: uppercase;
            }

        }

    }

</style>

<template>
    <form @submit.prevent="requestToApi" ref="realForm" class="form-async" role="form" :method="method" :action="action">
        <csrf-input></csrf-input>
        <slot></slot>
    </form>
</template>

<script>
    import CsrfInput from './CsrfInput.vue';
    import Citeup from '../../citeup';

    export default {

        props: {

            method: {
                type: String,
                required: true,
                validation(value) {
                    let lowercased = value.toLowerCase()

                    return (
                        lowercased === 'get' ||
                        lowercased === 'post' ||
                        lowercased === 'put' ||
                        lowercased === 'delete'
                    )
                }
            },

            action: {
                type: String,
                required: true
            },

            model: {
                type: Object,
                required: true   
            },

            multipart: {
                type: Boolean,
                default: false
            },

        },

        mounted() {
            this.prepareComponent();
        },

        methods: {
            prepareComponent() {
                if (this.multipart) {
                    this.$refs.realForm.setAttribute('enctype', 'multipart/form-data')
                }
            },

            requestToApi() {
                this.$emit('submitting', this.model)

                Citeup[this.method](this.action, this.model).then((response) => {
                    this.$emit('submitted', response.data.data)
                })
            }
        },

        components: {
            'csrf-input': CsrfInput,
        }

    }
</script>
