
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
                <router-link :class="{'list-group-item': true, 'sidebar-nav-item': true, 'active': this.route.indexOf('Notifikasi') >= 0 }" :to="{ name: 'Notifikasi' }">
                    <i class="fa fa-fw fa-bell"></i>
                    Notifikasi
                </router-link>
                <router-link :class="{'list-group-item': true, 'sidebar-nav-item': true, 'active': this.route.indexOf('Acara') >= 0 }" :to="{ name: 'Acara' }">
                    <i class="fa fa-fw fa-bullhorn"></i>
                    Acara
                </router-link>
                <router-link :class="{'list-group-item': true, 'sidebar-nav-item': true, 'active': this.route.indexOf('FAQ') >= 0 }" :to="{ name: 'FAQ' }">
                    <i class="fa fa-fw fa-question-circle"></i>
                    FAQ
                </router-link>
                <router-link :class="{'list-group-item': true, 'sidebar-nav-item': true, 'active': this.route.indexOf('Berita') >= 0 }" :to="{ name: 'Berita' }">
                    <i class="fa fa-fw fa-file-text"></i>
                    Berita
                </router-link>
                <router-link :class="{'list-group-item': true, 'sidebar-nav-item': true, 'active': this.route.indexOf('Sponsor') >= 0 }" :to="{ name: 'Sponsor' }">
                    <i class="fa fa-fw fa-handshake-o"></i>
                    Sponsor
                </router-link>
                <router-link v-if="user.admin" :class="{'list-group-item': true, 'sidebar-nav-item': true, 'active': this.route.indexOf('Konfigurasi') >= 0 }" :to="{ name: 'Konfigurasi' }">
                    <i class="fa fa-fw fa-cogs"></i>
                    Konfigurasi
                </router-link>
            </div>
        </div>
    </div>
</template>

<script>

    import _ from 'lodash'
    import { mapState } from 'vuex'
    import Citeup from '../../citeup'
    import Spacer from '../misc/Spacer.vue'

    const STATES = [
        'user',
        'route',
        'topbarHeight',
    ]

    export default {
    
        computed: _.merge(mapState(STATES), {

            userSignature() {
                return this.user.profile ? 
                    Citeup.appPath + '/' + this.user.profile.photo :
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
                return this.user.profile.section && this.user.committee ?
                    ', ' + this.user.profile.section : ''
            },

            userActivity() {
                return ' ' + this.user.activity[0].name
            }

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
