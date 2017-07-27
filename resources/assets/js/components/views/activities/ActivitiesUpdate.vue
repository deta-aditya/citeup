
<template>
    <div id="activities-edit">
        <form-panel ref="formPanel" method="put" :action="'/activities/' + id" :model="activity" :horizontal="true" @submitted="preview">
            <template slot="title">Sunting Acara</template>
            <template slot="header-control">
                <router-link :to="{ name: 'Acara' }" class="btn btn-default">Kembali</router-link>
            </template><text-input name="name" :required="true" :label-width="2" :control-width="10" v-model="activity.name">
                Judul
            </text-input>
            <multiline-input name="short_description" :required="true" :label-width="2" :control-width="10" v-model="activity.short_description">
                Deskripsi Singkat
                <p class="help-block" slot="help-block">Bagian ini akan lebih sering ditampilkan dibandingkan dengan deskripsi panjang.</p>
            </multiline-input>
            <rich-input name="description" :required="true" :label-width="2" :control-width="10" v-model="activity.description">
                Deskripsi Panjang
            </rich-input>
            <file-input name="icon" :label-width="2" :control-width="10" :object-id="activity.id" object-type="activity" accept="image/*" :store-immediately="true" :crop="false" v-model="activity.icon">
                Ikon
                <p class="help-block" slot="help-block">Gunakan gambar dengan ukuran 512 x 512 dengan latar belakang berwarna <span style="color:#dd7322">jingga tua (#DD7322)</span>.</p>
            </file-input>
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
    import RichInput from '../../kits/FormPanel/RichInput.vue'
    import FileInput from '../../kits/FormPanel/FileInput.vue'
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
                activity: {
                    id: 0,
                },
            }
        },

        created() {
            this.getActivity()
        },

        mounted() {
            this.prepareComponent()
        },

        methods: {

            getActivity() {
                Citeup.get('/activities/' + this.id).then(response => {
                    this.activity = response.data.data.activity
                })
            },

            prepareComponent() {
                this.formPanel = this.$refs.formPanel
            },

            preview() {
                this.$router.push({ name: 'Acara' })
            },

            submit() {
                this.formPanel.submit()
            },


        },

        components: {
            'form-panel': FormPanel,
            'text-input': TextInput,
            'rich-input': RichInput,
            'file-input': FileInput,
            'multiline-input': MultilineInput,
        }

    }

</script>
