
<style lang="scss" scoped>
    
    .user-photo {
        height: 150px;
    }

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

</style>

<template>
    <div id="entrants-profile">
        <div class="form-panel panel panel-default">
            <div class="panel-body">
                <div class="pull-right">
                    <router-link class="btn btn-primary" :to="{ name: 'Profil.Sunting' }">Sunting Profil</router-link>
                </div>
                <h1 class="page-title">Profil Saya</h1>
            </div>
            <div class="text-danger panel-body" v-if="entry.status === 0">
                <span class="context">Anda telah didiskualifikasi.</span>
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
                Anda terdaftar sebagai peserta {{ entry.activity.name }} sejak {{ entry.created_at | normalize }}.
            </div>
        </div>
    </div>
</template>

<script>

    import _ from 'lodash'
    import moment from 'moment'
    import Citeup from '../../../citeup'
    import { mapState, mapActions } from 'vuex'
    import StageTranslator from './StageTranslator'
    import FormPanel from '../../kits/FormPanel/FormPanel.vue'
    import FileInput from '../../kits/FormPanel/FileInput.vue'
    import TextInput from '../../kits/FormPanel/TextInput.vue'
    import EmailInput from '../../kits/FormPanel/EmailInput.vue'

    const STATES = [
        'user',
    ]

    const ACTIONS = {
        reloadUser: 'updateUserFromApi'
    }

    export default {

        mixins: [StageTranslator],

        data() {
            return {
                form: null,
                edit: false,
                editData: {},
                entry: { users: [ {} ], activity: { id: 1 }, stage: 0 },
            }
        },

        computed: _.merge(mapState(STATES), {
            keys() {
                return this.mapKeys(this.user.keys)
            },
        }),

        filters: {

            normalize(value, format = 'DD MMM, HH:mm') {
                return moment(value).format(format)
            },

            assetify(value) {
                return Citeup.appPath + '/' + value
            },

        },

        created() {
            this.getEntry(this.user.entry.id)
        },

        mounted() {
            this.prepareComponent()
        },

        methods: _.merge(mapActions(ACTIONS), {

            prepareComponent() {
                this.form = this.$refs.form
            },

            getEntry(id) {
                Citeup.get('/entries/' + id).then(response => {
                    this.entry = response.data.data.entry
                })
            },

            toggleEdit() {
                this.edit = ! this.edit
            },

            saveEdit() {
                this.form.submit()
            },

            afterEdit() {
                this.editData = {}
                this.reloadUser(this.user.id)
                this.toggleEdit()
            },

        }),

        components: {
            'text-input': TextInput,
            'file-input': FileInput,
            'email-input': EmailInput,
        },

    }

</script>
