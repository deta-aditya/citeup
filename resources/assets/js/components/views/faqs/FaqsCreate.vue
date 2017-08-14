
<template>
    <div id="faqs-create">
        <form-panel ref="formPanel" method="post" action="/faqs" :model="faq" :horizontal="true" @submitted="preview">
            <template slot="title">Buat FAQ</template>
            <template slot="header-control">
                <router-link :to="{ name: 'FAQ' }" class="btn btn-default">Kembali</router-link>
            </template>
            <text-input name="question" :required="true" :label-width="2" :control-width="10" v-model="faq.question">
                Pertanyaan
            </text-input>
            <rich-input name="answer" :required="true" :label-width="2" :control-width="10" v-model="faq.answer">
                Jawaban
            </rich-input>
            <template slot="footer-control">
                <div class="text-right">
                    <button type="button" class="btn btn-primary" @click="submit">
                        Selesai
                    </button>
                </div>
            </template>
        </form-panel>
    </div>
</template>

<script>

    import FaqsMixin from './FaqsMixin'
    import FormPanel from '../../kits/FormPanel/FormPanel.vue'
    import TextInput from '../../kits/FormPanel/TextInput.vue'
    import RichInput from '../../kits/FormPanel/RichInput.vue'

    export default {

        mixins: [FaqsMixin],

        data() {
            return {
                formPanel: null,
                faq: {},
            }
        },

        mounted() {
            this.prepareComponent()
        },

        methods: {

            prepareComponent() {
                this.formPanel = this.$refs.formPanel
            },

            preview() {
                this.$router.push({ name: 'FAQ' })
            },

            submit() {
                this.formPanel.submit()
            },

        },

        components: {
            'form-panel': FormPanel,
            'text-input': TextInput,
            'rich-input': RichInput,
        }

    }

</script>
