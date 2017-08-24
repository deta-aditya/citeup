
import _ from 'lodash'
import { mapState, mapMutations } from 'vuex'

export default {
    computed: mapState(['viewScrollMaxed']),
    watch: {
        viewScrollMaxed(newVal) { 

        }
    },
    methods: _.merge(mapMutations(['setViewScrollMaxed']), {
        onScrollMaxChange(newVal) {
            //
        },
    }),
}
