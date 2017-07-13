
<style lang="scss" scoped>
    
</style>

<template>
    <div>
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">

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

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                Pengguna <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">

                                <!-- Dropdown Links -->
                                <slot name="dropdown-side"></slot>

                                <li>
                                    <router-link :to="{ name: 'logout' }">
                                        Logout
                                    </router-link>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </div>
            </div>
        </nav>
        <spacer :vertical="51"></spacer>
    </div>
</template>

<script>
    import Spacer from '../misc/Spacer.vue';

    export default {
    
        components: {
            'spacer': Spacer
        }

    }
</script>
