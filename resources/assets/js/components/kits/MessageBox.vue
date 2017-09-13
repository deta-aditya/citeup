
<template>
    <div :id="boxId" class="modal message-box fade" tabindex="-1" role="dialog">
        <div :class="['modal-dialog', sizeClass]" role="document">
            <div class="modal-content">
                <div class="modal-body" v-if="! headerless">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" v-if="dismissable">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><slot name="title"></slot></h4>
                </div>
                <div class="modal-body" :style="[ bodyAlignmentClass ]">
                    <slot></slot>
                    <slot name="buttons" v-if="footerless"></slot>
                </div>
                <div class="modal-body" v-if="! footerless">
                    <slot name="buttons"></slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {

        props: {

            name: {
                type: String,
                required: true,
            },

            size: {
                type: String,
                default: '',
            },

            backdrop: {
                type: [Boolean, String],
                default: true,
            },

            show: {
                type: Boolean,
                default: false,
            },

            dismissable: {
                type: Boolean,
                default: true,
            },

            headerless: {
                type: Boolean,
                default: false,
            },

            footerless: {
                type: Boolean,
                default: false,
            },

        },

        data() {
            return {
                modalElement: null,
            }
        },

        computed: {
            
            boxId() {
                return 'message-box-' + this.name
            },

            sizeClass() {
                return this.size === '' ? '' : 'modal-' + this.size
            },

            bodyAlignmentClass() {
                return this.footerless ? { textAlign: 'left' } : {}
            },

            modalOptions() {
                return {
                    backdrop: this.backdrop,
                    show: this.show,
                }
            },

        },

        mounted() {
            this.prepareComponent()
            this.registerEvents()
        },

        methods: {

            prepareComponent() {
                this.modalElement = $('#' + this.boxId).modal(this.modalOptions)
            },

            registerEvents() {
                $(this.modalElement).on('shown.bs.modal', e => this.$emit('shown', e))
                $(this.modalElement).on('hidden.bs.modal', e => this.$emit('hidden', e))
            },

            open() {
                this.modalElement.modal('show')
            },

            close() {
                this.modalElement.modal('hide')
            }

        },

    }

</script>
