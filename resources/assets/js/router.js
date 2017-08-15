/**
 * The app's router.
 * This contains the router object and its configurations.
 */

import VueRouter from 'vue-router';

import Root from './components/views/Root.vue';
import Config from './components/views/Config.vue';
import Profile from './components/views/users/Profile.vue';
import CommitteesIndex from './components/views/users/CommitteesIndex.vue';
import CommitteesCreate from './components/views/users/CommitteesCreate.vue';
import CommitteesUpdate from './components/views/users/CommitteesUpdate.vue';
import CommitteesView from './components/views/users/CommitteesView.vue';
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
import ContactPeopleIndex from './components/views/contact_people/ContactPeopleIndex.vue';
import ContactPeopleCreate from './components/views/contact_people/ContactPeopleCreate.vue';
import ContactPeopleUpdate from './components/views/contact_people/ContactPeopleUpdate.vue';
import HtmlContentsIndex from './components/views/html_contents/HtmlContentsIndex.vue';
import HtmlContentsView from './components/views/html_contents/HtmlContentsView.vue';
import HtmlContentsCreate from './components/views/html_contents/HtmlContentsCreate.vue';
import HtmlContentsUpdate from './components/views/html_contents/HtmlContentsUpdate.vue';
import Logout from './components/views/Logout.vue';
import ErrorPage from './components/views/Error.vue';
import CompleteProfile from './components/views/profiles/CompleteProfile.vue';

const router = new VueRouter({
    mode: 'history',
    base: '/panel/',
    routes: [
        { path: '/', name: 'Dasbor', component: Root },
        { path: '/settings', name: 'Konfigurasi', component: Config },
        { path: '/profile', name: 'Profil', component: Profile },
        { path: '/committees', name: 'Panitia', component: CommitteesIndex },
        { path: '/committees/:id', name: 'Panitia.Lihat', component: CommitteesView, props: true },
        { path: '/committees/:id/update', name: 'Panitia.Sunting', component: CommitteesUpdate, props: true },
        { path: '/committees/create', name: 'Panitia.Buat', component: CommitteesCreate },
        { path: '/activities', name: 'Acara', component: ActivitiesIndex },
        { path: '/activities/:id', name: 'Acara.Lihat', component: ActivitiesView, props: true },
        { path: '/activities/:id/schedules/create', name: 'Acara.Lihat.Buat Jadwal', component: SchedulesCreate, props: true },
        { path: '/activities/:id/schedules/:schedule/update', name: 'Acara.Lihat.Sunting Jadwal', component: SchedulesUpdate, props: true },
        { path: '/activities/:id/update', name: 'Acara.Sunting', component: ActivitiesUpdate, props: true },
        { path: '/activities/create', name: 'Acara.Buat', component: ActivitiesCreate },
        { path: '/faqs', name: 'FAQ', component: FaqsIndex },
        { path: '/faqs/create', name: 'FAQ.Buat', component: FaqsCreate },
        { path: '/faqs/:id/update', name: 'FAQ.Sunting', component: FaqsUpdate, props: true },
        { path: '/news', name: 'Berita', component: NewsIndex },
        { path: '/news/:id', name: 'Berita.Lihat', component: NewsView, props: true },
        { path: '/news/:id/update', name: 'Berita.Sunting', component: NewsUpdate, props: true },
        { path: '/news/create', name: 'Berita.Buat', component: NewsCreate },
        { path: '/sponsors', name: 'Sponsor', component: SponsorsIndex },
        { path: '/sponsors/create', name: 'Sponsor.Buat', component: SponsorsCreate },
        { path: '/sponsors/:id/update', name: 'Sponsor.Sunting', component: SponsorsUpdate, props: true },
        { path: '/contact-people', name: 'Contact Person', component: ContactPeopleIndex },
        { path: '/contact-people/:id/update', name: 'Contact Person.Sunting', component: ContactPeopleUpdate, props: true },
        { path: '/contact-people/create', name: 'Contact Person.Buat', component: ContactPeopleCreate },
        { path: '/html-contents', name: 'Konten', component: HtmlContentsIndex },
        { path: '/html-contents/:id', name: 'Konten.Lihat', component: HtmlContentsView, props: true },
        { path: '/html-contents/:id/update', name: 'Konten.Sunting', component: HtmlContentsUpdate, props: true },
        { path: '/html-contents/create', name: 'Konten.Buat', component: HtmlContentsCreate },
        { path: '/error/:status', name: 'Error', component: ErrorPage, props: true },
        { path: '/finishing', name: 'Pelengkapan Profil', component: CompleteProfile },
        { path: '/logout', name: 'Logout', component: Logout },
        { path: '*', component: ErrorPage, props: { status: 404 }}
    ]
});

export default router;
