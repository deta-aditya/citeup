
require('../bootstrap')

import Vue from 'vue'
import store from './store/index'
import router from './router/index'

import _ from 'lodash'
import Chat from './components/chat/Chat.vue'
import Timebar from './components/timebar/Timebar.vue'
import Countdown from '../components/misc/Countdown.vue'
import MessageBox from '../components/kits/MessageBox.vue'
import { mapState, mapMutations, mapGetters, mapActions } from 'vuex'


const STATE_ANSWERS = ['attempt']
const STATE_STAGE = ['timebarStart', 'timebarFinish']

const GETTERS_STAGE = ['countdown', 'working', 'finished']

const ACTIONS_USER = ['loadCurrentUser']
const ACTIONS_STAGE = ['loadCurrentStage', 'toFinish', 'persistFinish']
const ACTIONS_ANSWERS = ['loadOrStartAttempt']

const MUTATIONS_ANSWERS = {
    setAttempt: 'ANSWERS_SET_ATTEMPT'
}

const MUTATIONS_STAGE = {
    'setTimebarInfo': 'STAGE_SET_TIMEBAR_INFO',
}

const vm = new Vue({
    store, 
    router,
    data() {
        return {
            isLoading: true,
        }
    },
    computed: _.merge(
        mapState('answers', STATE_ANSWERS),
        mapState('stage', STATE_STAGE),
        mapGetters('stage', GETTERS_STAGE),
    ),
    created() {
        this.loadCurrentUser().then(user => {
            this.loadOrStartAttempt(user.entry.id).then(attempt => {
                if (attempt.finished_at !== null && attempt.finished_at !== undefined) {
                    this.toFinish()
                }

                this.loadCurrentStage().then((stage) => {
                    if (stage.id === 4) {
                        this.setTimebarInfo({
                            start: stage.started_at,
                            finish: stage.finished_at,
                        })
                    }

                    this.isLoading = false 
                })
            })
        })
    },
    methods: _.merge(
        mapActions('user', ACTIONS_USER),
        mapActions('stage', ACTIONS_STAGE),
        mapMutations('stage', MUTATIONS_STAGE), 
        mapMutations('answers', MUTATIONS_ANSWERS), 
        mapActions('answers', ACTIONS_ANSWERS), {
        reload() {
            window.location.reload(false)
        },
        finish() {
            this.persistFinish(this.attempt.id).then(attempt => {
                this.setAttempt(attempt)
            })
        }
    }),
    components: { 
        'timebar': Timebar,
        'sticky-chat': Chat,
        'countdown': Countdown,
        'message-box': MessageBox,
    }
}).$mount('#app-elimination')
