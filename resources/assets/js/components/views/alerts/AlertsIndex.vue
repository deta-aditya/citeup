
<template>
    <div id="alerts-index">

        <data-panel
            ref="dataPanel"  
            v-model="alerts"
            :checkable="true" 
            :expandable="true"
            :deletable="authorized">
            Daftar Notifikasi
            
            <data-panel-addon 
                slot="control" 
                source="/alerts"
                :refreshable="true"
                :create="authorized ? { name: 'Notifikasi.Buat' } : null"></data-panel-addon>
            
            <template slot="list" scope="props">
                
                <data-panel-list-item v-if="authorized"
                    :id="props.data.id"
                    :update="{ name: 'Notifikasi.Sunting', params: { id: props.data.id }}" 
                    :delete="'/alerts/' + props.data.id">
                    <template slot="title">{{ props.data.title }}</template>

                    <div>{{ props.data.content }}</div>
                    <p>
                        <small class="text-muted">
                            Dibuat pada {{ props.data.created_at | normalize }}. Terakhir disunting pada {{ props.data.updated_at | normalize }}
                        </small>
                    </p>

                    <div v-show="props.data.id === details.id">
                        <p class="text-muted">Pengguna yang Diumumkan:</p>

                        <data-panel v-model="details.users" :headed="false">
                            <template slot="list" scope="props">
                                <data-panel-list-item :id="props.data.id" :controls="false" size="small">
                                    <template slot="title">
                                        <img :src="props.data.profile | signature" class="img-circle user-img">
                                        {{ props.data.name }}
                                        <div class="pull-right">
                                            <small class="text-muted">
                                                Diumumkan pada {{ props.data.announced_at | normalize }}. 
                                                <template v-if="props.data.seen_at === null">
                                                    Belum dilihat.
                                                </template>
                                                <template v-else>
                                                    Dilihat pada {{ props.data.seen_at | normalize }}.
                                                </template>
                                            </small>
                                            <button type="button" class="btn btn-link btn-sm" @click="see(props.data.id)">Lihat/Tak Lihat</button>&middot;
                                            <button type="button" class="btn btn-link btn-sm" @click="unannounce(props.data.id)">Lepaskan</button>
                                        </div>
                                    </template>
                                </data-panel-list-item>
                            </template>
                        </data-panel>

                    </div>

                    <template slot="actions">
                        <li role="separator" class="divider"></li>
                        <li><a href="#" @click.prevent="toggleDetails(props.data.id)">Pengguna...</a></li>
                        <li><a href="#" @click.prevent="doAnnounce(props.data.id)">Umumkan...</a></li>
                    </template>

                </data-panel-list-item>

                <data-panel-list-item v-else
                    :id="props.data.id"
                    :controls="props.data.seen_at === null">
                    <template slot="title">{{ props.data.title }}</template>

                    <div>{{ props.data.content }}</div>
                    <p>
                        <small class="text-muted">
                            Diumumkan pada {{ props.data.announced_at | normalize }}. 
                            <template v-if="props.data.seen_at === null">
                                Belum dilihat.
                            </template>
                            <template v-else>
                                Dilihat pada {{ props.data.seen_at | normalize }}.
                            </template>
                        </small>
                    </p>

                    <template slot="actions" v-if="props.data.seen_at === null">
                        <li><a href="#" @click.prevent="entrantSee(props.data.id)">Lihat</a></li>
                    </template>

                </data-panel-list-item>

            </template>

            <template slot="delete-preview" scope="props">
                <div class="panel panel-default delete-preview">
                    <div class="panel-body">
                        <h4><small>#{{ props.data.id }}</small> {{ props.data.title }}</h4>
                        <div>{{ props.data.content }}</div>
                        <div><small class="text-muted">Dibuat pada {{ props.data.created_at | normalize }}. Terakhir disunting pada {{ props.data.updated_at | normalize }}</small></div>
                    </div>
                </div>
            </template>
        </data-panel>

        <message-box ref="announceMessageBox" name="alerts-announce" backdrop="static" :dismissable="false" v-show="authorized">
            <template slot="title">Umumkan</template>

            <p class="text-muted">Silahkan pilih pengguna yang akan diumumkan.</p>
            <data-panel ref="announceDataPanel" v-model="announce.users" :headed="false" :checkable="true">
                <template slot="list" scope="props">
                    <data-panel-list-item :id="props.data.id" :controls="false" size="small">
                        <template slot="title">
                            <img :src="props.data.profile | signature" class="img-circle user-img">
                            {{ props.data.name }}, 
                            <small>{{ props.data.rolename | translateRole }}</small>
                        </template>
                    </data-panel-list-item>
                </template>
            </data-panel>

            <template slot="buttons">
                <button type="button" class="btn btn-default" @click="cancelAnnounce">Batal</button>
                <button type="button" class="btn btn-primary" @click="confirmAnnounce">Umumkan</button>
            </template>
        </message-box>

    </div>
</template>

<script>

    import _ from 'lodash'
    import moment from 'moment'
    import { mapState } from 'vuex'
    import Citeup from '../../../citeup'
    import DataPanel from '../../kits/DataPanel/DataPanel.vue'
    import DataPanelAddon from '../../kits/DataPanel/Addon.vue'
    import DataPanelListItem from '../../kits/DataPanel/ListItem.vue'
    import MessageBox from '../../kits/MessageBox.vue'
    import Dropdown from '../../kits/Dropdown.vue'

    const STATES = [
        'user'
    ] 

    export default {

        data() {
            return {
                dataPanel: null,
                alerts: [],
                details: {
                    id: 0,
                    users: [],
                    component: null,
                },
                announce: {
                    id: 0,
                    users: [],
                    messageBox: null,
                    dataPanel: null,
                },
            }
        },

        computed: _.merge(mapState(STATES), {
            
            authorized() {
                return this.user.admin
            },

        }),

        filters: {

            translateRole(value) {
                switch (value) {
                    case 'Committee': return 'Panitia'; break
                    case 'Entrant': return 'Peserta'; break
                    default: return value
                }
            },

            signature(value) {
                return value === null ? Citeup.defaultImage : Citeup.appPath + '/' + value.photo
            },

            normalize(value) {
                return moment(value).format('DD MMM, HH:mm')
            }

        },

        watch: {
            user() {
                this.getAlerts()
            }
        },

        created() {
            if (this.user.id > 0) {
                this.getAlerts()
            }
        },

        mounted() {
            this.prepareComponent()
        },

        methods: {

            getAlerts() {
                Citeup.get(this.user.admin ? '/alerts' : '/users/' + this.user.id + '/alerts', { 
                    take: 15 
                }).then(response => this.alerts = response.data.data.alerts)
            },

            prepareComponent() {
                this.dataPanel = this.$refs.dataPanel
                this.announce.dataPanel = this.$refs.announceDataPanel
                this.announce.messageBox = this.$refs.announceMessageBox
            },

            toggleDetails(id) {

                if (this.details.component !== null && 
                    this.details.component.expandable && 
                    this.details.component.expanded) {
                    this.details.component.expand()
                }

                if (this.details.id === id) {
                    return this.hideDetails()
                }

                this.showDetails(id)

            },

            showDetails(id) {
                Citeup.get('/alerts/' + id + '/users').then(response => {
                    this.details.id = id
                    this.details.users = response.data.data.users
                    this.details.component = this.dataPanel.listItem(id)

                    if (this.details.component.expandable && ! this.details.component.expanded) {
                        this.details.component.expand()
                    }
                })
            },

            hideDetails() {
                this.details.id = 0
                this.details.users = []
                this.details.component = null
            },

            doAnnounce(id) {
                Citeup.get('/users').then(response => {
                    this.announce.id = id
                    this.announce.users = response.data.data.users
                    this.announce.messageBox.open()
                })
            },

            cancelAnnounce() {
                this.announce.messageBox.close()
                this.announce.id = 0
                this.announce.users = []
            },

            confirmAnnounce() {
                Citeup.post('/alerts/' + this.announce.id + '/users', { 
                    announce: this.announce.dataPanel.checked
                }).then(response => {

                    if (this.details.id === this.announce.id) {
                        this.showDetails(this.announce.id)
                    } else {
                        this.toggleDetails(this.announce.id)
                    }

                    this.cancelAnnounce()
                })
            },

            see(id) {
                
                let params = {}

                if (this.details.users.find(user => user.id === id).seen_at === null) {
                    params.see = [this.details.id]
                } else {
                    params.unsee = [this.details.id]
                }

                Citeup.post('/users/' + id + '/alerts', params).then(response => this.showDetails(this.details.id))

            },

            entrantSee(id) {
                Citeup.post('/users/' + this.user.id + '/alerts', { see: [id] }).then(
                    response => this.getAlerts()
                )
            },

            unannounce(id) {
                Citeup.post('/alerts/' + this.details.id + '/users', {
                    unannounce: [id]
                }).then(response => this.showDetails(this.details.id))
            },

        },

        components: {
            'data-panel': DataPanel,
            'data-panel-addon': DataPanelAddon,
            'data-panel-list-item': DataPanelListItem,
            'message-box': MessageBox,
            'dropdown': Dropdown,
        }

    }

</script>
