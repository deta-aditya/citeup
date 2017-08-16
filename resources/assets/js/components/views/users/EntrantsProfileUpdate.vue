
<template>
    <div class="entrants-update">
        <form-panel ref="formPanel" method="put" :action="'/entrants/' + entry.id" :model="forModel" :bodiless="true" @submitted="preview">
            <div class="panel-body">
                <div class="pull-right">
                    <router-link :to="{ name: 'Profil' }" class="btn btn-default">Kembali</router-link>
                </div>
                <h1 class="page-title">Sunting Profil</h1>
            </div>
            <div class="panel-body form-horizontal">
                <text-input name="name" :label-width="2" :control-width="10" v-model="entry.name" v-if="entry.activity.id === 1">
                    Nama Tim
                </text-input>
                <text-input name="agency" :label-width="2" :control-width="10" v-model="entry.agency">
                    {{ entry.activity.id === 3 ? 'Instansi' : 'Asal Sekolah' }} 
                </text-input>
                <text-input name="city" :label-width="2" :control-width="10" v-model="entry.city">
                    Kota/Kabupaten
                </text-input>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div :class="'col-sm-' + 12 / entry.users.length" v-for="(user, index) in entry.users">
                        <file-input :name="'user-'+ user.id +'-photo'" :object-id="user.id" object-type="profile" accept="image/*" :crop="true" v-model="entry.users[index].photo">
                            <strong>Foto Anda</strong>
                            <p class="help-block" slot="help-block">Foto akan digunakan untuk tanda pengenal di acara final.</p>
                        </file-input>
                        <text-input :name="'user-'+ user.id +'-name'" v-model="entry.users[index].name">
                            Nama
                        </text-input>
                        <div class="form-group" v-if="entry.activity.id === 1">
                            <label class="control-label">Jabatan</label>
                            <div><strong>{{ user.crew ? 'Anggota' : 'Ketua' }} Tim</strong></div>
                        </div>
                        <email-input :name="'user-'+ user.id +'-email'" v-model="entry.users[index].email">
                            Email
                        </email-input>
                        <text-input :name="'user-'+ user.id +'-birthplace'" v-model="entry.users[index].birthplace">
                            Tempat Lahir
                        </text-input>
                        <date-time-input :name="'user-'+ user.id +'-birthdate'" format="YYYY-MM-DD" v-model="entry.users[index].birthdate">
                            Tempat Lahir
                        </date-time-input>
                        <multiline-input :name="'user-'+ user.id +'-address'" v-model="entry.users[index].address">
                            Alamat
                        </multiline-input>
                        <text-input :name="'user-'+ user.id +'-phone'" v-model="entry.users[index].phone">
                            No. Telepon
                        </text-input>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="text-right">
                    <button type="button" class="btn btn-primary" @click="submit">
                        Selesai
                    </button>
                </div>
            </div>
        </form-panel>
    </div>
</template>

<script>
    
    import _ from 'lodash'
    import Citeup from '../../../citeup'
    import { mapState, mapActions } from 'vuex'
    import FormPanel from '../../kits/FormPanel/FormPanel.vue'
    import FileInput from '../../kits/FormPanel/FileInput.vue'
    import TextInput from '../../kits/FormPanel/TextInput.vue'
    import EmailInput from '../../kits/FormPanel/EmailInput.vue'
    import DateTimeInput from '../../kits/FormPanel/DateTimeInput.vue'
    import MultilineInput from '../../kits/FormPanel/MultilineInput.vue'

    const STATES = ['user']

    const ACTIONS = {
        reloadUser: 'updateUserFromApi'
    }

    export default {

        data() {
            return {
                formPanel: null,
                entry: { users: [], activity: {} },
            }
        },

        computed: _.merge(mapState(STATES), {
            forModel() {
                return {
                    name: this.entry.name,
                    agency: this.entry.agency,
                    city: this.entry.city,
                    users: this.entry.users.map(item => {
                        return _.pick(item, [
                            'id', 'name', 'email', 'birthplace', 
                            'birthdate', 'address', 'phone', 'photo',
                        ])
                    }),
                }
            },
        }),

        watch: {
            user(newVal) {
                this.getEntry(newVal.entry.id)
            },
        },

        created() {
            if (this.user.id > 0) {
                this.getEntry(this.user.entry.id)
            }
        },

        mounted() {
            this.prepareComponent()
        },

        methods: _.merge(mapActions(ACTIONS), {

            prepareComponent() {
                this.formPanel = this.$refs.formPanel
            },

            getEntry(id) {
                Citeup.get('/entries/' + id).then(response => {
                    this.entry = response.data.data.entry
                })
            },

            preview() {
                this.reloadUser()
                this.$router.push({ name: 'Profil' })
            },

            submit() {
                this.formPanel.submit()
            },

        }),

        components: {
            'form-panel': FormPanel,
            'text-input': TextInput,
            'file-input': FileInput,
            'email-input': EmailInput,
            'date-time-input': DateTimeInput,
            'multiline-input': MultilineInput,
        },

    }

</script>