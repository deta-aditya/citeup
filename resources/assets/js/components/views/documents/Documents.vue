
<template>
    <entrant-view v-if="user.entrant"></entrant-view>
</template>

<script>

    import { mapState } from 'vuex'
    import DocumentsEntrant from './DocumentsEntrant.vue'

    export default {

        computed: mapState([
            'user',
        ]),

        components: {
            'entrant-view': DocumentsEntrant,
        }

    }

</script>