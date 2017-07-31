
<template>
    <div class="form-group">
        <label v-if="labeled" :for="name" class="control-label">
            <slot></slot>
        </label>
        <div ref="datetimepicker" class="input-group date">
            <input
                type="text" 
                class="form-control"
                :id="name"
                :name="name" 
                :value="value" 
                :required="required"
                :disabled="disabled"
                :autofocus="autofocus">
            <span class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </span>
        </div>
    </div>
</template>

<script>

    import moment from 'moment'

    const DEFAULT_FORMAT = 'YYYY-MM-DD HH:mm:ss'

    export default {

        data() {
            return {
                datetimepicker: null,
            }
        },

        props: {

            name: {
                type: String,
                required: true
            },

            required: {
                type: Boolean,
                default: false
            },

            autofocus: {
                type: Boolean,
                default: false
            },

            disabled: {
                type: Boolean,
                default: false
            },

            labeled: {
                type: Boolean,
                default: true
            },

            value: {
                type: String
            }

        },

        mounted() {
            this.prepareComponent()
        },

        methods: {

            prepareComponent() {

                this.datetimepicker = $(this.$refs.datetimepicker).datetimepicker({
                    format: DEFAULT_FORMAT
                })

                this.datetimepicker.on('dp.change', this.input)
            },

            input(e) {
                this.$emit('input', e.date.format(DEFAULT_FORMAT))
            },

        },

    }

</script>
