
import { mapState } from 'vuex'
import Citeup from '../../citeup'

export default {

    methods: {

        documentsComplete(users) {
            return this.reduceDocuments(users).filter(item => {
                return item.file === Citeup.defaultImageClean
            }).length === 0
        },

        hasPaid(users) {
            return this.reduceDocuments(users).filter(item => {
                return item.type === 1 && item.file !== Citeup.defaultImageClean
            }).length > 0
        },

        possibleDocuments(activityId) {
            return activityId === 1 ? 4 : 2
        },

        submittedDocuments(users) {

            let reduced = this.reduceDocuments(users)

            if (reduced.length === 0) {
                return -1
            }

            return reduced.filter(item => {
                return item.file !== Citeup.defaultImageClean
            }).length
        },

        reduceDocuments(users) {
            return users.map(item => {
                return item.documents
            }).reduce((total, item) => {
                return total.concat(item)
            })
        },

    },
}
