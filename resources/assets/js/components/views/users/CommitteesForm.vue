
<template>
    <form-panel ref="formPanel" :method="method" :action="action" :model="user" :horizontal="true" @submitted="preview">
        <template slot="title">{{ title }} Panitia</template>
        <template slot="header-control">
            <router-link :to="{ name: 'Panitia' }" class="btn btn-default">Kembali</router-link>
        </template>
        <text-input name="name" :required="true" :label-width="2" :control-width="10" v-model="user.name">
            Nama
        </text-input>
        <email-input name="email" :required="true" :label-width="2" :control-width="10" :placeholder="email" v-model="user.email">
            Email 
        </email-input>
        <password-input name="password" :required="true" :label-width="2" :control-width="10" v-model="user.password" v-if="createMode">
            Kata Sandi
        </password-input>
        <password-input name="password_confirmation" :required="true" :label-width="2" :control-width="10" v-model="user.password_confirmation" v-if="createMode">
            Konfirmasi Kata Sandi
        </password-input>
        <template v-if="user.role === 3 || user.committee">
            <text-input name="section" :required="true" :label-width="2" :control-width="10" v-model="user.section">
                Posisi Kepanitiaan
            </text-input>
        </template>
        <template slot="footer-control">
            <div class="text-right">
                <button type="button" class="btn btn-primary" @click="submit">
                    Selesai
                </button>
            </div>
        </template>
    </form-panel>
</template>

<script>
    
    import Citeup from '../../../citeup'
    import FormPanel from '../../kits/FormPanel/FormPanel.vue'
    import TextInput from '../../kits/FormPanel/TextInput.vue'
    import EmailInput from '../../kits/FormPanel/EmailInput.vue'
    import PasswordInput from '../../kits/FormPanel/PasswordInput.vue'

    export default {

        props: {
            mode: String,
            id: [Number, String],
        },

        data() {
            return {
                formPanel: null,
                user: {
                    role: 3
                },
                email: '',
            }
        },

        computed: {
            createMode() {
                return this.mode === 'create'
            },
            updateMode() {
                return this.mode === 'update'
            },
            method() {
                if (this.createMode) {
                    return 'post'
                } else if (this.updateMode) {
                    return 'put'
                }
            },
            action() {
                if (this.createMode) {
                    return '/users'
                } else if (this.updateMode) {
                    return '/users/' + this.id
                }
            },
            title() {
                if (this.createMode) {
                    return 'Buat'
                } else if (this.updateMode) {
                    return 'Ubah'
                }
            },
            userRoles() {
                let roles = {}
                for (role of this.roles) {
                    roles[role.id] = role.name
                }
                return roles
            },
        },

        created() {
            if (this.updateMode) this.getUser()
        },

        mounted() {
            this.prepareComponent()
        },

        methods: {

            prepareComponent() {
                this.formPanel = this.$refs.formPanel
            },

            getUser() {
                if (this.createMode) { 
                    return 
                }

                Citeup.get('/users/' + this.id).then(response => {
                    this.user = response.data.data.user
                    this.email = this.user.email
                    this.user.email = ''
                })
            },

            preview() {
                this.$router.push({ name: 'Panitia' })
            },

            submit() {
                this.formPanel.submit()
            },

        },

        components: {
            'form-panel': FormPanel,
            'text-input': TextInput,
            'email-input': EmailInput,
            'password-input': PasswordInput,
        },

    }

</script>