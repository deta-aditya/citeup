
<template>
    <div id="question-view">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                <div class="row text-center question-navs">
                    <div class="col-sm-3">
                        <router-link class="btn btn-link question-navigate" :to="{ name: 'QuestionView', params: { id: id - 1 }}" v-if="id > 1">&laquo; Sebelumnya</router-link>
                    </div>
                    <div class="col-sm-6">
                        <router-link class="btn btn-link question-navigate" :to="linkToQuestionSelect"><b>Pilih Soal</b></router-link>
                    </div>
                    <div class="col-sm-3">
                        <router-link class="btn btn-link question-navigate" :to="{ name: 'QuestionView', params: { id: id - (-1) }}" v-if="id < questions.length">Selanjutnya &raquo;</router-link>
                    </div>
                </div>
                <h1 class="question-title">Pertanyaan {{ id }}</h1>
                <div class="question-content">{{ question.content }}</div>
                <div class="question-img-placeholder" v-if="question.picture !== null">
                    <img class="img-rounded question-img" :src="question.picture | assetify">
                </div>
                <ul class="question-choices super-list nav nav-pills nav-stacked">
                    <li v-for="(choice, index) in question.choices">
                        <a @click.prevent="choose(choice)" href="#" class="choice-item super-list-item" :class="{'chosen': hasAnsweredChoice(choice.id)}">
                            <div class="super-list-number">
                                <span>{{ index | letterify }}</span>
                            </div>
                            <div class="super-list-content">{{ choice.content }}</div>
                        </a>
                    </li>
                </ul>
                <div class="row text-center question-navs">
                    <div class="col-sm-3">
                        <router-link class="btn btn-link question-navigate" :to="{ name: 'QuestionView', params: { id: id - 1 }}" v-if="id > 1">&laquo; Sebelumnya</router-link>
                    </div>
                    <div class="col-sm-6">
                        <router-link class="btn btn-link question-navigate" :to="linkToQuestionSelect"><b>Pilih Soal</b></router-link>
                    </div>
                    <div class="col-sm-3">
                        <router-link class="btn btn-link question-navigate" :to="{ name: 'QuestionView', params: { id: id - (-1) }}" v-if="id < questions.length">Selanjutnya &raquo;</router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import { assetify } from '../../../../components/Citeup/Helper'
import LogikaGuard from './LogikaGuard'
import { mapState, mapGetters, mapActions } from 'vuex'

const STATE_QUESTIONS = {
    question: state => state.current,
    questions: state => state.repo,
}

const GETTERS_STAGE = ['finished']

const ACTIONS_QUESTIONS = ['setCurrent', 'loadQuestions']

const GETTERS_ANSWERS = ['hasAnsweredChoice', 'answerOfQuestion']
const ACTIONS_ANSWERS = ['answer', 'persistAnswers']

export default {

    mixins: [LogikaGuard],

    props: {
        id: {
            type: [String, Number],
            required: true,
        }
    },

    computed: _.merge(
        mapState('questions', STATE_QUESTIONS), 
        mapGetters('stage', GETTERS_STAGE),
        mapGetters('answers', GETTERS_ANSWERS), {
        linkToQuestionSelect() {
            return { name: this.finished ? 'Answers' : 'Root' }
        },
    }),

    filters: {
        letterify(number) {
            switch (number) {
                case 0: return 'A'
                case 1: return 'B'
                case 2: return 'C'
                case 3: return 'D'
                case 4: return 'E'
            }
        },
        assetify
    },

    created() {
        if (this.questions.length === 0) {
            return this.$router.push({ name: 'Root' })
        }

        this.setCurrent(this.id)
    },

    beforeRouteUpdate(to, from, next) {
        this.persistAnswers()
        this.setCurrent(to.params.id)
        next()
    },

    beforeRouteLeave(to, from, next) {
        this.persistAnswers()
        next()
    },

    methods: _.merge(
        mapActions('questions', ACTIONS_QUESTIONS),
        mapActions('answers', ACTIONS_ANSWERS), {
        choose(choice) {
            if (this.finished) {
                return
            }

            this.answer(choice)
        }
    }),

}

</script>
