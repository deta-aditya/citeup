
<template>
    <div id="sponsors-index">

        <data-panel ref="dataPanel" v-model="sponsors" :checkable="true" :expandable="true" :deletable="true">
            Daftar Sponsor
            <data-panel-addon slot="control" :refresh="getSponsors" :create="{ name: 'Sponsor.Buat' }"></data-panel-addon>
            <template slot="list" scope="props">
                <data-panel-list-item :id="props.data.id" :update="{ name: 'Sponsor.Sunting', params: { id: props.data.id }}" :delete="'/sponsors/' + props.data.id">
                    <template slot="title">
                        <img :src="props.data.picture | assetify" class="img-circle user-img">
                        {{ props.data.name }}, <small>{{ props.data.type | detectType }}</small>
                    </template>
                    <p>
                        <small class="text-muted">
                            Dibuat pada {{ props.data.created_at | normalize }}. Terakhir disunting pada {{ props.data.updated_at | normalize }}
                        </small>
                    </p>
                </data-panel-list-item>
            </template>
            <template slot="delete-preview" scope="props">
                <div class="panel panel-default delete-preview">
                    <div class="panel-body">
                        <h4><small>#{{ props.data.id }}</small> <img :src="props.data.picture | assetify" class="img-circle user-img"> {{ props.data.name }}</h4>
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
    import SponsorsMixin from './SponsorsMixin'
    import DataPanel from '../../kits/DataPanel/DataPanel.vue'
    import DataPanelAddon from '../../kits/DataPanel/Addon.vue'
    import DataPanelListItem from '../../kits/DataPanel/ListItem.vue'

    export default {

        mixins: [SponsorsMixin],

        data() {
            return {
                dataPanel: null,
                sponsors: [],
            }
        },

        filters: {

            normalize(value) {
                return moment(value).format('DD MMM, HH:mm')
            },

            assetify(value) {
                return Citeup.appPath + '/' + value
            },

            detectType(value) {
                switch (value) {
                    case 1: 
                        return 'Sponsor'
                    case 2:
                        return 'Media Partner'
                }
            }

        },

        created() {
            this.getSponsors()
        },

        mounted() {
            this.prepareComponent()
        },

        methods: {

            getSponsors() {
                Citeup.get('/sponsors', { 
                    take: 15 
                }).then(response => this.sponsors = response.data.data.sponsors)
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
