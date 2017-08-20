
import Citeup from '../../../citeup'

function getRelatedEntrants(entryId) {
    return new Promise((resolve, reject) => {
        let data = { with: 'users.documents,activity' }

        Citeup.get('/entries/' + entryId, data).then(response => {
            resolve(response.data.data.entry.users)
        })
    })
}

function countOf(activityId) {
    return new Promise((resolve, reject) => {
        let data = { activity: activityId }

        Citeup.get('/entries', data).then(response => {
            resolve(response.data.data.entries.length)
        })
    })
}

export { getRelatedEntrants, countOf }