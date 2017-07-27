
<template>
    <div :class="{'form-panel': true, 'form-horizontal': horizontal}">
        <div class="panel panel-default">
            <slot v-if="bodiless && formless">
            </slot>
            <api-form ref="apiForm" :method="method" :action="action" :model="model" :multipart="multipart" v-else-if="bodiless && ! formless">
                <slot></slot>
            </api-form>
            <template v-else>
                <div class="panel-body" v-if="! headerless">
                    <div class="pull-right">
                        <slot name="header-control"></slot>
                    </div>
                    <h1 class="page-title"><slot name="title"></slot></h1>
                </div>
                <div class="panel-body">
                    <slot v-if="formless"></slot>
                    <api-form ref="apiForm" :method="method" :action="action" :model="model" :multipart="multipart" v-else>
                        <slot></slot>
                    </api-form>
                </div>
                <div class="panel-body" v-if="! footerless">
                    <slot name="footer-control"></slot>
                </div>
            </template>
        </div>  
    </div>
</template>

<script>

    import ApiForm from '../../forms/ApiForm.vue'

    export default {

        props: {

            method: {
                type: String,
            },

            action: {
                type: String,
            },

            model: {
                type: Object,  
            },

            multipart: {
                type: Boolean,
                default: false,
            },
            
            formless: {
                type: Boolean,
                default: false,
            },

            bodiless: {
                type: Boolean,
                default: false,
            },

            headerless: {
                type: Boolean,
                default: false,
            },

            footerless: {
                type: Boolean,
                default: false,
            },

            horizontal: {
                type: Boolean,
                default: false,
            },

        },

        data() {
            return {
                apiForm: null,
            }
        },

        model: {
            props: 'model',
        },

        mounted() {
            this.prepareComponent()
            this.registerEvents()
        },

        methods: {

            prepareComponent() {
                if (! this.formless) {
                    this.apiForm = this.$refs.apiForm
                }
            },

            registerEvents() {
                
                if (this.formless) {
                    return
                }

                this.apiForm.$on('submitting', payload => this.$emit('submitting', payload))
                this.apiForm.$on('submitted', payload => this.$emit('submitted', payload))
            },

            submit() {
                
                if (this.formless) {
                    return
                }

                this.apiForm.submit()
            },

        },

        components: {
            'api-form': ApiForm,
        },

    }

</script>
