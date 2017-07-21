
<style lang="scss" scoped>

    $sidebar-width: 250px;
    $border-info: 1px #d3e0e9 solid;    
    
    #app-sidebar {
        width: $sidebar-width;
        border-right: $border-info;
        background: #fff;
        position: relative;

        .sidebar-container {
            padding-top: 10px;
        }

        .sidebar-profile {
            text-align: center;
            padding: 10px;
            margin-bottom: 7px;

            img {
                width: 75px;
            }

            p {
                margin: 0;
            }

            .profile-name {
                margin-top: 10px;
                font-weight: 600;
            }

            .profile-email {
                margin-top: 4px;
                font-size: 11.5px;
            }

        }

        .sidebar-title {
            margin: 0;
            font-weight: 600;
            font-size: 12px;
            color: #aaa;
            padding: 10px 20px;
            text-transform: uppercase;
        }

        .sidebar-nav-item {
            padding: 10px 20px;
            margin-bottom: 0;
            border-radius: 0;
            border: none;

            &:hover {
                background: inherit;
                color: #3097D1;
            }

            &.active {
                background: #f5f5f5;
                color: inherit;
                font-weight: 600;
            }

            & > .fa {
                margin-right: 7px;
            }

        }
    }

</style>

<template>
    <div ref="sidebar" id="app-sidebar" class="hidden-xs hidden-sm">
        <div class="sidebar-container">

            <div class="sidebar-profile">
                <img :src="userSignature" class="img-circle">
                <p class="profile-name">{{ user.name }}</p>
                <p class="profile-email">{{ userPrivilege }}</p>
            </div>

            <p class="sidebar-title">Navigasi</p>
            <div class="list-group sidebar-nav">
                <router-link :class="{'list-group-item': true, 'sidebar-nav-item': true, 'active': this.route === 'root' }" :to="{ name: 'root' }">
                    <i class="fa fa-fw fa-tachometer"></i>
                    Dasbor
                </router-link>
                <router-link :class="{'list-group-item': true, 'sidebar-nav-item': true, 'active': this.route.indexOf('alerts') >= 0 }" :to="{ name: 'alerts' }">
                    <i class="fa fa-fw fa-bell"></i>
                    Notifikasi
                </router-link>
                <router-link v-if="user.admin" :class="{'list-group-item': true, 'sidebar-nav-item': true, 'active': this.route.indexOf('config') >= 0 }" :to="{ name: 'config' }">
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
                this.$refs.sidebar.style.minHeight = 'calc(100vh - '+ this.topbarHeight +'px)'
            },

        },

    }
    
</script>
