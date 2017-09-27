
import Citeup from '../../citeup'

export default {
    namespaced: true,
    state: {
        repo: [],
        current: {},
    },
    getters: {
        findByNumber: (state) => (number) => {
            return state.repo.find(item => item.number === number)
        },
        repoIsEmpty(state) {
            return state.repo.length === 0
        },
    },
    mutations: {
        ['QUESTIONS_SET_REPO'] (state, context) {
            state.repo = context.list
        },
        ['QUESTIONS_SET_CURRENT'] (state, context) {
            state.current = context.question
        },
    },
    actions: {
        loadQuestions({ commit }) {
            Citeup.get('/questions', { take: 50, with: 'choices' }).then(response => {
                let list = response.data.data.questions

                for (let [index, item] of list.entries()) {
                    item.number = index + 1
                }

                commit('QUESTIONS_SET_REPO', { list })
            })
        },
        setCurrent({ commit, getters, dispatch }, number) {
            commit('QUESTIONS_SET_CURRENT', { question: getters.findByNumber(number) })
        },
    },
}
