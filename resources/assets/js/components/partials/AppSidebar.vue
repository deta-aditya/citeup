
<template>
    <div ref="sidebar" id="app-sidebar" class="hidden-xs hidden-sm">
        <spacer :vertical="topbarHeight"></spacer>
        <div class="sidebar-container">

            <div class="sidebar-profile text-center">
                <img :src="userSignature" class="img-circle user-signature">
                <p class="profile-name">{{ user.name }}</p>
                <p class="profile-privilege">{{ userPrivilege }}</p>
            </div>

            <p class="sidebar-title">Navigasi</p>
            <div class="list-group sidebar-nav">
                <router-link :class="{'list-group-item': true, 'sidebar-nav-item': true, 'active': this.route === 'Dasbor' }" :to="{ name: 'Dasbor' }">
                    <i class="fa fa-fw fa-tachometer"></i>
                    Dasbor
                </router-link>
                <template v-if="user.admin">
                    <router-link :class="{'list-group-item': true, 'sidebar-nav-item': true, 'active': route.indexOf('Panitia') >= 0 }" :to="{ name: 'Panitia' }">
                        <i class="fa fa-fw fa-user-secret"></i>
                        Panitia
                    </router-link>
                    <router-link :class="{'list-group-item': true, 'sidebar-nav-item': true, 'active': route.indexOf('Acara') >= 0 }" :to="{ name: 'Acara' }">
                        <i class="fa fa-fw fa-bullhorn"></i>
                        Acara
                    </router-link>
                    <router-link :class="{'list-group-item': true, 'sidebar-nav-item': true, 'active': route.indexOf('FAQ') >= 0 }" :to="{ name: 'FAQ' }">
                        <i class="fa fa-fw fa-question-circle"></i>
                        FAQ
                    </router-link>
                    <router-link :class="{'list-group-item': true, 'sidebar-nav-item': true, 'active': route.indexOf('Berita') >= 0 }" :to="{ name: 'Berita' }">
                        <i class="fa fa-fw fa-file-text"></i>
                        Berita
                    </router-link>
                    <router-link :class="{'list-group-item': true, 'sidebar-nav-item': true, 'active': route.indexOf('Sponsor') >= 0 }" :to="{ name: 'Sponsor' }">
                        <i class="fa fa-fw fa-handshake-o"></i>
                        Sponsor
                    </router-link>
                    <router-link :class="{'list-group-item': true, 'sidebar-nav-item': true, 'active': route.indexOf('Contact Person') >= 0 }" :to="{ name: 'Contact Person' }">
                        <i class="fa fa-fw fa-phone"></i>
                        Contact Person
                    </router-link>
                    <router-link :class="{'list-group-item': true, 'sidebar-nav-item': true, 'active': route.indexOf('Konten') >= 0 }" :to="{ name: 'Konten' }">
                        <i class="fa fa-fw fa-archive"></i>
                        Konten
                    </router-link>
                    <router-link :class="{'list-group-item': true, 'sidebar-nav-item': true, 'active': route.indexOf('Konfigurasi') >= 0 }" :to="{ name: 'Konfigurasi' }">
                        <i class="fa fa-fw fa-cogs"></i>
                        Konfigurasi
                    </router-link>
                </template>
                <template v-else-if="user.committee">
                    <router-link 
                        v-for="(nav, index) in navs" 
                        :key="index" 
                        :class="{'list-group-item': true, 'sidebar-nav-item': true, 'active': route.indexOf(nav.name) >= 0 }" 
                        :to="{ name: nav.name }">
                        <i :class="['fa', 'fa-fw', 'fa-' + nav.icon]"></i>
                        {{ nav.name }}
                    </router-link>
                </template>
            </div>
        </div>
    </div>
</template>

<script>

    import _ from 'lodash'
    import { mapState } from 'vuex'
    import Citeup from '../../citeup'
    import Spacer from '../misc/Spacer.vue'
    import KeyMapper from '../keys/KeyMapper'

    const STATES = [
        'user',
        'route',
        'topbarHeight',
    ]

    export default {

        mixins: [KeyMapper],
    
        computed: _.merge(mapState(STATES), {

            userSignature() {
                return this.user.photo ? 
                    Citeup.appPath + '/' + this.user.photo :
                    Citeup.defaultImage 
            },

            userPrivilege() {
                switch (this.user.rolename) {
                    case 'Committee':
                        return 'Panitia' + this.userSection
                    case 'Entrant':
                        return 'Peserta' + this.userActivity
                    default:
                        return this.user.rolename
                }
            },

            userSection() {
                return this.user.section && this.user.committee ?
                    ', ' + this.user.section : ''
            },

            userActivity() {
                return ' ' + this.user.entry.activity.name
            },

            navs() {
                return this.user.committee ? this.getNavs(this.user.keys) : []
            },

        }),

        mounted() {
            this.prepareComponent()
        },

        methods: {

            prepareComponent() {
                //
            },

        },

        components: {
            'spacer': Spacer,
        },

    }
    
</script>
