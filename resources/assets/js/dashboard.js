
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue';
import Vuex from 'vuex';

/**
 * Components to be available in the root application.
 */
import AppInfo from './components/partials/AppInfo.vue';
import AppTopbar from './components/partials/AppTopbar.vue';
import AppSidebar from './components/partials/AppSidebar.vue';
import NavLink from './components/links/NavLink.vue';
import Spacer from './components/misc/Spacer.vue';

/**
 * Import the store and router here.
 */
import store from './store.js'
import router from './router.js';

/**
 * Initialize the before each hook.
 */
router.beforeEach((to, from, next) => {

    store.commit({
        type: 'updateRoute',
        name: to.name
    })

    next();
});

/**
 * This application script runs on the dashboard page.
 * It literally controls everything in the dashboard, making it an SPA.
 */
const dashboardViewModel = new Vue({

    store: store,
    
    router: router,

    computed: _.merge(Vuex.mapState([
        
        'topbarHeight'

    ]), Vuex.mapGetters({

        hasNav: 'routeHasNav',
        userUpdatable: 'routeWantsUserUpdation',

    })),

    watch: {

        userUpdatable(yes) {
            
            if (yes) {
                this.updateUserFromApi();
            }
            
        }
    },

    components: {

        'app-info': AppInfo,

        'app-topbar': AppTopbar,

        'app-sidebar': AppSidebar,
            
        'spacer': Spacer,
        
    },

    created() {
        this.updateConfigFromApi()
        this.loadStages()
        this.updateRoute(this.$route)
    },

    /**
     * Prepare the application.
     */
    mounted() {

        this.storeUserInfo();

    },

    methods: _.merge(Vuex.mapMutations([

        'updateUser',
        'updateRoute',
        'setViewScrollMaxed',

    ]), Vuex.mapActions([

        'updateUserFromApi',
        'updateConfigFromApi',
        'loadStages',

    ]), {

        /**
         * Store the user information from server.
         */
        storeUserInfo() {
            
            this.updateUser(this.$refs.info);

        },

        detectMaxScrollHeight(view) {
            if (view.scrollHeight - window.innerHeight === view.scrollTop - 38) {
                this.setViewScrollMaxed(true)
            }
        },

    })

}).$mount('#app-dashboard');
