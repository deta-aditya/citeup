
require('../bootstrap')

import Vue from 'vue'
import store from './store/index'
import router from './router/index'

import _ from 'lodash'
import { mapGetters, mapActions } from 'vuex'
import Chat from './components/chat/Chat.vue'
import Timebar from './components/timebar/Timebar.vue'
import Countdown from '../components/misc/Countdown.vue'
import MessageBox from '../components/kits/MessageBox.vue'

const GETTERS_STAGE = ['countdown', 'working', 'finished']

const ACTIONS_USER = ['loadCurrentUser']
const ACTIONS_STAGE = ['loadCurrentStage', 'toFinish']
const ACTIONS_ANSWERS = ['loadOrStartAttempt']

const vm = new Vue({
    store, 
    router,
    computed: mapGetters('stage', GETTERS_STAGE),
    created() {
        this.loadCurrentStage()
        this.loadCurrentUser().then(user => {
            this.loadOrStartAttempt(user.entry.id)
        })
    },
    methods: _.merge(
        mapActions('user', ACTIONS_USER),
        mapActions('stage', ACTIONS_STAGE), 
        mapActions('answers', ACTIONS_ANSWERS), {
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
