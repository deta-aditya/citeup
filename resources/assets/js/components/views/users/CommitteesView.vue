
<style lang="scss" scoped>
    
    .user-photo {
        height: 150px;
    }

    .fa-minus {
        color: #fff;
    }

</style>

<template>
    <div id="committees-view">
        <message-box ref="confirmation" name="confirmation-box" backdrop="static" :dismissable="false">
            <template slot="title">{{ confirmation.title }} Akses</template>
            <p>Anda akan {{ confirmation.text }} akses <strong>{{ confirmation.key.slug | translateKeyName }}</strong> pada pengguna ini.</p>
            <p class="help-block"><strong>Kunci:</strong> {{ confirmation.key.items | joinSlugs }}</p>
            <template slot="buttons">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" @click="confirm">OK</button>
            </template>
        </message-box>
        <div class="form-panel">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="pull-right">
                        <router-link class="btn btn-default" :to="{ name: 'Panitia' }">Indeks</router-link>
                        <router-link class="btn btn-primary" :to="{ name: 'Panitia.Sunting', params: { id: id }}">Sunting</router-link>
                    </div>
                    <h1 class="page-title">{{ committee.name }} <small>Panitia / #{{ id }}</small></h1>
                </div>
            </div>
        </div>
        <div class="form-panel">
            <div class="row">
                <div class="col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <h2 class="page-title small-title">Profil</h2>
                        </div>
                        <div class="panel-body text-center">
                            <img :src="committee.photo | assetify" class="img-circle user-photo">
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-4"><strong>Nama Lengkap</strong></div>
                                <div class="col-sm-8">{{ committee.name }}</div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-4"><strong>Email</strong></div>
                                <div class="col-sm-8">{{ committee.email }}</div>
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
                    <data-panel ref="dataPanel" v-model="keys" :small-title="true">
                        Daftar Akses
                        <template slot="list" scope="props">
                            <data-panel-list-item 
                                size="small" 
                                :id="props.data.slug" 
                                :class="{ 'active': committeeHasKey(props.data.slug) }" 
                                :controls="false" 
                                :show-id="false">
                                <template slot="title">{{ props.data.slug | translateKeyName }}</template>
                                <template slot="controls">
                                    <button class="btn btn-link" title="Hapus Akses" @click.stop="ungrant(props.data)" v-if="committeeHasKey(props.data.slug)">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                    <button class="btn btn-link" title="Beri Akses" @click.stop="grant(props.data)" v-else>
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </template>
                            </data-panel-list-item>
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
    import KeyMapper from '../../keys/KeyMapper'
    import MessageBox from '../../kits/MessageBox.vue'
    import AdminGuardMixin from '../../guards/AdminGuardMixin'
    import FormPanel from '../../kits/FormPanel/FormPanel.vue'
    import DataPanel from '../../kits/DataPanel/DataPanel.vue'
    import DataPanelAddon from '../../kits/DataPanel/Addon.vue'
    import DataPanelListItem from '../../kits/DataPanel/ListItem.vue'

    export default {

        mixins: [AdminGuardMixin, KeyMapper],

        props: {

            id: {
                type: [Number, String],
                required: true
            }

        },

        data() {
            return {
                formPanel: null,
                committee: { keys: [] },
                keys: [],
                confirmation: {
                    mode: '',
                    title: '',
                    text: '',
                    key: { items: [], slug: '' },
                    box: null,  
                },
            }
        },

        filters: {

            normalize(value) {
                return moment(value).format('DD MMM, HH:mm')
            },

            assetify(value) {
                return Citeup.appPath + '/' + value
            },

            joinSlugs(value) {
                return value.map(item => item.slug).join(', ')
            },

        },

        created() {
            this.getUser()
            this.getAllKeys()
        },

        mounted() {
            this.prepareComponent()
        },

        methods: {

            prepareComponent() {
                this.formPanel = this.$refs.formPanel
                this.confirmation.box = this.$refs.confirmation
            },

            getUser() {
                Citeup.get('/users/' + this.id).then(response => {
                    this.committee = response.data.data.user
                    this.committee.keys = this.mapKeys(this.committee.keys)
                })
            },

            getAllKeys() {
                Citeup.get('/keys', { take: 100 }).then(
                    response => this.keys = this.mapKeys(response.data.data.keys)
                )
            },

            grant(key) {
                this.confirmation.key = key
                this.confirmation.mode = 'grant'
                this.confirmation.title = 'Beri'
                this.confirmation.text = 'memberi'
                this.confirmation.box.open()
            },

            ungrant(key) {
                this.confirmation.key = key
                this.confirmation.mode = 'ungrant'
                this.confirmation.title = 'Hapus'
                this.confirmation.text = 'mengahpus'
                this.confirmation.box.open()
            },

            confirm() {
                let data = {}
                data[this.confirmation.mode] = []

                for (let item of this.confirmation.key.items) {
                    data[this.confirmation.mode].push(item.id)
                }

                Citeup.post('/users/' + this.id + '/keys', data).then(response => {
                    this.getUser()
                    this.getAllKeys()
                    this.confirmation.box.close()
                })
            },

            committeeHasKey(slug) {
                return this.committee.keys.findIndex(item => {
                    return item.slug === slug
                }) >= 0
            },

        },

        components: {
            'form-panel': FormPanel,
            'data-panel': DataPanel,
            'message-box': MessageBox,
            'data-panel-addon': DataPanelAddon,
            'data-panel-list-item': DataPanelListItem,
        }

    }

</script>
