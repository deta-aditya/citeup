
import RootView from './views/RootView.vue'
import Answers from './views/logika/Answers.vue'
import QuestionView from './views/logika/QuestionView.vue'

export default {
    base: '/elimination/',
    routes: [
        { path: '/', name: 'Root', component: RootView },
        { path: '/question/:id', name: 'QuestionView', component: QuestionView, props: true },
        { path: '/answers', name: 'Answers', component: Answers },
    ]
}
