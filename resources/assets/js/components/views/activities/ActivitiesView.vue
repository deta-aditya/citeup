
<style lang="scss" scoped>
    
    .activity-icon {
        height: 150px;
        margin: 0 30px 30px 0;
    }

</style>

<template>
    <div id="activities-view">
        <div class="form-panel">
            <div class="row">
                <div class="col-sm-8">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="pull-right" v-if="user.admin">
                                <router-link class="btn btn-default" :to="{ name: 'Acara' }">Indeks</router-link>
                                <router-link class="btn btn-default" :to="{ name: 'Acara.Sunting', params: { id: id }}">Sunting</router-link>
                                <a :href="activity.guide | assetify" class="btn btn-default" target="_blank" v-if="activity.guide">Panduan</a>
                            </div>
                            <h1 class="page-title">{{ activity.name }} <small v-if="user.admin">Acara / #{{ id }}</small></h1>
                        </div>
                        <div class="panel-body">
                            <img :src="activity.icon | assetify" class="pull-left img-circle activity-icon">
                            <p class="lead">{{ activity.short_description }}</p>
                            <div v-html="activity.description"></div>
                        </div>
                        <table class="table">
                            <tbody>
                                <tr v-if="user.admin">
                                    <th>Urutan</th><td>{{ activity.order }}</td>
                                </tr>
                                <tr>
                                    <th>Hadiah Juara 1</th><td>Rp{{ activity.prize_first | monetize }}</td>
                                </tr>
                                <tr>
                                    <th>Hadiah Juara 2</th><td>Rp{{ activity.prize_second | monetize }}</td>
                                </tr>
                                <tr>
                                    <th>Hadiah Juara 3</th><td>Rp{{ activity.prize_third | monetize }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="panel-body" v-if="user.admin">
                            Dibuat pada {{ activity.created_at | normalize }}, terakhir disunting pada {{ activity.updated_at | normalize }}
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <data-panel ref="dataPanel" v-model="activity.schedules" :deletable="user.admin">
                        Jadwal Acara
                        <data-panel-addon slot="control" :create="{ name: 'Acara.Lihat.Buat Jadwal' }" v-if="user.admin"></data-panel-addon>
                        <template slot="list" scope="props">
                            <data-panel-list-item :id="props.data.id" :update="{ name: 'Acara.Lihat.Sunting Jadwal', params: { id: id, schedule: props.data.id }}" :delete="'/schedules/' + props.data.id" v-if="user.admin">
                                <template slot="title">{{ props.data.held_at | humanize }}</template>
                                <p>{{ props.data.description }}</p>
                                <p>
                                    <small class="text-muted">
                                        <i class="fa fa-pencil-square-o"></i> {{ props.data.updated_at | normalize }}
                                    </small>
                                </p>
                            </data-panel-list-item>
                            <data-panel-list-item :id="props.data.id" :controls="false" :show-id="false" v-else>
                                <template slot="title">{{ props.data.held_at | humanize }}</template>
                                <p>{{ props.data.description }}</p>
                            </data-panel-list-item>
                        </template>
                        <template slot="delete-preview" scope="props">
                            <div class="panel panel-default delete-preview">
                                <div class="panel-body">
                                    <h4><small>#{{ props.data.id }}</small> {{ props.data.held_at | normalize }} &middot; {{ props.data.description }}</h4>
                                    <div><small class="text-muted">
                                        Dibuat pada {{ props.data.created_at | normalize }}. Terakhir disunting pada {{ props.data.updated_at | normalize }}
                                    </small></div>
                                </div>
                            </div>
                        </template>
                    </data-panel>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import moment from 'moment-timezone'
    import Citeup from '../../../citeup'
    import CurrentUser from '../../mixins/CurrentUser'
    import FormPanel from '../../kits/FormPanel/FormPanel.vue'
    import DataPanel from '../../kits/DataPanel/DataPanel.vue'
    import DataPanelAddon from '../../kits/DataPanel/Addon.vue'
    import DataPanelListItem from '../../kits/DataPanel/ListItem.vue'

    export default {

        mixins: [CurrentUser],

        props: {

            id: {
                type: [Number, String],
                required: true
            }

        },

        data() {
            return {
                formPanel: null,
                activity: {
                    schedules: []
                },
            }
        },

        filters: {

            humanize(value) {
                return moment(value).format('D MMMM YYYY, HH:mm')
            },

            normalize(value) {
                return moment(value).format('DD MMM, HH:mm')
            },

            assetify(value) {
                return Citeup.appPath + '/' + value
            },

            monetize(val) {

                if (val === null) {
                    val = '0'
                }

                var counter = 0
                var value = String(val)
                var formatted = ''

                for (let i = value.length - 1; i >= 0; i--) {

                    if (counter > 0 && counter % 3 === 0) {
                        formatted += '.'
                    }

                    formatted += value[i]

                    counter++
                }

                return formatted.split('').reverse().join('') + ',00'
            },

        },

        created() {
            this.getActivity()
        },

        mounted() {
            this.prepareComponent()
        },

        methods: {

            getActivity() {
                Citeup.get('/activities/' + this.id).then(response => {
                    this.activity = response.data.data.activity
                })
            },

            prepareComponent() {
                this.formPanel = this.$refs.formPanel
            },

        },

        components: {
            'form-panel': FormPanel,
            'data-panel': DataPanel,
            'data-panel-addon': DataPanelAddon,
            'data-panel-list-item': DataPanelListItem,
        }

    }

</script>
