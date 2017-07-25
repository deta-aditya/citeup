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
            role: {},
            alerts: [],
        },

        config: {},

        topbarHeight: 0,

        route: '',

        noNav: [
            'Pelengkapan Profil'
        ],

        requiresUserUpdation: [
            //
        ],

        loading: 100

    },

    getters: {

        routeHasNav(state) {
            return state.noNav.indexOf(state.route) < 0;
        },

        routeWantsUserUpdation(state) {
            return state.requiresUserUpdation.indexOf(state.route) >= 0;
        },

        alerts(state) {
            return state.user.alerts;
        },

        isLoading(state) {
            return state.loading < 100
        },

    },

    mutations: {

        updateUser(state, payload) {

            let user = payload.user;
            
            user.admin = user.rolename === 'Administrator';
            user.committee = user.rolename === 'Committee';
            user.entrant = user.rolename === 'Entrant';

            state.user = user;
            
        },

        updateConfig(state, payload) {
            state.config = payload;
        },

        toggleNavbar(state, payload) {
            state.showTopbar = payload.value;
            state.showSidebar = payload.value;
        },

        updateRoute(state, payload) {
            state.route = payload.name;
        },

        setTopbarHeight(state, payload) {
            state.topbarHeight = payload;
        },

        loadSomething(state, payload) {
            state.loading = payload
        },

    },

    actions: {

        updateUserFromApi(context) {
            Citeup.get('/users/' + context.state.user.id).then((response) => {
                context.commit('updateUser', response.data.data)
            })
        },

        updateConfigFromApi(context) {
            Citeup.get('/config').then(response => {
                context.commit('updateConfig', response.data.data.config)
            })
        },

    }
};
