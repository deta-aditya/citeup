
<style lang="scss" scoped>
    
    .user-photo {
        height: 150px;
        margin: 0 30px 30px 0;
    }

</style>

<template>
    <div id="committees-view">
        <div class="form-panel">
            <div class="row">
                <div class="col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="pull-right">
                                <router-link class="btn btn-default" :to="{ name: 'Panitia' }">Indeks</router-link>
                                <router-link class="btn btn-default" :to="{ name: 'Panitia.Sunting', params: { id: id }}">Sunting</router-link>
                            </div>
                            <h1 class="page-title">{{ committee.name }} <small>Panitia / #{{ id }}</small></h1>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-4"><strong>Email</strong></div>
                                <div class="col-sm-8">{{ committee.email }}</div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-4"><strong>Kata Sandi</strong></div>
                                <div class="col-sm-8"><a href="#">Ubah Kata Sandi</a></div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-4"><strong>Posisi Kepanitiaan</strong></div>
                                <div class="col-sm-8">{{ committee.section }}</div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-4"><strong>Terdaftar sejak</strong></div>
                                <div class="col-sm-8">{{ committee.created_at | normalize }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <!-- <data-panel ref="dataPanel" v-model="user.schedules" :deletable="true">
                        Daftar Akses
                        <data-panel-addon slot="control" :create="{ name: 'Acara.Lihat.Buat Jadwal' }"></data-panel-addon>
                        <template slot="list" scope="props">
                            <data-panel-list-item :id="props.data.id" :update="{ name: 'Acara.Lihat.Sunting Jadwal', params: { id: id, schedule: props.data.id }}" :delete="'/schedules/' + props.data.id">
                                <template slot="title">{{ props.data.held_at | humanize }}</template>
                                <p>{{ props.data.description }}</p>
                                <p>
                                    <small class="text-muted">
                                        <i class="fa fa-pencil-square-o"></i> {{ props.data.updated_at | normalize }}
                                    </small>
                                </p>
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
                    </data-panel> -->
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import moment from 'moment'
    import Citeup from '../../../citeup'
    import UsersMixin from './UsersMixin'
    import FormPanel from '../../kits/FormPanel/FormPanel.vue'
    import DataPanel from '../../kits/DataPanel/DataPanel.vue'
    import DataPanelAddon from '../../kits/DataPanel/Addon.vue'
    import DataPanelListItem from '../../kits/DataPanel/ListItem.vue'

    export default {

        mixins: [UsersMixin],

        props: {

            id: {
                type: [Number, String],
                required: true
            }

        },

        data() {
            return {
                formPanel: null,
                committee: {
                    keys: []
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

        },

        created() {
            this.getUser()
        },

        mounted() {
            this.prepareComponent()
        },

        methods: {

            getUser() {
                Citeup.get('/users/' + this.id).then(response => {
                    this.committee = response.data.data.user
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
