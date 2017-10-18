
import Citeup from '../../citeup'

export default {
    namespaced: true,
    state: {
        data: { id: 0, entry: {} },
    }, 
    getters: {
        //
    },
    mutations: {
        ['USER_SET_DATA'] (state, context) {
            state.data = context.user
        },
    },
    actions: {
        loadCurrentUser({ state, commit }) {
            return new Promise((resolve, reject) => {
                Citeup.get('/users/current').then(response => {
                    commit('USER_SET_DATA', { user: response.data.data.user })
                    resolve(state.data)
                })  
            })
        }
    },
}
