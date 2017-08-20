
import Citeup from '../../../citeup'

function findById(id) {
    return new Promise((resolve, reject) => {
        Citeup.get('/activities/' + id).then(response => {
            resolve(response.data.data.activity)
        })
    })
}

export { findById }