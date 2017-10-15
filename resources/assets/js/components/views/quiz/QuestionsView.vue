
<style lang="scss" scoped>
    .question-picture {
        max-height: 350px
    }
</style>

<template>
    <div id="question-view">
        <div class="form-panel">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="pull-right">
                        <router-link class="btn btn-default" :to="{ name: 'Pertanyaan Quiz' }">Indeks</router-link>
                        <router-link class="btn btn-default" :to="{ name: 'Pertanyaan Quiz.Sunting', params: { id: id }}">Sunting</router-link>
                    </div>
                    <h1 class="page-title"><small v-if="user.admin">Pertanyaan Quiz / #{{ id }}</small></h1>
                </div>
                <div class="panel-body text-justify">
                    <div v-html="question.content"></div>
                </div>
                <div class="panel-body text-center" v-if="question.picture !== null">
                    <img :src="question.picture | assetify" class="question-picture">
                </div>
                <table class="table">
                    <tbody>
                        <tr class="text-justify" v-for="(choice, index) in question.choices">
                            <th>Jawaban {{ index + 1 }}</th><td v-html="choice.content"></td>
                        </tr>
                    </tbody>
                </table>
                <div class="panel-body">
                    Dibuat pada {{ question.created_at | normalize }}, terakhir disunting pada {{ question.updated_at | normalize }}
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import moment from 'moment-timezone'
    import Citeup from '../../../citeup'
    import QuestionsMixin from './QuestionsMixin'

    export default {

        mixins: [QuestionsMixin],

        props: {

            id: {
                type: [Number, String],
                required: true
            },

        },

        data() {
            return {
                question: {},
            }
        },

        filters: {

            normalize(value) {
                return moment(value).format('DD MMM, HH:mm')
            },

            assetify(value) {
                return Citeup.appPath + '/' + value
            },

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

        },

    }

</script>
