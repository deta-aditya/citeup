
import Citeup from '../../citeup'

export default {
    namespaced: true,
    
    state: {
        data: { started_at: null, finished_at: null },
    },
    
    mutations: {
        'STAGE_SET_DATA' (state, { stage }) {
            state.data = stage
        },
    },

    actions: {
        getCurrentStage({ state, commit }) {
            return new Promise((resolve, reject) => {
                Citeup.get('/stages/current').then(response => {
                    commit('STAGE_SET_DATA', { stage: response.data.data.stage })
                    resolve(state.data)
                })
            })
        }
    },
}
