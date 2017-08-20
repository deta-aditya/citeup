
<template>
    <div id="html-contents-create">
        <form-panel ref="formPanel" method="put" :action="'/html-contents/' + id" :model="html_content" :horizontal="true" @submitted="preview">
            <template slot="title">Sunting Konten</template>
            <template slot="header-control">
                <router-link :to="{ name: 'Konten' }" class="btn btn-default">Kembali</router-link>
            </template>
            <text-input name="name" :required="true" :label-width="2" :control-width="10" v-model="html_content.name">
                Nama Konten
            </text-input>
            <rich-input name="content" :required="true" :label-width="2" :control-width="10" v-model="html_content.content">
                Isi Konten
            </rich-input>
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
    import HtmlContentsMixin from './HtmlContentsMixin'
    import FormPanel from '../../kits/FormPanel/FormPanel.vue'
    import TextInput from '../../kits/FormPanel/TextInput.vue'
    import RichInput from '../../kits/FormPanel/RichInput.vue'

    export default {

        mixins: [HtmlContentsMixin],

        props: {

            id: {
                type: [Number, String],
                required: true
            }

        },

        data() {
            return {
                formPanel: null,
                html_content: {},
            }
        },

        created() {
            this.getHtmlContent()
        },

        mounted() {
            this.prepareComponent()
        },

        methods: {

            getHtmlContent() {
                Citeup.get('/html-contents/' + this.id).then(response => {
                    this.html_content = response.data.data.html_content
                })
            },

            prepareComponent() {
                this.formPanel = this.$refs.formPanel
            },

            preview() {
                this.$router.push({ name: 'Konten' })
            },

            submit() {
                this.formPanel.submit()
            },

        },

        components: {
            'form-panel': FormPanel,
            'text-input': TextInput,
            'rich-input': RichInput,
        }

    }

</script>
