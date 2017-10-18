
<template>
    <div id="questions-create">
        <form-panel ref="formPanel" method="post" action="/questions" :model="question" :horizontal="true" @submitted="preview">
            <template slot="title">Buat Pertanyaan</template>
            <template slot="header-control">
                <router-link :to="{ name: 'Pertanyaan Quiz' }" class="btn btn-default">Kembali</router-link>
            </template>
            <multiline-input name="content" :required="true" :label-width="2" :control-width="10" v-model="question.content" :maxlength="9999">
                Pertanyaan
            </multiline-input>
            <multiline-input :name="'choice-' + (n - 1) + 'content'" :required="true" :label-width="2" :control-width="10" :maxlength="9999" v-model="question.choices[n - 1].content" v-for="n in 5" :key="n + 'choice'">
                Jawaban {{ n }}
            </multiline-input>
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

    import QuestionsMixin from './QuestionsMixin'
    import FormPanel from '../../kits/FormPanel/FormPanel.vue'
    import MultilineInput from '../../kits/FormPanel/MultilineInput.vue'

    export default {
        
        mixins: [QuestionsMixin],

        data() {
            return {
                question: {
                    choices: [
                        {}, {}, {}, {}, {}
                    ]
                },
            }
        },

        methods: {

            preview() {
                this.$router.push({ name: 'Pertanyaan Quiz' })
            },

            submit() {
                this.$refs.formPanel.submit()
            },

        },

        components: {
            'form-panel': FormPanel,
            'multiline-input': MultilineInput,
        }

    }

</script>
