
import Citeup from '../../citeup'

export default {
    namespaced: true,
    state: {
        data: { id: 0 },
    }, 
    getters: {
        hasSubmitted() {
            return this.data.id !== 0
        }
    },
    mutations: {
        'SUBMISSIONS_SET_DATA' (state, context) {
            state.data = context.submission
        },
    },
    actions: {
        loadOrCreateSubmission({ state, commit }, entry) {
            return new Promise((resolve, reject) => {
                Citeup.get('/submissions', { entry }).then(response => {
                    if (response.data.data.submissions.length > 0) {
                        commit('SUBMISSIONS_SET_DATA', { submission: response.data.data.submissions[0] })
                        return resolve(response.data.data.submissions[0])
                    }

                    Citeup.post('/submissions', { entry }).then(response => {
                        commit('SUBMISSIONS_SET_DATA', { submission: response.data.data.submission })
                        return resolve(response.data.data.submission)
                    })
                    
                })  
            })
        },
        persist({ state, commit }) {
            Citeup.put('/submissions/' + state.data.id, state.data).then(response => {
                commit('SUBMISSIONS_SET_DATA', { submission: response.data.data.submission })
            })
        }
    },
}
