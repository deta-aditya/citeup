
<template>
    <question-select v-if="working"></question-select>
    <finished-view v-else-if="finished"></finished-view>
</template>

<script>

    import _ from 'lodash'
    import { mapGetters } from 'vuex'
    import FinishedView from './logika/FinishedView.vue'
    import QuestionSelect from './logika/QuestionSelect.vue'
    import Timebar from '../../components/timebar/Timebar.vue'

    const GETTERS_STAGE = ['working', 'finished']
    
    export default {
        computed: mapGetters('stage', GETTERS_STAGE),
        components: {
            'timebar': Timebar,
            'finished-view': FinishedView,
            'question-select': QuestionSelect,
        },
    }

</script>