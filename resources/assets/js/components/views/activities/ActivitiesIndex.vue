
<template>
    <div id="activities-index">

        <data-panel ref="dataPanel" v-model="activities" :checkable="true" :expandable="true" :deletable="true">
            Daftar Acara
            <data-panel-addon slot="control" :refresh="getActivities" :create="{ name: 'Acara.Buat' }"></data-panel-addon>
            <template slot="list" scope="props">
                <data-panel-list-item :id="props.data.id" :update="{ name: 'Acara.Sunting', params: { id: props.data.id }}" :delete="props.data.id > 3 ? '/activities/' + props.data.id : false">
                    <template slot="title">
                        <img :src="props.data.icon | assetify" class="img-circle user-img">
                        {{ props.data.name }}
                    </template>
                    <div>{{ props.data.short_description }}</div>
                    <p>
                        <small class="text-muted">
                            Dibuat pada {{ props.data.created_at | normalize }}. Terakhir disunting pada {{ props.data.updated_at | normalize }}
                        </small>
                    </p>
                    <template slot="actions">
                        <li role="separator" class="divider"></li>
                        <router-link tag="li" :to="{ name: 'Acara.Lihat', params: { id: props.data.id }}"><a>Lihat Detail</a></router-link>
                        <router-link tag="li" :to="{ name: 'Dasbor' }"><a>Lihat Peserta</a></router-link>
                    </template>
                </data-panel-list-item>
            </template>
            <template slot="delete-preview" scope="props">
                <div class="panel panel-default delete-preview">
                    <div class="panel-body">
                        <h4><small>#{{ props.data.id }}</small> <img :src="props.data.icon | assetify" class="img-circle user-img"> {{ props.data.name }}</h4>
                        <div>{{ props.data.short_description }}</div>
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
    import ActivitiesMixin from './ActivitiesMixin'
    import DataPanel from '../../kits/DataPanel/DataPanel.vue'
    import DataPanelAddon from '../../kits/DataPanel/Addon.vue'
    import DataPanelListItem from '../../kits/DataPanel/ListItem.vue'

    export default {

        mixins: [ActivitiesMixin],

        data() {
            return {
                dataPanel: null,
                activities: [],
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
            this.getActivities()
        },

        mounted() {
            this.prepareComponent()
        },

        methods: {

            getActivities() {
                Citeup.get('/activities', { 
                    take: 15 
                }).then(response => this.activities = response.data.data.activities)
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
