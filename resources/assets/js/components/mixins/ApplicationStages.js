
import _ from 'lodash'
import { mapState } from 'vuex'

export default {

    STAGE_PRE_REGISTRATION: 1,
    STAGE_REGISTRATION: 2,
    STAGE_PRE_ELIMINATION: 3,
    STAGE_ELIMINATION: 4,
    STAGE_FINAL: 5,
    STAGE_POST_EVENT: 6,

    computed: _.merge(mapState([ 'stages' ]), {
        stageGetter() {
            let obj = { 1: {}, 2: {}, 3: {}, 4: {}, 5: {}, 6: {}}

            for (let stage of this.stages) {
                obj[stage.id] = stage
            }

            return obj
        },
    }),

    methods: {
    },
}
