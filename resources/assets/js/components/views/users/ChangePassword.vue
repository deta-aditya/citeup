
<template>
    <div class="change-password">
        <message-box ref="messageBox" name="message-box" backdrop="static" :dismissable="false" @hidden="leave">
            <template slot="title">Berhasil</template>
            <p>Kata Sandi Anda berhasil diubah. Silahkan gunakan kata sandi baru untuk login selanjutnya.</p>
            <template slot="buttons">
                <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
            </template>
        </message-box>
        <form-panel ref="formPanel" method="post" :action="'/users/' + user.id + '/password'" :model="edit" :horizontal="true" @submitted="submitted">
            <template slot="title">Ubah Kata Sandi</template>
            <template slot="header-control">
                <router-link :to="{ name: 'Profil' }" class="btn btn-default">Kembali</router-link>
            </template>
            <password-input name="old_password" :required="true" :label-width="2" :control-width="10" v-model="edit.password_old">
                Kata Sandi Lama
            </password-input>
            <password-input name="password" :required="true" :label-width="2" :control-width="10" v-model="edit.password">
                Kata Sandi Baru
            </password-input>
            <password-input name="password_confirmation" :required="true" :label-width="2" :control-width="10" v-model="edit.password_confirmation">
                Konfirmasi Kata Sandi Baru
            </password-input>
            <template slot="footer-control">
                <div class="text-right">
                    <button type="button" class="btn btn-primary" @click="submit">
                        Selesai
                    </button>
                </div>
            </template>
        </form-panel>
    </div>
</template>

<script>
    
    import { mapState } from 'vuex'
    import Citeup from '../../../citeup'
    import MessageBox from '../../kits/MessageBox.vue'
    import FormPanel from '../../kits/FormPanel/FormPanel.vue'
    import PasswordInput from '../../kits/FormPanel/PasswordInput.vue'

    const STATES = [
        'user',
    ]

    export default {

        data() {
            return {
                formPanel: null,
                messageBox: null,
                edit: {},
            }
        },

        computed: mapState(STATES),

        mounted() {
            this.prepareComponent()
        },

        methods: {

            prepareComponent() {
                this.formPanel = this.$refs.formPanel
                this.messageBox = this.$refs.messageBox
            },

            submit() {
                this.formPanel.submit()
            },

            submitted() {
                this.messageBox.open()
            },

            leave() {
                this.$router.push({ name: 'Profil' })
            },

        },

        components: {
            'form-panel': FormPanel,
            'message-box': MessageBox,
            'password-input': PasswordInput,
        },

    }

</script>