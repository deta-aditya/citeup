
<style lang="scss" scoped>
    
    .activity-icon {
        height: 150px;
        margin: 0 30px 30px 0;
    }

    .news-icon {
        padding-right: 10px;
        height: 75px;
    }

</style>

<template>
    <div class="admin-dashboard">

        <!-- Panel header -->
        <div class="form-panel">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="pull-right">
                        <router-link :to="{ name: 'Profil' }">Profil</router-link> &middot;
                        <router-link :to="{ name: 'Logout' }">Logout</router-link>
                    </div>
                    <h1 class="page-title">Selamat Datang {{ user.name }}!</h1>
                </div>
            </div>
        </div>

        <div class="form-panel">
            <div class="row panel-nav">
                <div v-for="nav in navs" :class="navClass">
                    <router-link :to="{ name: nav.name }">
                        <div class="panel panel-default panel-nav-item">
                            <div class="panel-body">
                                <i :class="['fa', 'fa-' + nav.icon, 'panel-nav-icon']"></i>
                                <div class="panel-nav-title">{{ nav.name }}</div>
                            </div>
                        </div>
                    </router-link>
                </div>
            </div>
        </div>

    </div>    
</template>

<script>

    import moment from 'moment'
    import KeyMapper from '../../keys/KeyMapper'
    import CurrentUser from '../../mixins/CurrentUser'

    export default {

        mixins: [CurrentUser, KeyMapper],

        data() {
            return {
                navs: [],
            }
        },

        computed: {
            navClass() {
                if (this.navs.length <= 3) {
                    return 'col-sm-4'
                } else if (this.navs.length === 4) {
                    return 'col-sm-3'
                } else if (this.navs.length <= 6) {
                    return 'col-sm-4'
                } else if (this.navs.length <= 8) {
                    return 'col-sm-3'
                } else if (this.navs.length === 9) {
                    return 'col-sm-4'
                } else {
                    return 'col-sm-3'
                }
            },
        },
        
        created() {
            this.navs = this.getNavs(this.user.keys)
        },
    }

</script>
