
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
                        <router-link class="btn btn-link question-navigate" :to="{ name: 'QuestionView', params: { id: id - (-1) }}" v-if="id < 50">Selanjutnya &raquo;</router-link>
                    </div>
                </div>
                <h1 class="question-title">Pertanyaan {{ id }}</h1>
                <div class="question-content">Lorem ipsum dolor sit amet consectetur adipiscing elit?</div>
                <div class="question-img-placeholder" v-if="id % 4 == 0">
                    <img class="img-rounded question-img" src="http://localhost:8000/images/web/main_illustration.png">
                </div>
                <ul class="question-choices super-list nav nav-pills nav-stacked">
                    <li>
                        <a @click.prevent="choose($event.target)" href="#" class="choice-item super-list-item">
                            <div class="super-list-number">
                                <span>A</span>
                            </div>
                            <div class="super-list-content">Lorem Ipsum</div>
                        </a>
                    </li>
                    <li>
                        <a @click.prevent="choose($event.target)" href="#" class="choice-item super-list-item">
                            <div class="super-list-number">
                                <span>B</span>
                            </div>
                            <div class="super-list-content">Dolor Sit</div>
                        </a>
                    </li>
                    <li>
                        <a @click.prevent="choose($event.target)" href="#" class="choice-item super-list-item">
                            <div class="super-list-number">
                                <span>C</span>
                            </div>
                            <div class="super-list-content">Amet Consectetur</div>
                        </a>
                    </li>
                    <li>
                        <a @click.prevent="choose($event.target)" href="#" class="choice-item super-list-item">
                            <div class="super-list-number">
                                <span>D</span>
                            </div>
                            <div class="super-list-content">Adipiscing Elit</div>
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
                        <router-link class="btn btn-link question-navigate" :to="{ name: 'QuestionView', params: { id: id - (-1) }}" v-if="id < 50">Selanjutnya &raquo;</router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import { mapGetters } from 'vuex'
import LogikaGuard from './LogikaGuard'

const GETTERS_STAGE = ['finished']

export default {

    mixins: [LogikaGuard],

    props: {
        id: {
            type: [String, Number],
            required: true,
        }
    },

    computed: _.merge(mapGetters('stage', GETTERS_STAGE), {
        linkToQuestionSelect() {
            return { name: this.finished ? 'Answers' : 'Root' }
        },
    }),

    methods: {
        choose(target) { // Later change to only accept id and use store
            if (target.classList.contains('choice-item')) {
                target.classList.add('chosen')
            }
        }
    }

}

</script>
