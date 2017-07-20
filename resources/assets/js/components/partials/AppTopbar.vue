
<style lang="scss" scoped>
    
    #app-topbar {

        .user-signature {
            height: 20px;
            margin: 0 5px;
        }

    }
    
</style>

<template>
    <div id="app-topbar">
        <nav ref="navbar" class="navbar navbar-default navbar-fixed-top">
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
                    <router-link class="navbar-brand" :to="{ name: 'root' }">
                        <slot name="brand"></slot>
                    </router-link>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">

                        <!-- Main Links -->
                        <slot name="left-side"></slot>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        
                        <!-- Secondary Links -->
                        <slot name="right-side"></slot>

                        <nav-alert-list v-if="user.entrant">
                        </nav-alert-list>

                        <dropdown type="nav" :caret="false" align="right">
                            
                            <i class="fa fa-lg fa-cog"></i>
                            <span class="visible-xs-inline">Pengaruran</span>

                            <template slot="menu">

                                <!-- Dropdown Links -->
                                <slot name="dropdown-side"></slot>

                                <router-link tag="li" :to="{ name: 'logout' }">
                                    <a>Logout</a>
                                </router-link>
                            </template>
                        </dropdown>

                    </ul>
                </div>
            </div>
        </nav>
    </div>
</template>

<script>
    import _ from 'lodash';
    import { mapState, mapMutations } from 'vuex';
    import NavAlertList from './NavAlertList.vue';
    import Dropdown from '../kits/Dropdown.vue';
    import Citeup from '../../citeup';

    export default {
    
        computed: _.merge(mapState([

            'user'

        ]), {

            userSignature() {
                return this.user.profile ? 
                    Citeup.appPath + '/' + this.user.profile.photo :
                    Citeup.defaultImage 
            }

        }),

        mounted() {
            this.prepareComponent()
        },

        methods: _.merge(mapMutations([

            'setTopbarHeight'

        ]), {

            prepareComponent() {

                let navbar = this.$refs.navbar;
                let navbarHeader = this.$refs.navbarHeader;
                
                this.setTopbarHeight(navbar.offsetHeight);

                navbarHeader.style.marginTop = ((navbar.clientHeight - navbarHeader.offsetHeight) / 2) + 'px';

            }

        }),

        components: {
            'nav-alert-list': NavAlertList,
            'dropdown': Dropdown
        }

    }
</script>
