
<style lang="scss" scoped>
    
    .user-photo {
        height: 150px;
    }

    .fa-key {
        margin-right: 8px;
    }

</style>

<template>
    <div id="committees-profile">
        <div class="form-panel">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="pull-right">
                        <template v-if="edit">
                            <button class="btn btn-default" @click="toggleEdit">Batalkan</button>
                            <button class="btn btn-primary" @click="saveEdit">Simpan Perubahan</button>
                        </template>
                        <button class="btn btn-primary" v-else @click="toggleEdit">Sunting Profil</button>
                    </div>
                    <h1 class="page-title"><span v-if="edit">Sunting</span> Profil Saya</h1>
                </div>
            </div>
        </div>
        <div class="form-panel">
            <div class="row">
                <div class="col-sm-6">
                    <api-form ref="form" class="panel panel-default form-horizontal" method="put" :action="'/users/' + user.id" :model="editData" @submitted="afterEdit">
                        <div class="panel-body">
                            <h2 class="page-title small-title">Data Pribadi</h2>
                        </div>
                        <div class="panel-body">
                            <file-input name="photo" :label-width="4" :control-width="8" :object-id="user.id" object-type="profile" accept="image/*" :crop="true" v-model="editData.photo" v-if="edit">
                                <strong>Foto Anda</strong>
                                <p class="help-block" slot="help-block">Foto akan digunakan untuk tanda pengenal di acara final.</p>
                            </file-input>
                            <div class="text-center" v-else>
                                <img :src="user.photo | assetify" class="img-circle user-photo">
                            </div>
                        </div>
                        <div class="panel-body">
                            <text-input name="name" :label-width="4" :control-width="8" :placeholder="user.name" v-model="editData.name" v-if="edit">
                                <strong>Nama Lengkap</strong>
                            </text-input>
                            <div class="row" v-else>
                                <div class="col-sm-4"><strong>Nama Lengkap</strong></div>
                                <div class="col-sm-8">{{ user.name }}</div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <email-input name="email" :label-width="4" :control-width="8" :placeholder="user.email" v-model="editData.email" v-if="edit">
                                <strong>Email</strong>
                            </email-input>
                            <div class="row" v-else>
                                <div class="col-sm-4"><strong>Email</strong></div>
                                <div class="col-sm-8">{{ user.email }}</div>
                            </div>
                        </div>
                        <div class="panel-body" v-show="! edit">
                            <div class="row">
                                <div class="col-sm-4"><strong>Kata Sandi</strong></div>
                                <div class="col-sm-8">
                                    <router-link :to="{ name: 'Ubah Kata Sandi' }">Ubah Kata Sandi</router-link>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <text-input name="section" :required="true" :label-width="4" :control-width="8" :placeholder="user.section" v-model="editData.section" v-if="edit">
                                <strong>Posisi Kepanitian</strong>
                            </text-input>
                            <div class="row" v-else>
                                <div class="col-sm-4"><strong>Posisi Kepanitiaan</strong></div>
                                <div class="col-sm-8">{{ user.section }}</div>
                            </div>
                        </div>
                        <div class="panel-body" v-show="! edit">
                            <div class="row">
                                <div class="col-sm-4"><strong>Terdaftar sejak</strong></div>
                                <div class="col-sm-8">{{ user.created_at | normalize }}</div>
                            </div>
                        </div>
                    </api-form>
                </div>
                <div class="col-sm-6">
                    <data-panel ref="dataPanel" v-model="keys" :small-title="true">
                        Daftar Akses
                        <template slot="list" scope="props">
                            <data-panel-list-item size="small" :id="props.data.slug" :controls="false" :show-id="false">
                                <template slot="title"><i class="fa fa-key"></i> {{ props.data.slug | translateKeyName }}</template>
                            </data-panel-list-item>
                        </template>
                    </data-panel>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import _ from 'lodash'
    import moment from 'moment-timezone'
    import Citeup from '../../../citeup'
    import { mapState, mapActions } from 'vuex'
    import KeyMapper from '../../keys/KeyMapper'
    import ApiForm from '../../forms/ApiForm.vue'
    import FileInput from '../../kits/FormPanel/FileInput.vue'
    import TextInput from '../../kits/FormPanel/TextInput.vue'
    import DataPanel from '../../kits/DataPanel/DataPanel.vue'
    import DataPanelAddon from '../../kits/DataPanel/Addon.vue'
    import EmailInput from '../../kits/FormPanel/EmailInput.vue'
    import DataPanelListItem from '../../kits/DataPanel/ListItem.vue'

    const STATES = [
        'user',
    ]

    const ACTIONS = {
        reloadUser: 'updateUserFromApi'
    }

    export default {

        mixins: [KeyMapper],

        data() {
            return {
                form: null,
                edit: false,
                editData: {},
            }
        },

        computed: _.merge(mapState(STATES), {
            keys() {
                return this.mapKeys(this.user.keys)
            },
        }),

        filters: {

            normalize(value) {
                return moment(value).format('DD MMM, HH:mm')
            },

            assetify(value) {
                return Citeup.appPath + '/' + value
            },

        },

        mounted() {
            this.prepareComponent()
        },

        methods: _.merge(mapActions(ACTIONS), {

            prepareComponent() {
                this.form = this.$refs.form
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
            'api-form': ApiForm,
            'data-panel': DataPanel,
            'text-input': TextInput,
            'file-input': FileInput,
            'email-input': EmailInput,
            'data-panel-addon': DataPanelAddon,
            'data-panel-list-item': DataPanelListItem,
        },

    }

</script>
