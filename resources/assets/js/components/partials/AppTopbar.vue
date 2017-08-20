
<template>
    <div id="app-topbar">
        <nav ref="navbar" class="navbar navbar-default navbar-fixed-top navbar-inverse">
            <div class="container-fluid">
                <div ref="navbarHeader" class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <router-link class="navbar-brand" :to="{ name: 'Dasbor' }">
                        <slot name="brand"></slot>
                    </router-link>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">

                        <li v-for="(crumb, index) in crumbs">
                            <router-link v-if="index < crumbs.length - 1" :to="{ name: crumb }" class="crumbs">/ {{ crumb | pop }}</router-link>
                            <a class="crumbs" v-else>/ {{ crumb | pop }}</a>
                        </li>

                        <!-- Main Links -->
                        <slot name="left-side"></slot>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        
                        <!-- Secondary Links -->
                        <slot name="right-side"></slot>

                        <li>
                            <a href="/"><i class="fa fa-lg fa-home" title="Halaman Depan"></i></a>
                        </li>

                        <dropdown type="nav" :caret="false" align="right">
                            
                            <i class="fa fa-lg fa-cog" title="Pengaturan"></i>
                            <span class="visible-xs-inline">Pengaruran</span>

                            <template slot="menu">

                                <!-- Dropdown Links -->
                                <slot name="dropdown-side"></slot>

                                <router-link tag="li" :to="{ name: 'Profil' }"><a>Profil</a></router-link>
                                <router-link tag="li" :to="{ name: 'Ubah Kata Sandi' }"><a>Ubah Kata Sandi</a></router-link>
                                <li role="separator" class="divider"></li>
                                <router-link tag="li" :to="{ name: 'Logout' }"><a>Logout</a></router-link>
                            </template>
                        </dropdown>

                    </ul>
                </div>
            </div>
        </nav>
        <div v-show="isLoading" ref="loadingBar" class="progress loading-bar">
            <div ref="loadingBarProgress" class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
                <span class="sr-only">{{ loading }} Complete</span>
            </div>
        </div>
    </div>
</template>

<script>

    import _ from 'lodash';
    import { mapState, mapGetters, mapMutations } from 'vuex';
    import Dropdown from '../kits/Dropdown.vue';
    import Citeup from '../../citeup';

    const STATES = [
        'user', 'loading', 'route', 'topbarHeight'
    ]

    const GETTERS = [
        'isLoading',
    ]

    const MUTATIONS = [
        'setTopbarHeight', 'loadSomething',
    ]

    export default {

        data() {
            return {
                crumbs: [],
            }
        },
    
        computed: _.merge(mapState(STATES), mapGetters(GETTERS)),

        watch: {

            loading(newVal) {
                
                if (this.isLoading) {
                    this.$refs.loadingBarProgress.style.width = this.loading + '%'
                }

            },

            route(newVal) {
                this.makeCrumbs(newVal)
            },

        },

        filters: {

            pop(val) {
                return val.split('.').pop()
            },

        },

        created() {
            this.makeCrumbs(this.route)
        },

        mounted() {
            this.prepareComponent()
        },

        methods: _.merge(mapMutations(MUTATIONS), {

            prepareComponent() {
                
                this.setTopbarHeight(this.$refs.navbar.offsetHeight);
                this.$refs.loadingBar.style.marginTop = this.topbarHeight + 'px'

            },

            makeCrumbs(raw) {
                
                if (raw.length === 0) {
                    return
                }

                if (raw.indexOf('.') >= 0) {
                    
                    let items = raw.split('.')

                    this.crumbs = []

                    for (let i = 0; i < items.length; i++) {
                        
                        let item = [items[i]]

                        for (let j = i - 1; j >= 0; j--) {
                            item.unshift(items[j])
                        }

                        this.crumbs.push(item.join('.'))

                    }

                } else {
                    this.crumbs = [raw]
                }

            },

        }),

        components: {
            'dropdown': Dropdown,
        }

    }

</script>
