
<template>
    <div id="questions-create">
        <form-panel ref="formPanel" method="put" :action="'/questions/' + id" :model="question" :horizontal="true" @submitted="preview">
            <template slot="title">Sunting Pertanyaan</template>
            <template slot="header-control">
                <router-link :to="{ name: 'Pertanyaan Quiz' }" class="btn btn-default">Kembali</router-link>
            </template>
            <multiline-input name="content" :label-width="2" :control-width="10" :maxlength="9999" v-model="question.content">
                Pertanyaan
            </multiline-input>
            <file-input name="picture" :label-width="2" :control-width="10" :object-id="question.id" object-type="question" accept="image/*" :store-immediately="true" :crop="false" v-model="question.picture">
                Gambar
            </file-input>
            <multiline-input :name="'choice-' + index + 'content'" :label-width="2" :control-width="10" :maxlength="9999" v-model="question.choices[index].content" v-for="(choice, index) in question.choices" :key="choice.id">
                Jawaban {{ index + 1 }}
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

    import Citeup from '../../../citeup'
    import QuestionsMixin from './QuestionsMixin'
    import FormPanel from '../../kits/FormPanel/FormPanel.vue'
    import FileInput from '../../kits/FormPanel/FileInput.vue'
    import MultilineInput from '../../kits/FormPanel/MultilineInput.vue'

    export default {
        
        mixins: [QuestionsMixin],

        props: {

            id: {
                type: [Number, String],
                required: true
            }

        },

        data() {
            return {
                question: {
                    id: 0,
                    choices: []
                },
            }
        },

        created() {
            this.getQuestion()
        },

        methods: {

            getQuestion() {
                Citeup.get('/questions/' + this.id).then(response => {
                    this.question = response.data.data.question
                })
            },

            preview() {
                this.$router.push({ name: 'Pertanyaan Quiz' })
            },

            submit() {
                this.$refs.formPanel.submit()
            },

        },

        components: {
            'form-panel': FormPanel,
            'file-input': FileInput,
            'multiline-input': MultilineInput,
        }

    }

</script>
