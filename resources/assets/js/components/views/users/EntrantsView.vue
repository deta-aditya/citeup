
<style lang="scss" scoped>
    
    .user-photo {
        height: 150px;
    }

    .context {
        font-size: 16pt;
        font-weight: 300;
    }

    .panel-foot {
        border-top: 1px solid #ddd;
    }

    .fa-minus {
        color: #fff;
    }

</style>

<template>
    <div id="entrants-view">
        <message-box ref="disqualifier" name="disqualifier-box" backdrop="static" :dismissable="false">
            <!-- <template slot="title">{{ confirmation.title }} Akses</template>
            <p>Anda akan {{ confirmation.text }} akses <strong>{{ confirmation.key.slug | translateKeyName }}</strong> pada pengguna ini.</p>
            <p class="help-block"><strong>Kunci:</strong> {{ confirmation.key.items | joinSlugs }}</p>
            <template slot="buttons">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" @click="confirm">OK</button>
            </template> -->
        </message-box>
        <div class="form-panel">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="pull-right">
                        <router-link class="btn btn-default" :to="{ name: 'Peserta' }">Indeks</router-link>
                        <router-link class="btn btn-primary" :to="{ name: 'Peserta.Sunting', params: { id: id }}">Sunting</router-link>
                    </div>
                    <h1 class="page-title">{{ entry.name }} <small>Peserta {{ entry.activity.name }} / #{{ id }}</small></h1>
                </div>
                <div class="text-danger panel-body" v-if="entry.status === 0">
                    <span class="context">Peserta ini didiskualifikasi.</span>
                </div>
                <div class="panel-body" v-if="entry.activity.id === 1">
                    <div class="row">
                        <div class="col-sm-3">
                            <div>Nama Tim</div>
                            <div class="context">{{ entry.name }}</div>
                        </div>
                        <div class="col-sm-3">
                            <div>Asal Sekolah</div>
                            <div class="context">{{ entry.agency }}</div>
                        </div>
                        <div class="col-sm-3">
                            <div>Asal Kota</div>
                            <div class="context">{{ entry.city }}</div>
                        </div>
                        <div class="col-sm-3">
                            <div>Status</div>
                            <div class="context">{{ entry.stage | translateStage(entry.activity.id) }}</div>
                        </div>
                    </div>
                </div>
                <div class="panel-body text-center" v-if="entry.activity.id > 1">
                    <img :src="entry.users[0].photo | assetify" class="img-circle user-photo">
                </div>
                <div class="row gutterless">
                    <template v-if="entry.activity.id === 1">
                        <div :class="'col-sm-' + 12 / entry.users.length" v-for="(user, index) in entry.users">
                            <div class="panel-body text-center">
                                <img :src="user.photo | assetify" class="img-circle user-photo">
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-4"><strong>Nama</strong></div>
                                    <div class="col-sm-8">{{ user.name }}</div>
                                </div>
                            </div>
                            <div class="panel-body" v-if="entry.activity.id === 1">
                                <div class="row">
                                    <div class="col-sm-4"><strong>Jabatan</strong></div>
                                    <div class="col-sm-8">{{ user.crew ? 'Anggota' : 'Ketua' }} Tim</div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-4"><strong>Email</strong></div>
                                    <div class="col-sm-8">{{ user.email }}</div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-4"><strong>TTL</strong></div>
                                    <div class="col-sm-8">{{ user.birthplace }}, {{ user.birthdate | normalize('DD MMMM YYYY') }}</div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-4"><strong>Alamat</strong></div>
                                    <div class="col-sm-8">{{ user.address }}</div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-4"><strong>No. Telp.</strong></div>
                                    <div class="col-sm-8">{{ user.phone }}</div>
                                </div>
                            </div>
                        </div>
                    </template>
                    <template v-else>
                        <div class="col-sm-6">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-4"><strong>Nama Lengkap</strong></div>
                                    <div class="col-sm-8">{{ entry.users[0].name }}</div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-4"><strong>Email</strong></div>
                                    <div class="col-sm-8">{{ entry.users[0].email }}</div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-4"><strong>TTL</strong></div>
                                    <div class="col-sm-8">{{ entry.users[0].birthplace }}, {{ entry.users[0].birthdate | normalize('DD MMMM YYYY') }}</div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-4"><strong>Alamat Rumah</strong></div>
                                    <div class="col-sm-8">{{ entry.users[0].address }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-4"><strong>Nomor Telepon</strong></div>
                                    <div class="col-sm-8">{{ entry.users[0].phone }}</div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-4"><strong>Instansi / Sekolah</strong></div>
                                    <div class="col-sm-8">{{ entry.agency || '(Tidak Diisi)' }}</div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-4"><strong>Asal Kota &amp; Provinsi</strong></div>
                                    <div class="col-sm-8">{{ entry.city }}</div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-4"><strong>Status Peserta</strong></div>
                                    <div class="col-sm-8">{{ entry.stage | translateStage(entry.activity.id) }}</div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
                <div class="panel-body panel-foot">
                    <div class="pull-right">
                        <button type="button" class="btn btn-default" v-if="entry.status === 1">Diskualifikasi</button>
                        <button type="button" class="btn btn-default" v-else-if="entry.status === 0">Aktifkan</button>
                    </div>
                    <p>Peserta ini terdaftar sejak {{ entry.created_at | normalize }}.</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import moment from 'moment'
    import Citeup from '../../../citeup'
    import UsersMixin from './UsersMixin'
    import StageTranslator from './StageTranslator'
    import MessageBox from '../../kits/MessageBox.vue'
    import FormPanel from '../../kits/FormPanel/FormPanel.vue'
    import DataPanel from '../../kits/DataPanel/DataPanel.vue'
    import DataPanelAddon from '../../kits/DataPanel/Addon.vue'
    import DataPanelListItem from '../../kits/DataPanel/ListItem.vue'

    export default {

        mixins: [UsersMixin, StageTranslator],

        props: {

            id: {
                type: [Number, String],
                required: true
            }

        },

        data() {
            return {
                formPanel: null,
                disqualifierBox: null,
                entry: { activity: {}, users: [ {} ] },
            }
        },

        filters: {

            normalize(value, format = 'DD MMM, HH:mm') {
                return moment(value).format(format)
            },

            assetify(value) {
                return Citeup.appPath + '/' + value
            },

            joinUsers(value) {
                return value.map(item => item.name).join(', ')
            },

        },

        created() {
            this.getEntry(this.id)
        },

        mounted() {
            this.prepareComponent()
        },

        methods: {

            prepareComponent() {
                this.formPanel = this.$refs.formPanel
                this.disqualifierBox = this.$refs.disqualifier
            },

            getEntry(id) {
                Citeup.get('/entries/' + id).then(response => {
                    this.entry = response.data.data.entry
                })
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
