
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Citeup from './citeup';

import Vue from 'vue';
import Vuex from 'vuex';
import VueRouter from 'vue-router';

Vue.use(Vuex);
Vue.use(VueRouter);

/**
 * Components to be available in the root application.
 */
import AppInfo from './components/partials/AppInfo.vue';
import AppNavbar from './components/partials/AppNavbar.vue';
import NavbarLink from './components/links/NavbarLink.vue';

/**
 * Import the store and router here.
 */
import storeData from './store.js';
import router from './router.js';

const store = new Vuex.Store(storeData);

/**
 * Initialize the before each hook.
 */
router.beforeEach((to, from, next) => {

    // A boolean variable to determine the show value.
    let show = store.state.noNav.indexOf(to.name) < 0;

    store.commit({
        type: 'toggleNavbar',
        value: show
    });

    next();
});

/**
 * This application script runs on the dashboard page.
 * It literally controls everything in the dashboard, making it an SPA.
 */
const dashboardViewModel = new Vue({

    store: store,
    
    router: router,

    computed: Vuex.mapState([
        'showNavbar'
    ]),

    components: {

        'app-info': AppInfo,

        'app-navbar': AppNavbar,

        'navbar-link': NavbarLink,
        
    },

    /**
     * Prepare the application.
     */
    mounted() {

        this.storeUserInfo();

    },

    methods: _.merge({

        /**
         * Store the user information from server.
         */
        storeUserInfo() {
            
            this.changeUser(this.$refs.info.user);

        },

    }, Vuex.mapMutations([
        'changeUser'
    ]))

}).$mount('#app-dashboard');
