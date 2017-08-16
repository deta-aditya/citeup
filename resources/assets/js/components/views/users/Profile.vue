
<template>
    <entrants-profile v-if="user.entrant"></entrants-profile>
    <committees-profile v-else-if="user.committee"></committees-profile>
</template>

<script>

    import { mapState } from 'vuex'
    import CommitteesProfile from './CommitteesProfile.vue'
    import EntrantsProfile from './EntrantsProfile.vue'

    export default {

        computed: mapState([
            'user',
        ]),

        components: {
            'committees-profile': CommitteesProfile,
            'entrants-profile': EntrantsProfile,
        }

    }

</script>
