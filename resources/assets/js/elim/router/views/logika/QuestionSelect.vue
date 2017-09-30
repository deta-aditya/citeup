
<template>
    <div id="question-select">
        <message-box ref="finishBox" name="finish-box" class="text-center" :headerless="true">
            <h2 class="finish-box-title">Yakin Selesai?</h2>
            <p class="finish-box-subtitle">Masih tersisa waktu sebelum seleksi berakhir.</p>
            <p>Silahkan periksa ulang pekerjaan Anda. Perlu diingat bahwa Anda tidak akan dapat menjawab soal apapun setelah menekan tombol selesai!</p>
            <div slot="buttons" class="text-right">
                <button type="button" class="btn btn-default" data-dismiss="modal">Periksa Kembali</button>
                <button type="button" class="btn btn-primary" @click="finish">Selesai</button>
            </div>
        </message-box>
        <div class="greeting-text">{{ finished ? 'Pilih Soal yang Akan Dilihat Jawabannya' : 'Pilih Soal yang Akan Dikerjakan' }} </div>
        <div class="question-answered">
            <template v-if="! finished">Anda telah menjawab 19 dari 50 soal.</template>
            <template v-else>Anda menyelesaikan seleksi pada {{ attempt.finished_at | formatDateStandard }}.</template>
        </div>
        <div class="row question-list">
            <div class="text-center cloak-content" :style="{ height: '200px' }" v-if="repoIsEmpty">
                <p class="lead">Memuat Soal</p>
                <i class="fa fa-spinner fa-pulse fa-3x"></i>
            </div>
            <div class="col-sm-1 question-item-placeholder" v-for="(question, index) in questions">
                <a href="#" @click.prevent="toView(question.number)" :class="{ 'question-item': true, 'answered': hasAnsweredQuestion(question.id) }">{{ question.number }}</a>
            </div>
        </div>
        <div class="text-center">
            <button type="button" class="btn btn-lg btn-primary btn-done" @click="openFinishBox" v-if="! finished">Selesai</button>
            <router-link :to="{ name: 'Root' }" type="button" class="btn btn-lg btn-default btn-done" v-else>Kembali</router-link>
        </div>
    </div>
</template>

<script>

    import _ from 'lodash'
    import MessageBox from '../../../../components/kits/MessageBox.vue'
    import { mapState, mapMutations, mapGetters, mapActions } from 'vuex'
    import { formatDateStandard } from '../../../../components/Citeup/Helper'

    const GETTERS_STAGE = ['finished']
    const ACTIONS_STAGE = ['persistFinish']

    const STATE_QUESTIONS = {
        questions: state => state.repo
    }

    const GETTERS_QUESTIONS = ['repoIsEmpty']
    const ACTIONS_QUESTONS = ['loadQuestions', 'setCurrent']

    const STATE_ANSWERS = ['attempt']
    const GETTERS_ANSWERS = ['hasAnsweredQuestion']
    const MUTATIONS_ANSWERS = {
        setAttempt: 'ANSWERS_SET_ATTEMPT'
    }

    export default {
        data() {
            return {}
        },
        created() {
            this.loadQuestionsRepo()
        },
        computed: _.merge(
            mapState('answers', STATE_ANSWERS),
            mapState('questions', STATE_QUESTIONS),
            mapGetters('stage', GETTERS_STAGE),
            mapGetters('questions', GETTERS_QUESTIONS),
            mapGetters('answers', GETTERS_ANSWERS),
        ),
        filters: {
            formatDateStandard,
        },
        methods: _.merge(
            mapActions('stage', ACTIONS_STAGE), 
            mapMutations('answers', MUTATIONS_ANSWERS),
            mapActions('questions', ACTIONS_QUESTONS), {
            loadQuestionsRepo() {
                if (this.repoIsEmpty) {
                    this.loadQuestions()
                }
            },
            openFinishBox() {
                this.$refs.finishBox.open()
            },
            finish() {
                this.$refs.finishBox.close()
                this.persistFinish(this.attempt.id).then(attempt => {
                    this.setAttempt(attempt)
                    this.$router.push({ name: 'Root' })
                })
            },
            toView(id) {
                this.$router.push({ name: 'QuestionView', params: { id }})
            }
        }),
        components: {
            'message-box': MessageBox,
        }
    }

</script>
