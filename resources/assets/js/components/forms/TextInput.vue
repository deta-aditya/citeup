
<style lang="scss" scoped>

    .rich-editor {
        height: 200px
    }

</style>

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
            :maxlength="maxlength"
            @input="input($event.target.value)" 
            >
        <template v-else-if="rich">
            <div :id="name" class="rich-editor"></div>
        </template>
        <textarea 
            v-else
            class="form-control rich-editor"
            :id="name"
            :name="name" 
            :value="value" 
            :required="required"
            :disabled="disabled"
            :autofocus="autofocus"
            :maxlength="maxlength"
            @input="input($event.target.value)"></textarea>
    </div>
</template>

<script>

    import Quill from 'quill'

    export default {

        data() {
            return {
                editor: {}
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

            maxlength: {
                type: Number,
                default: 255
            },

            rich: {
                type: Boolean,
                default: false
            },

            value: {
                type: String
            }

        },

        computed: {

            isSingleLine() {
                return ! this.multiline
            }

        },

        watch: {

            value() {
                
                if (this.rich && this.value) {
                    this.editor.setText(this.value)
                }

            }

        },

        mounted() {

            if (this.rich) {
                this.initRichEditor()
            }

        },

        methods: {

            input(value) {
                this.$emit('input', value)
            },

            initRichEditor() {

                var self = this

                this.editor = new Quill('#' + this.name, {
                    theme: 'snow'
                })

                this.editor.on('text-change', () => {

                    if (self.editor.getLength() > self.maxlength) {
                        self.editor.deleteText(self.maxlength, 1)
                    }

                    self.input(self.editor.getContents().ops[0].insert)
                })

            },
        }
    }
</script>