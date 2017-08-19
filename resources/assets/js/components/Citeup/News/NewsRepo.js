
import Citeup from '../../../citeup'

function listInfiniteScroll(skip = 0, take = 15) {
    return new Promise((resolve, reject) => {
        Citeup.get('/news', { skip: skip, take: take, order: 'created_at:desc' }).then(response => {
            resolve(response.data.data.news)
        })
    })
}

export { listInfiniteScroll }