
import { mapState } from 'vuex'
import Citeup from '../../citeup'

export default {

    methods: {

        documentsComplete(users) {
            return this.reduceDocuments(users).filter(item => {
                return item.file === Citeup.defaultImageClean
            }).length === 0
        },

        possibleDocuments(activityId) {
            return activityId === 1 ? 4 : 2
        },

        submittedDocuments(users) {
            return this.reduceDocuments(users).filter(item => {
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
