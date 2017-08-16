
<template>
    <div class="entrants-update">
        <form-panel ref="formPanel" method="put" :action="'/entries/' + id" :model="forModel" :bodiless="true" @submitted="preview">
            <div class="panel-body">
                <div class="pull-right">
                    <router-link :to="{ name: 'Peserta' }" class="btn btn-default">Kembali</router-link>
                </div>
                <h1 class="page-title">Sunting Peserta</h1>
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
    import UsersMixin from './UsersMixin'
    import FormPanel from '../../kits/FormPanel/FormPanel.vue'
    import FileInput from '../../kits/FormPanel/FileInput.vue'
    import TextInput from '../../kits/FormPanel/TextInput.vue'
    import EmailInput from '../../kits/FormPanel/EmailInput.vue'
    import DateTimeInput from '../../kits/FormPanel/DateTimeInput.vue'
    import MultilineInput from '../../kits/FormPanel/MultilineInput.vue'

    export default {

        mixins: [UsersMixin],

        props: {
            id: [Number, String],
        },

        data() {
            return {
                formPanel: null,
                entry: { users: [], activity: {} },
            }
        },

        computed: {
            forModel() {
                return {
                    name: this.entry.name,
                    agency: this.entry.agency,
                    city: this.entry.city,
                    users: this.entry.users.map(item => {
                        return _.pick(item, [
                            'id', 'name', 'email', 'birthplace', 
                            'birthdate', 'address', 'phone'
                        ])
                    }),
                }
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
            },

            getEntry(id) {
                Citeup.get('/entries/' + id).then(response => {
                    this.entry = response.data.data.entry
                })
            },

            preview() {
                this.$router.push({ name: 'Peserta' })
            },

            submit() {
                this.formPanel.submit()
            },

        },

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