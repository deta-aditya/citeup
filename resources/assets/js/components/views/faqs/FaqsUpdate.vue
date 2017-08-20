
<template>
    <div id="faqs-create">
        <form-panel ref="formPanel" method="put" :action="'/faqs/' + id" :model="faq" :horizontal="true" @submitted="preview">
            <template slot="title">Sunting FAQ</template>
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
    import Citeup from '../../../citeup'
    import FormPanel from '../../kits/FormPanel/FormPanel.vue'
    import TextInput from '../../kits/FormPanel/TextInput.vue'
    import RichInput from '../../kits/FormPanel/RichInput.vue'

    export default {

        mixins: [FaqsMixin],

        props: {

            id: {
                type: [Number, String],
                required: true
            }

        },

        data() {
            return {
                formPanel: null,
                faq: {},
            }
        },

        created() {
            this.getFaq()
        },

        mounted() {
            this.prepareComponent()
        },

        methods: {

            getFaq() {
                Citeup.get('/faqs/' + this.id).then(response => {
                    this.faq = response.data.data.faq
                })
            },

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
