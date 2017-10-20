
import Citeup from '../../citeup'

export default {
    namespaced: true,
    
    state: {
        data: [],
    },

    getters: {
        //
    },

    mutations: {
        'CHATS_SET_DATA' (state, { chats }) {
            state.data = chats
        },
        'CHATS_PUSH_DATA' (state, { chat }) {
            state.data.push(chat)
        },
        'CHATS_READ_ALL_DATA' (state, { time }) {
            state.data.forEach(item => item.read_at = time)
        }
    },

    actions: {
        getChats({ state, commit }, entry) {
            return new Promise((resolve, reject) => {
                let params = { entry, take: 50, order: 'created_at:desc' }

                Citeup.get('/chats', params).then(response => {
                    commit('CHATS_SET_DATA', { chats: response.data.data.chats })
                    resolve(state.data)
                })  
            })
        },
        sendChat({ commit }, chat) {
            return new Promise((resolve, reject) => {
                Citeup.post('/chats', chat).then(response => {
                    commit('CHATS_PUSH_DATA', { chat: response.data.data.chat })
                    resolve(response.data.data.chat)
                })  
            })
        },
        readChats({ commit }, entry) {
            return new Promise((resolve, reject) => {
                Citeup.post('/chats/read', { entry }).then(response => {
                    commit('CHATS_READ_ALL_DATA', { time: response.data.data.read_at })
                    resolve()
                })  
            })
        },
    },
}
