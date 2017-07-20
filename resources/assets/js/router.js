/**
 * The app's router.
 * This contains the router object and its configurations.
 */

import VueRouter from 'vue-router';

import Root from './components/views/Root.vue';
import AlertsIndex from './components/views/alerts/AlertsIndex.vue';
import AlertsCreate from './components/views/alerts/AlertsCreate.vue';
import AlertsUpdate from './components/views/alerts/AlertsUpdate.vue';
import Logout from './components/views/Logout.vue';
import ErrorPage from './components/views/Error.vue';
import CompleteProfile from './components/views/profiles/CompleteProfile.vue';

const router = new VueRouter({
    mode: 'history',
    base: '/app/',
    routes: [
        { path: '/', name: 'root', component: Root },
        { path: '/alerts', name: 'alerts', component: AlertsIndex },
        { path: '/alerts/create', name: 'alerts.create', component: AlertsCreate },
        { path: '/alerts/:id/update', name: 'alerts.update', component: AlertsUpdate, props: true },
        { path: '/error/:status', name: 'error', component: ErrorPage, props: true },
        { path: '/finishing', name: 'finishing', component: CompleteProfile },
        { path: '/logout', name: 'logout', component: Logout },
        { path: '*', component: ErrorPage, props: {status: 404}}
    ]
});

export default router;
