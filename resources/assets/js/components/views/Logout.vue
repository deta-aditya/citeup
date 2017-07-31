
<template>
    <div>
        Bye bye..
        <form ref="logouter" method="post" :action="logoutRoute">
            <csrf-input></csrf-input>
        </form>
    </div>
</template>

<script>

    import Citeup from '../../citeup';
    import CsrfInput from '../forms/CsrfInput.vue';

    export default {

        /**
         * The component data.
         */        
        data() {
            return {
                logoutRoute: Citeup.appPath + '/logout',
                csrfToken: Citeup.csrf
            };
        },

        /**
         * Prepare the component (Vue 2.x).
         */
        mounted() {
            this.performLogout();
        },

        methods: {
            performLogout() {
                this.$refs.logouter.submit();
            }
        },

        components: {
            'csrf-input': CsrfInput
        }
    }

</script>