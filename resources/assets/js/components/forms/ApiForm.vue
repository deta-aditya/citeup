
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
    <form @submit.prevent="submit" ref="realForm" class="form-async" role="form" :method="method" :action="action">
        <csrf-input></csrf-input>
        <slot></slot>
    </form>
</template>

<script>
    import _ from 'lodash';
    import { mapMutations } from 'vuex';
    import Citeup from '../../citeup';
    import CsrfInput from './CsrfInput.vue';

    const MUTATIONS = ['setError', 'clearError']

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

        methods: _.merge(mapMutations(MUTATIONS), {
            prepareComponent() {
                if (this.multipart) {
                    this.$refs.realForm.setAttribute('enctype', 'multipart/form-data')
                }
            },

            submit() {
                
                this.$emit('submitting', this.model)

                this.clearError()

                Citeup[this.method](this.action, this.model).then((response) => {
                    this.$emit('submitted', response.data.data)
                }).catch((error) => {
                    this.$emit('error', error.response)
                    this.setError({ status: error.response.status, messages: error.response.data })
                })
            }
        }),

        components: {
            'csrf-input': CsrfInput,
        }

    }
</script>
