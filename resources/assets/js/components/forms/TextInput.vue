
<template>
    <div class="form-group">
        <label v-if="labeled" :for="name" class="control-label">
            <slot></slot>
        </label>
        <input
            v-if="isSingleLine" 
            type="text" 
            class="form-control"
            :id="name"
            :name="name" 
            :value="value" 
            :required="required"
            :disabled="disabled"
            :autofocus="autofocus"
            @input="input($event.target.value)" 
            >
        <textarea 
            v-else
            class="form-control"
            :id="name"
            :name="name" 
            :value="value" 
            :required="required"
            :disabled="disabled"
            :autofocus="autofocus"
            @input="input($event.target.value)"></textarea>
    </div>
</template>

<script>
    export default {

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

            multiline: {
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

        computed: {

            isSingleLine() {
                return ! this.multiline;
            }
        },

        methods: {

            input(value) {
                this.$emit('input', value)
            }
        }
    }
</script>