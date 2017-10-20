
import Citeup from '../../citeup'

export default {
    namespaced: true,
    
    state: {
        entries: [],
    },

    getters: {
        list(state) {
            let list = state.entries.map(item => {
                let newItem = item
                let elimObject = item.activity_id === 1 ? 'attempt' : 'submission'

                if (item[elimObject + 's']) {
                    newItem[elimObject] = null

                    if (item[elimObject + 's'].length > 0) {
                        newItem[elimObject] = item[elimObject + 's'][0]
                    }
                }

                newItem.chat = item.chats.filter(item => {
                    return item.read_at === null && item.committee === 0
                }).length

                return newItem
            })

            list.sort((a, b) => {
                return b.chat - a.chat
            })

            return list
        }
    },

    mutations: {
        'ENTRIES_SET_DATA' (state, { entries }) {
            state.entries = entries
        },
        'ENTRIES_READ_CHAT' (state, { entry }) {
            let idx = state.entries.findIndex(item => entry === item.id)

            state.entries[idx].chats = []
        }
    },

    actions: {
        getEntries({ state, commit }, activity) {
            return new Promise((resolve, reject) => {
                let params = { activity, with: 'chats', eliminatable: true, take: 999 }

                if (activity == 1) {
                    params.with += ',attempts.answers'
                } else if (activity == 2) {
                    params.with += ',submissions'
                }

                Citeup.get('/entries', params).then(response => {
                    commit('ENTRIES_SET_DATA', { entries: response.data.data.entries })
                    resolve()
                })  
            })
        },
    },
}
