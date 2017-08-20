
<template>
    <div id="html-contents-index">

        <data-panel ref="dataPanel" v-model="html_contents" :expandable="true" :deletable="true">
            Daftar Konten
            <data-panel-addon slot="control" :refresh="getHtmlContents" :create="{ name: 'Konten.Buat' }"></data-panel-addon>
            <template slot="list" scope="props">
                <data-panel-list-item :id="props.data.id" :update="{ name: 'Konten.Sunting', params: { id: props.data.id }}" :delete="'/html-contents/' + props.data.id">
                    <template slot="title">
                        {{ props.data.name }}
                    </template>
                    <div v-html="shorten(props.data.content)"></div>
                    <p>
                        <small class="text-muted">
                            Dibuat pada {{ props.data.created_at | normalize }}. Terakhir disunting pada {{ props.data.updated_at | normalize }}
                        </small>
                    </p>
                    <template slot="actions">
                        <li role="separator" class="divider"></li>
                        <router-link tag="li" :to="{ name: 'Konten.Lihat', params: { id: props.data.id }}"><a>Lihat Detail</a></router-link>
                    </template>
                </data-panel-list-item>
            </template>
            <template slot="delete-preview" scope="props">
                <div class="panel panel-default delete-preview">
                    <div class="panel-body">
                        <h4><small>#{{ props.data.id }}</small> {{ props.data.name }}</h4>
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
    import Citeup from '../../../citeup'
    import HtmlContentsMixin from './HtmlContentsMixin'
    import DataPanel from '../../kits/DataPanel/DataPanel.vue'
    import DataPanelAddon from '../../kits/DataPanel/Addon.vue'
    import DataPanelListItem from '../../kits/DataPanel/ListItem.vue'

    export default {

        mixins: [HtmlContentsMixin],

        data() {
            return {
                dataPanel: null,
                html_contents: [],
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
            this.getHtmlContents()
        },

        mounted() {
            this.prepareComponent()
        },

        methods: {

            getHtmlContents() {
                Citeup.get('/html-contents', { 
                    take: 15 
                }).then(response => this.html_contents = response.data.data.html_contents)
            },

            shorten(value) {
                if (value !== undefined && value.length > 300) {
                    return value.substring(0, 299) + '...'
                }

                return value
            },

            prepareComponent() {
                this.dataPanel = this.$refs.dataPanel
            },

        },

        components: {
            'data-panel': DataPanel,
            'data-panel-addon': DataPanelAddon,
            'data-panel-list-item': DataPanelListItem,
        }

    }

</script>
