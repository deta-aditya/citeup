
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
const entriesMutations = mapMutations('entries', {'readChatOfEntry': 'ENTRIES_READ_CHAT'})
const entriesActions = mapActions('entries', ['getEntries'])

const chatsState = mapState('chats', {'chats': 'data'})
const chatsActions = mapActions('chats', ['getChats', 'sendChat', 'readChats'])

const vm = new Vue({
    store,
    
    data() {
        return {
            selected: {},
            sendable: {},
            activity: null,
            isLoading: true,
            loadingChat: false,
            sendingMessage: false,
        }
    },
    
    computed: merge(stageState, entriesGetters, chatsState, {
        timebarStart() {
            return this.stage.started_at
        },
        timebarFinish() {
            return this.activity === 1 ? 
                moment(this.stage.started_at).add(2, 'hours').format('YYYY-MM-DD HH:mm:ss') :
                this.stage.finished_at
        },
        unread() {
            return this.chats.filter(item => item.read_at === null && item.committee === 0).length
        },
    }),
    
    created() {
        this.getCurrentStage().then(() => this.isLoading = false)
    },

    mounted() {
        this.activity = document.head.querySelector('meta[name="channel"]').content
        this.getAllEntries()
    },

    methods: merge(stageActions, entriesMutations, entriesActions, chatsActions, {
        getAllEntries() {
            this.getEntries(this.activity).then(() => {
                console.log(this.entrants)
                setTimeout(this.getAllEntries, 5000)
            })
        },
        selectEntrant(entrant) {
            this.loadingChat = true
            this.selected = entrant
            this.sendable.entry = this.selected.id
            this.sendable.committee = 1

            this.getAllChats(entrant)
        },
        getAllChats(entrant) {
            this.getChats(this.selected.id).then(() => {

                if (this.unread > 0) {
                    this.readChats(this.selected.id).then(() => this.readChatOfEntry({ entry: this.selected.id }))
                }

                this.loadingChat = false
                setTimeout(() => this.scrollToBottom(this.$refs.chatBody), 100)

                if (this.selected.id === entrant.id) {
                    setTimeout(() => this.getAllChats(entrant), 10000)
                }
            })  
        },
        sendChatMessage() {
            this.sendingMessage = true

            this.sendChat(this.sendable).then(() => {
                this.sendingMessage = false
                this.sendable.message = ''
                this.scrollToBottom(this.$refs.chatBody)
            })
        },
        scrollToBottom(scrollable) {
            scrollable.scrollTop = scrollable.scrollHeight 
        },
    }),

    components: { 
        'timebar': Timebar,
    }

}).$mount('#app-elimination')
