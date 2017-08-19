
<template>
    <div id="news-index">

        <data-panel ref="dataPanel" v-model="news" :checkable="true" :expandable="true" :deletable="true">
            Daftar Berita
            <data-panel-addon slot="control" :refresh="getFaqs" :create="{ name: 'Berita.Buat' }"></data-panel-addon>
            <template slot="list" scope="props">
                <data-panel-list-item :id="props.data.id" :update="{ name: 'Berita.Sunting', params: { id: props.data.id }}" :delete="'/news/' + props.data.id">
                    <template slot="title">
                        <img :src="props.data.picture | assetify" class="img-rounded user-img">
                        {{ props.data.title }}
                    </template>
                    <div v-html="shorten(props.data.content)"></div>
                    <p>
                        <small class="text-muted">
                            Dibuat pada {{ props.data.created_at | normalize }}. Terakhir disunting pada {{ props.data.updated_at | normalize }}
                        </small>
                    </p>
                    <template slot="actions">
                        <li role="separator" class="divider"></li>
                        <router-link tag="li" :to="{ name: 'Berita.Lihat', params: { id: props.data.id }}"><a>Lihat Detail</a></router-link>
                    </template>
                </data-panel-list-item>
            </template>
            <template slot="delete-preview" scope="props">
                <div class="panel panel-default delete-preview">
                    <div class="panel-body">
                        <h4>
                            <small>#{{ props.data.id }}</small> 
                            <img :src="props.data.picture | assetify" class="img-rounded user-img">
                            {{ props.data.title }}
                        </h4>
                        <div v-html="shorten(props.data.content)"></div>
                        <div><small class="text-muted">
                            Dibuat pada {{ props.data.created_at | normalize }}. Terakhir disunting pada {{ props.data.updated_at | normalize }}
                        </small></div>
                    </div>
                </div>
            </template>
        </data-panel>

    </div>
</template>

<script>

    import _ from 'lodash'
    import moment from 'moment'
    import NewsMixin from './NewsMixin'
    import Citeup from '../../../citeup'
    import DataPanel from '../../kits/DataPanel/DataPanel.vue'
    import DataPanelAddon from '../../kits/DataPanel/Addon.vue'
    import DataPanelListItem from '../../kits/DataPanel/ListItem.vue'

    export default {

        mixins: [NewsMixin],

        data() {
            return {
                dataPanel: null,
                news: [],
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
            this.getFaqs()
        },

        mounted() {
            this.prepareComponent()
        },

        methods: {

            getFaqs() {
                Citeup.get('/news', { 
                    take: 15 
                }).then(response => this.news = response.data.data.news)
            },

            prepareComponent() {
                this.dataPanel = this.$refs.dataPanel
            },

            shorten(value) {
                if (value !== undefined && value.length > 100) {
                    return value.substring(0, 99) + '...'
                }

                return value
            },

        },

        components: {
            'data-panel': DataPanel,
            'data-panel-addon': DataPanelAddon,
            'data-panel-list-item': DataPanelListItem,
        }

    }

</script>
