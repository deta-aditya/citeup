/**
 * The app's router.
 * This contains the router object and its configurations.
 */

import VueRouter from 'vue-router';

import Root from './components/views/Root.vue';
import Config from './components/views/Config.vue';
import AlertsIndex from './components/views/alerts/AlertsIndex.vue';
import AlertsCreate from './components/views/alerts/AlertsCreate.vue';
import AlertsUpdate from './components/views/alerts/AlertsUpdate.vue';
import ActivitiesIndex from './components/views/activities/ActivitiesIndex.vue';
import ActivitiesView from './components/views/activities/ActivitiesView.vue';
import ActivitiesCreate from './components/views/activities/ActivitiesCreate.vue';
import ActivitiesUpdate from './components/views/activities/ActivitiesUpdate.vue';
import Logout from './components/views/Logout.vue';
import ErrorPage from './components/views/Error.vue';
import CompleteProfile from './components/views/profiles/CompleteProfile.vue';

const router = new VueRouter({
    mode: 'history',
    base: '/app/',
    routes: [
        { path: '/', name: 'Dasbor', component: Root },
        { path: '/config', name: 'Konfigurasi', component: Config },
        { path: '/alerts', name: 'Notifikasi', component: AlertsIndex },
        { path: '/alerts/create', name: 'Notifikasi.Buat', component: AlertsCreate },
        { path: '/alerts/:id/update', name: 'Notifikasi.Sunting', component: AlertsUpdate, props: true },
        { path: '/activities', name: 'Acara', component: ActivitiesIndex },
        { path: '/activities/:id', name: 'Acara.Lihat', component: ActivitiesView, props: true },
        { path: '/activities/create', name: 'Acara.Buat', component: ActivitiesCreate },
        { path: '/activities/:id/update', name: 'Acara.Sunting', component: ActivitiesUpdate, props: true },
        { path: '/error/:status', name: 'Error', component: ErrorPage, props: true },
        { path: '/finishing', name: 'Pelengkapan Profil', component: CompleteProfile },
        { path: '/logout', name: 'Logout', component: Logout },
        { path: '*', component: ErrorPage, props: {status: 404}}
    ]
});

export default router;
