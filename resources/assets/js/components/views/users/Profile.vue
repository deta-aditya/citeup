
<template>
    <committees-profile v-if="user.committee"></committees-profile>
</template>

<script>

    import { mapState } from 'vuex'
    import CommitteesProfile from './CommitteesProfile.vue'

    export default {

        computed: mapState([
            'user',
        ]),

        components: {
            'committees-profile': CommitteesProfile,
        }

    }

</script>
