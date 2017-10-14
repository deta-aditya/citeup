
import moment from 'moment'
import Citeup from '../../citeup'

export default {
    namespaced: true,
    state: {
        attempt: {},
        answers: [],
    },
    getters: {
        hasAnsweredChoice: (state) => (id) => {
            return state.answers.findIndex(item => item.id === id) >= 0
        },
        hasAnsweredQuestion: (state) => (id) => {
            return state.answers.findIndex(item => item.question_id === id) >= 0
        },
        answerOfQuestion: (state) => (id) => {
            return state.answers.find(item => item.question_id === id)
        },
        unpersistedChoices(state) {
            return state.answers.filter(item => item.persisted === false).map(item => item.id)
        },
    },
    mutations: {
        'ANSWERS_SET_ATTEMPT' (state, context) {
            state.attempt = context.attempt
        },
        'ANSWERS_SET_ANSWER' (state, context) {
            state.answers = context.answers.map(item => {
                let newItem = item
                
                newItem.persisted = true

                return newItem
            })
        },
        'ANSWERS_ADD_ANSWER' (state, context) {
            let choice = context.choice

            choice.persisted = false

            state.answers.push(choice)
        },
        'ANSWERS_REMOVE_ANSWER' (state, context) {
            let removed = state.answers.splice(state.answers.findIndex(
                item => item.id === context.choice.id
            ), 1)
        }
    },
    actions: {
        loadOrStartAttempt({ dispatch, commit }, entry) {
            return new Promise((resolve, reject) => {
                Citeup.get('/attempts', { entry, with: 'answers' }).then(response => {
                    if (response.data.data.attempts.length > 0) {
                        commit('ANSWERS_SET_ATTEMPT', { attempt: response.data.data.attempts[0] })
                        dispatch('loadChoices', response.data.data.attempts[0].answers.map(item => item.choice_id))
                        return resolve(response.data.data.attempts[0])
                    }

                    Citeup.post('/attempts', { 
                        entry, 
                        started_at: moment().format('YYYY-MM-DD HH:mm:ss') 
                    }).then(response => {
                        commit('ANSWERS_SET_ATTEMPT', { attempt: response.data.data.attempt })
                        return resolve(response.data.data.attempt)
                    })
                })
            })
        },
        loadChoices({ commit }, choiceIds) {
            Citeup.get('/choices', { criteria: 'id:in:' + choiceIds.join(';') }).then(response => {
                commit('ANSWERS_SET_ANSWER', { answers: response.data.data.choices })
            })
        },
        answer({ getters, commit }, choice) {
            let previous = getters.answerOfQuestion(choice.question_id)

            if (previous !== undefined) {
                commit('ANSWERS_REMOVE_ANSWER', { choice: previous })
            }

            commit('ANSWERS_ADD_ANSWER', { choice })
        },
        persistAnswers({ state, getters, commit }) {

            let answers = getters.unpersistedChoices

            if (answers.length === 0) {
                return
            }

            Citeup.post('/attempts/' + state.attempt.id + '/answers', { answers }).then(response => {
                commit('ANSWERS_SET_ANSWER', { answers: state.answers })
            })
        },
    },
}
