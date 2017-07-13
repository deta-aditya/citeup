/**
 * The app's store.
 * This contains the whole application global state.
 */

import Citeup from './citeup';

export default {
    
    state: {

        user: {
            id: 0,
            profile: {},
            entry: {},
            role: {}
        },

        showNavbar: true,

        noNav: [
            'finishing'
        ]

    },

    mutations: {
        
        changeUser(state, payload) {
            state.user = payload;
        },

        toggleNavbar(state, payload) {
            state.showNavbar = payload.value;
        }

    },

    actions: {

        updateLocalUser(context) {
            Citeup.get('/users/' + context.state.user.id).then((response) => {
                context.commit('changeUser', response.data.data.user)
            })
        }

    }
};
