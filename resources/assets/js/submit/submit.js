
require('../bootstrap')

import Vue from 'vue'
import store from './store/index'
import router from './router/index'

import Citeup from '../citeup'
import { merge } from 'lodash'
import moment from 'moment-timezone'
import Chat from './components/chat/Chat.vue'
import Timebar from './components/timebar/Timebar.vue'
import Countdown from '../components/misc/Countdown.vue'
import MessageBox from '../components/kits/MessageBox.vue'
import { mapState, mapMutations, mapGetters, mapActions } from 'vuex'

const stageState = mapState('stage', ['timebarStart', 'timebarFinish'])
const stageGetters = mapGetters('stage', ['countdown', 'working', 'finished'])
const stageMutations = mapMutations('stage', { 'setTimebarInfo': 'STAGE_SET_TIMEBAR_INFO' })
const stageActions = mapActions('stage', ['loadCurrentStage', 'toFinish', 'persistFinish'])
const submissionsActions = mapActions('submissions', ['loadOrCreateSubmission', 'persist'])
const userActions = mapActions('user', ['loadCurrentUser'])

const vm = new Vue({
    store, 
    router,
    data() {
        return {
            isLoading: true,
        }
    },
    computed: merge(stageState, stageGetters),
    created() {
        this.loadCurrentUser().then(user => this.prepareSession(user))
    },
    methods: merge(
        stageMutations,
        submissionsActions,
        stageActions,
        userActions, {
        prepareSession(user) {
            this.loadOrCreateSubmission(user.entry.id).then(submission => {
                this.loadCurrentStage().then(stage => {
                    if (stage.id === 5 || submission.picture !== Citeup.defaultImageClean) {
                        this.toFinish()
                    } else if (stage.id === 4) {
                        this.setTimebarInfo({
                            start: stage.started_at,
                            finish: stage.finished_at,
                        })
                    }
                    this.isLoading = false 
                })    
            })            
        },
        autoPersist() {
            this.persist().then(() => {
                this.toFinish()
            })
        },
        reload() {
            window.location.reload(false)
        },
    }),
    components: { 
        'timebar': Timebar,
        'sticky-chat': Chat,
        'countdown': Countdown,
        'message-box': MessageBox,
    }
}).$mount('#app-elimination')
