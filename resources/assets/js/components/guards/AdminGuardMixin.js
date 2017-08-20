
import Citeup from '../../citeup'
import { mapState } from 'vuex'

export default {
    computed: mapState([
        'user',
    ]),
    beforeRouteEnter (to, from, next) {
        next(vm => {
            if (vm.user.admin) {
                return true
            }
                
            vm.$router.push({name: 'Error', params: { status: 403 }})
        })
    },
}
