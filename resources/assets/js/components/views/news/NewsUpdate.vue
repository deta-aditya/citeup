
<template>
    <div id="news-create">
        <form-panel ref="formPanel" method="put" :action="'/news/' + id" :model="news" :horizontal="true" @submitted="preview">
            <template slot="title">Sunting Berita</template>
            <template slot="header-control">
                <router-link :to="{ name: 'Berita' }" class="btn btn-default">Kembali</router-link>
            </template>
            <text-input name="title" :required="true" :label-width="2" :control-width="10" :autofocus="true" v-model="news.title">
                Judul Berita
            </text-input>
            <file-input name="picture" :label-width="2" :control-width="10" :object-id="id" object-type="news" accept="image/*" :store-immediately="true" :crop="true" :aspect-ratio="1/0.508" v-model="news.picture">
                Foto Berita
                <p class="help-block" slot="help-block">Gunakan gambar dengan ukuran 1024 x 525 atau lebih besar untuk hasil terbaik.</p>
            </file-input>
            <rich-input name="content" :required="true" :label-width="2" :control-width="10" v-model="news.content">
                Isi Berita
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

    import NewsMixin from './NewsMixin'
    import Citeup from '../../../citeup'    
    import FormPanel from '../../kits/FormPanel/FormPanel.vue'
    import TextInput from '../../kits/FormPanel/TextInput.vue'
    import FileInput from '../../kits/FormPanel/FileInput.vue'
    import RichInput from '../../kits/FormPanel/RichInput.vue'

    export default {

        mixins: [NewsMixin],

        props: {

            id: {
                type: [Number, String],
                required: true
            },

        },

        data() {
            return {
                formPanel: null,
                news: {},
            }
        },

        created() {
            this.getNews()
        },

        mounted() {
            this.prepareComponent()
        },

        methods: {

            getNews() {
                Citeup.get('/news/' + this.id).then(response => {
                    this.news = response.data.data.news
                })
            },

            prepareComponent() {
                this.formPanel = this.$refs.formPanel
            },

            preview() {
                this.$router.push({ name: 'Berita' })
            },

            submit() {
                this.formPanel.submit()
            },

        },

        components: {
            'form-panel': FormPanel,
            'text-input': TextInput,
            'file-input': FileInput,
            'rich-input': RichInput,
        }

    }

</script>
