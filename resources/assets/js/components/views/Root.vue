
<template>
    <entrant-dashboard v-if="user.entrant"></entrant-dashboard>
    <committee-dashboard v-else-if="user.committee"></committee-dashboard>
    <admin-dashboard v-else-if="user.admin"></admin-dashboard>
</template>

<script>

    import CurrentUser from '../mixins/CurrentUser'
    import AdminDashboard from './dashboard/AdminDashboard.vue'
    import EntrantDashboard from './dashboard/EntrantDashboard.vue'
    import CommitteeDashboard from './dashboard/CommitteeDashboard.vue'

    export default {
        mixins: [CurrentUser],
        components: {
            'admin-dashboard': AdminDashboard,
            'committee-dashboard': CommitteeDashboard,
            'entrant-dashboard': EntrantDashboard,
        },
    }

</script>
