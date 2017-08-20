
<template>
    <div id="contact-people-create">
        <form-panel ref="formPanel" method="post" action="/contact-people" :model="contact_person" :horizontal="true" @submitted="preview">
            <template slot="title">Buat <i>Contact Person</i></template>
            <template slot="header-control">
                <router-link :to="{ name: 'Contact Person' }" class="btn btn-default">Kembali</router-link>
            </template>
            <text-input name="name" :required="true" :label-width="2" :control-width="10" v-model="contact_person.name">
                Nama
            </text-input>
            <text-input name="phone" :label-width="2" :control-width="10" v-model="contact_person.phone">
                Nomor Telepon
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
    
    import ContactPeopleMixin from './ContactPeopleMixin'
    import FormPanel from '../../kits/FormPanel/FormPanel.vue'
    import TextInput from '../../kits/FormPanel/TextInput.vue'
    import RichInput from '../../kits/FormPanel/RichInput.vue'

    export default {

        mixins: [ContactPeopleMixin],

        data() {
            return {
                formPanel: null,
                contact_person: {},
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
                this.$router.push({ name: 'Contact Person' })
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
