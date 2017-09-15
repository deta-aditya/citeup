
require('../bootstrap')

import Vue from 'vue'
import store from './store/index'
import router from './router/index'

import Chat from './components/chat/Chat.vue'
import Timebar from './components/timebar/Timebar.vue'
import Countdown from '../components/misc/Countdown.vue'
import MessageBox from '../components/kits/MessageBox.vue'

const vm = new Vue({
    store, 
    router,
    methods: {
        reload() {
            window.location.reload(false)
        },
    },
    components: { 
        'timebar': Timebar,
        'sticky-chat': Chat,
        'countdown': Countdown,
        'message-box': MessageBox,
    }
}).$mount('#app-elimination')
