
<template>
    <working-view v-if="working"></working-view>
    <finished-view v-else-if="finished"></finished-view>
    <countdown-view v-else></countdown-view>
</template>

<script>

    import { mapGetters } from 'vuex'
    import WorkingView from './logika/WorkingView.vue'
    import FinishedView from './logika/FinishedView.vue'
    import CountdownView from './logika/CountdownView.vue'

    const GETTERS_STAGE = ['working', 'finished']
    
    export default {
        computed: mapGetters('stage', GETTERS_STAGE),
        components: {
            'finished-view': FinishedView,
            'countdown-view': CountdownView,
            'working-view': WorkingView,
        },
    }

</script>