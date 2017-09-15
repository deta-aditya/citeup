
export default {
    namespaced: true,
    state: {
        status: 2,
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
        ['STAGE_STATUS_FINISH'] (state) {
            state.status = 2
        },
    },
    actions: {
        toFinish({ commit }) {
            commit('STAGE_STATUS_FINISH')
        }
    },
}
