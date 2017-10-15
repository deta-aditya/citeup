
<template>
    <div id="html-contents-view">
        <div class="form-panel">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="pull-right">
                        <router-link class="btn btn-default" :to="{ name: 'Konten' }">Indeks</router-link>
                        <router-link class="btn btn-default" :to="{ name: 'Konten.Sunting', params: { id: id }}">Sunting</router-link>
                    </div>
                    <h1 class="page-title">{{ html_content.name }} <small>Konten / #{{ id }}</small></h1>
                </div>
                <div class="panel-body text-justify">
                    <div v-html="html_content.content"></div>
                </div>
                <div class="panel-body">
                    Dibuat pada {{ html_content.created_at | normalize }}, terakhir disunting pada {{ html_content.updated_at | normalize }}
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import moment from 'moment-timezone'
    import Citeup from '../../../citeup'
    import HtmlContentsMixin from './HtmlContentsMixin'

    export default {

        mixins: [HtmlContentsMixin],

        props: {

            id: {
                type: [Number, String],
                required: true
            },

        },

        data() {
            return {
                formPanel: null,
                html_content: {},
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
            this.getHtmlContent()
        },

        methods: {

            getHtmlContent() {
                Citeup.get('/html-contents/' + this.id).then(response => {
                    this.html_content = response.data.data.html_content
                })
            },

        },

    }

</script>
