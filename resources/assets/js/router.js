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
import SchedulesCreate from './components/views/activities/schedules/SchedulesCreate.vue';
import SchedulesUpdate from './components/views/activities/schedules/SchedulesUpdate.vue';
import SponsorsIndex from './components/views/sponsors/SponsorsIndex.vue';
import SponsorsCreate from './components/views/sponsors/SponsorsCreate.vue';
import SponsorsUpdate from './components/views/sponsors/SponsorsUpdate.vue';
import FaqsIndex from './components/views/faqs/FaqsIndex.vue';
import FaqsCreate from './components/views/faqs/FaqsCreate.vue';
import FaqsUpdate from './components/views/faqs/FaqsUpdate.vue';
import NewsIndex from './components/views/news/NewsIndex.vue';
import NewsView from './components/views/news/NewsView.vue';
import NewsCreate from './components/views/news/NewsCreate.vue';
import NewsUpdate from './components/views/news/NewsUpdate.vue';
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
        { path: '/activities/:id/schedules/create', name: 'Acara.Lihat.Buat Jadwal', component: SchedulesCreate, props: true },
        { path: '/activities/:id/schedules/:schedule/update', name: 'Acara.Lihat.Sunting Jadwal', component: SchedulesUpdate, props: true },
        { path: '/activities/:id/update', name: 'Acara.Sunting', component: ActivitiesUpdate, props: true },
        { path: '/activities/create', name: 'Acara.Buat', component: ActivitiesCreate },
        { path: '/sponsors', name: 'Sponsor', component: SponsorsIndex },
        { path: '/sponsors/create', name: 'Sponsor.Buat', component: SponsorsCreate },
        { path: '/sponsors/:id/update', name: 'Sponsor.Sunting', component: SponsorsUpdate, props: true },
        { path: '/faqs', name: 'FAQ', component: FaqsIndex },
        { path: '/faqs/create', name: 'FAQ.Buat', component: FaqsCreate },
        { path: '/faqs/:id/update', name: 'FAQ.Sunting', component: FaqsUpdate, props: true },
        { path: '/news', name: 'Berita', component: NewsIndex },
        { path: '/news/:id', name: 'Berita.Lihat', component: NewsView, props: true },
        { path: '/news/:id/update', name: 'Berita.Sunting', component: NewsUpdate, props: true },
        { path: '/news/create', name: 'Berita.Buat', component: NewsCreate },
        { path: '/error/:status', name: 'Error', component: ErrorPage, props: true },
        { path: '/finishing', name: 'Pelengkapan Profil', component: CompleteProfile },
        { path: '/logout', name: 'Logout', component: Logout },
        { path: '*', name: 'error', component: ErrorPage, props: {status: 404}}
    ]
});

export default router;
