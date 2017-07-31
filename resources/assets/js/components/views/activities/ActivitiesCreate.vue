
<template>
    <div id="activities-create">
        <form-panel ref="formPanel" method="post" action="/activities" :model="activity" :horizontal="true" @submitted="preview">
            <template slot="title">Buat Acara</template>
            <template slot="header-control">
                <router-link :to="{ name: 'Acara' }" class="btn btn-default">Kembali</router-link>
            </template>
            <text-input name="name" :required="true" :label-width="2" :control-width="10" v-model="activity.name">
                Judul
            </text-input>
            <multiline-input name="short_description" :required="true" :label-width="2" :control-width="10" v-model="activity.short_description">
                Deskripsi Singkat
                <p class="help-block" slot="help-block">Bagian ini akan lebih sering ditampilkan dibandingkan dengan deskripsi panjang.</p>
            </multiline-input>
            <rich-input name="description" :required="true" :label-width="2" :control-width="10" v-model="activity.description">
                Deskripsi Panjang
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

    import FormPanel from '../../kits/FormPanel/FormPanel.vue'
    import TextInput from '../../kits/FormPanel/TextInput.vue'
    import RichInput from '../../kits/FormPanel/RichInput.vue'
    import MultilineInput from '../../kits/FormPanel/MultilineInput.vue'

    export default {

        data() {
            return {
                formPanel: null,
                activity: {},
            }
        },

        mounted() {
            this.prepareComponent()
        },

        methods: {

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
            'multiline-input': MultilineInput,
        }

    }

</script>
