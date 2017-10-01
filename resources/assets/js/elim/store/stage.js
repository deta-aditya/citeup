
import moment from 'moment'
import Citeup from '../../citeup'

export default {
    namespaced: true,
    state: {
        status: 0,
        timebarFinish: moment(),
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
        'STAGE_SET_TIMEBAR_FINISH' (state, context) {
            state.timebarFinish = moment(context.at)
        },
        'STAGE_SET_STATUS' (state, context) {
            state.status = context.status
        },
        'STAGE_STATUS_FINISH' (state) {
            state.status = 2
        },
    },
    actions: {
        persistFinish({ dispatch }, attemptId) {
            return new Promise((resolve, reject) => {
                Citeup.put('/attempts/' + attemptId, { 
                    finished_at: moment().format('YYYY-MM-DD HH:mm:ss')
                 }).then(response => {
                    dispatch('toFinish')
                    resolve(response.data.data.attempt)
                })
            })
        },
        toFinish({ commit }) {
            commit('STAGE_STATUS_FINISH')
        },
        loadCurrentStage({ commit }) {
            return new Promise((resolve, reject) => {
                Citeup.get('/stages/current').then(response => {
                    switch (response.data.data.stage.id) {
                        case 4: commit('STAGE_SET_STATUS', { status: 1 }); break
                        case 5: commit('STAGE_STATUS_FINISH'); break
                    }
                    resolve(response.data.data.stage)
                })
            })
        }
    },
}
