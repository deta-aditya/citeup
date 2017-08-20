
<template>
    <entrant-view v-if="user.entrant"></entrant-view>
    <manage-view v-else></manage-view>
</template>

<script>

    import { mapState } from 'vuex'
    import DocumentsEntrant from './DocumentsEntrant.vue'
    import DocumentsIndex from './DocumentsIndex.vue'

    export default {

        computed: mapState([
            'user',
        ]),

        components: {
            'entrant-view': DocumentsEntrant,
            'manage-view': DocumentsIndex,
        }

    }

</script>