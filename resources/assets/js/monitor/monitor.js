
require('../bootstrap')

import Vue from 'vue'
import store from './store/index'

import Citeup from '../citeup'
import { merge } from 'lodash'
import moment from 'moment-timezone'
import Timebar from './components/timebar/Timebar.vue'
import { mapState, mapMutations, mapGetters, mapActions } from 'vuex'

const stageState = mapState('stage', {'stage': 'data'})
const stageActions = mapActions('stage', ['getCurrentStage'])

const entriesGetters = mapGetters('entries', {'entrants': 'list'})
const entriesActions = mapActions('entries', ['getEntries'])

const vm = new Vue({
    store,
    
    data() {
        return {
            activity: null,
            isLoading: true,
        }
    },
    
    computed: merge(stageState, entriesGetters, {
        timebarStart() {
            return this.stage.started_at
        },
        timebarFinish() {
            return this.activity === 1 ? 
                moment(this.stage.started_at).add(2, 'hours').format('YYYY-MM-DD HH:mm:ss') :
                this.stage.finished_at
        },
    }),
    
    created() {
        this.getCurrentStage().then(() => this.isLoading = false)
    },

    mounted() {
        this.activity = document.head.querySelector('meta[name="channel"]').content
        this.getEntries(this.activity)
    },

    methods: merge(stageActions, entriesActions),

    components: { 
        'timebar': Timebar,
    }

}).$mount('#app-elimination')
