
import Citeup from '../../../citeup'

export default {

    data() {
        return {
            confirmation: {
                box: null,
                disqualify: false,
                entry: { users: [], activity: {} },
            },
        }
    },
    
    methods: {
        referConfirmationBox(ref) {
            this.confirmation.box = ref
        },
        preConfirm(entry, disqualify) {
            this.confirmation.entry = entry
            this.confirmation.disqualify = disqualify
            this.confirmation.box.open()
        },
        cancelConfirm() {
            this.confirmation.box.close()
        },
        confirm(callback) {
            if (this.confirmation.disqualify) {
                this.disqualify(this.confirmation.entry.id, response => { this.confirmation.box.close(); callback() })
            } else {
                this.qualify(this.confirmation.entry.id, response => { this.confirmation.box.close(); callback() })
            }
        },
        disqualify(id, callback) {
            return Citeup.post('/entrants/' + id + '/disqualify', ).then(
                response => callback(response)
            )
        },
        qualify(id, callback) {
            return Citeup.post('/entrants/' + id + '/qualify', ).then(
                response => callback(response)
            )
        },
    },

}
