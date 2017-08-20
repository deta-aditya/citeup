
import _ from 'lodash'
import { mapState, mapGetters } from 'vuex'

export default {
    props: {
        name: {
            type: String,
            required: true
        },
    },

    data() {
        return {
            localError: {
                status: 0,
                message: ''
            },
        }
    },

    computed: _.merge(mapState([ 'error' ]), mapGetters([ 'getErrorMessagesOf' ]), {
        hasError() {
            return this.localError.status !== 0
        }
    }),

    watch: {
        error(newVal) {
            if (newVal.status === 422) {
                this.showLocalError(newVal)
            } else {
                this.clearLocalError()
            }
        }
    },

    methods: {
        showLocalError(error) {
            let messages = this.getErrorMessagesOf(this.name)

            if (messages.length === 0) {
                return
            }

            this.localError.status = error.status
            this.localError.message = messages[0]
        },
        clearLocalError() {
            this.localError = { status: 0, message: '' }
        }
    },
}