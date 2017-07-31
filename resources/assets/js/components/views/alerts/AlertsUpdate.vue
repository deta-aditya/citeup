
<template>
    <div id="alerts-edit">
        <form-panel ref="formPanel" method="put" :action="'/alerts/' + id" :model="alert" :horizontal="true">
            <template slot="title">Sunting Notifikasi</template>
            <template slot="header-control">
                <router-link :to="{ name: 'Notifikasi' }" class="btn btn-default">Kembali</router-link>
            </template>

            <text-input name="ititle" :required="true" :label-width="2" :control-width="10" v-model="alert.title">
                Judul
            </text-input>
            <multiline-input name="icontent" :required="true" :label-width="2" :control-width="10" v-model="alert.content">
                Konten
            </multiline-input>

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

    import Citeup from '../../../citeup'
    import FormPanel from '../../kits/FormPanel/FormPanel.vue'
    import TextInput from '../../kits/FormPanel/TextInput.vue'
    import MultilineInput from '../../kits/FormPanel/MultilineInput.vue'

    export default {

        props: {

            id: {
                type: [Number, String],
                required: true
            }

        },

        data() {
            return {
                formPanel: null,
                alert: {
                    title: '',
                    content: '',
                }
            }
        },

        created() {
            this.getAlert()
        },

        mounted() {
            this.prepareComponent()
            this.registerEvents()
        },

        methods: {

            getAlert() {
                Citeup.get('/alerts/' + this.id).then(response => {
                    this.alert = response.data.data.alert
                })
            },

            prepareComponent() {
                this.formPanel = this.$refs.formPanel
            },

            registerEvents() {
                this.formPanel.$on('submitted', payload => this.$router.push({ name: 'Notifikasi' }))
            },

            submit() {
                this.formPanel.submit()
            },

        },

        components: {
            'form-panel': FormPanel,
            'text-input': TextInput,
            'multiline-input': MultilineInput,
        }

    }

</script>
