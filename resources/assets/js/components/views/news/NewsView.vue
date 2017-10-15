
<style lang="scss" scoped>
    .news-picture {
        max-height: 350px
    }
</style>

<template>
    <div id="activities-view">
        <div class="form-panel">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="pull-right" v-if="user.admin">
                        <router-link class="btn btn-default" :to="{ name: 'Berita' }">Indeks</router-link>
                        <router-link class="btn btn-default" :to="{ name: 'Berita.Sunting', params: { id: id }}">Sunting</router-link>
                    </div>
                    <h1 class="page-title">{{ news.title }} <small v-if="user.admin">Berita / #{{ id }}</small></h1>
                </div>
                <div class="panel-body text-center">
                    <img :src="news.picture | assetify" class="news-picture">
                </div>
                <div class="panel-body text-justify">
                    <div v-html="news.content"></div>
                </div>
                <div class="panel-body">
                    Dibuat pada {{ news.created_at | normalize }}, terakhir disunting pada {{ news.updated_at | normalize }}
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import moment from 'moment-timezone'
    import Citeup from '../../../citeup'
    import CurrentUser from '../../mixins/CurrentUser'

    export default {

        mixins: [CurrentUser],

        props: {

            id: {
                type: [Number, String],
                required: true
            },

        },

        data() {
            return {
                formPanel: null,
                news: {},
            }
        },

        filters: {

            normalize(value) {
                return moment(value).format('DD MMM, HH:mm')
            },

            assetify(value) {
                return Citeup.appPath + '/' + value
            },

        },

        created() {
            this.getNews()
        },

        methods: {

            getNews() {
                Citeup.get('/news/' + this.id).then(response => {
                    this.news = response.data.data.news
                })
            },

        },

    }

</script>
