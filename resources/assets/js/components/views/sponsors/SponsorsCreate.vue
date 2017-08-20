
<template>
    <div id="sponsors-create">
        <form-panel ref="formPanel" method="put" :action="'/sponsors/' + sponsor.id" :model="sponsor" :horizontal="true" @submitted="preview">
            <template slot="title">Buat Sponsor</template>
            <template slot="header-control">
                <router-link :to="{ name: 'Sponsor' }" class="btn btn-default">Kembali</router-link>
            </template>
            <text-input name="name" :required="true" :label-width="2" :control-width="10" :autofocus="true" v-model="sponsor.name">
                Nama
            </text-input>
            <file-input name="picture" :label-width="2" :control-width="10" :object-id="sponsor.id" object-type="sponsor" accept="image/*" :store-immediately="true" :crop="false" v-model="sponsor.picture">
                Logo Sponsor
                <p class="help-block" slot="help-block">Agar pemuatan halaman lebih cepat, gunakan gambar berformat .png dengan tinggi 100px dan latar belakang transparan.</p>
            </file-input>
            <radio-button name="type" :label-width="2" :control-width="10" :list="radioButtons" v-model="sponsor.type">
                Tipe
                <template slot="list" scope="props">{{ props.data }}</template>
            </radio-button>
            <text-input name="url" :required="true" :label-width="2" :control-width="10" v-model="sponsor.url">
                URL (Tidak Wajib)
            </text-input>
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
    import SponsorsMixin from './SponsorsMixin'
    import FormPanel from '../../kits/FormPanel/FormPanel.vue'
    import TextInput from '../../kits/FormPanel/TextInput.vue'
    import FileInput from '../../kits/FormPanel/FileInput.vue'
    import RadioButton from '../../kits/FormPanel/RadioButton/List.vue'

    const RADIO_BUTTONS = { 1: 'Sponsor', 2: 'Media Partner' }

    export default {

        mixins: [SponsorsMixin],

        data() {
            return {
                formPanel: null,
                sponsor: { id: 0 },
                created: false,
                radioButtons: RADIO_BUTTONS,
            }
        },

        created() {
            this.createSponsor()
        },

        mounted() {
            this.prepareComponent()
        },

        methods: {

            createSponsor() {
                Citeup.post('/sponsors', { name: 'Sponsor', type: 1 }).then(response => {
                    this.sponsor = response.data.data.sponsor
                })
            },

            deleteSponsor(id) {
                return Citeup.delete('/sponsors/' + id)
            },

            prepareComponent() {
                this.formPanel = this.$refs.formPanel
            },

            preview() {
                this.created = true
                this.$router.push({ name: 'Sponsor' })
            },

            submit() {
                this.formPanel.submit()
            },

        },

        beforeRouteLeave(to, from, next) {
            if (! this.created && this.sponsor.id > 0) {
                this.deleteSponsor(this.sponsor.id).then(response => next())
            } else {
                next()
            }
        },

        components: {
            'form-panel': FormPanel,
            'text-input': TextInput,
            'file-input': FileInput,
            'radio-button': RadioButton,
        }

    }

</script>
