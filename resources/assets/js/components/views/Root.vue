
<template>
    <entrant-dashboard v-if="user.entrant"></entrant-dashboard>
</template>

<script>

    import CurrentUser from '../mixins/CurrentUser'
    import EntrantDashboard from './dashboard/EntrantDashboard.vue'

    export default {
        mixins: [CurrentUser],
        components: {
            'entrant-dashboard': EntrantDashboard,
        },
    }

</script>
