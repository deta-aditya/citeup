
import Citeup from '../../citeup'

export default {
    namespaced: true,
    state: {
        status: 0,
    }, 
    getters: {
        countdown(state) {
            return state.status === 0
        },
        working(state) {
            return state.status === 1
        },
        finished(state) {
            return state.status === 2
        },
    },
    mutations: {
        ['STAGE_SET_STATUS'] (state, context) {
            state.status = context.status
        },
        ['STAGE_STATUS_FINISH'] (state) {
            state.status = 2
        },
    },
    actions: {
        toFinish({ commit }) {
            commit('STAGE_STATUS_FINISH')
        },
        loadCurrentStage({ commit }) {
            return commit('STAGE_SET_STATUS', { status: 1 })
            Citeup.get('/stages/current').then(response => {
                switch (response.data.data.stage.id) {
                    case 4: commit('STAGE_SET_STATUS', { status: 1 }); break
                    case 5: commit('STAGE_STATUS_FINISH'); break
                }
            })
        }
    },
}
