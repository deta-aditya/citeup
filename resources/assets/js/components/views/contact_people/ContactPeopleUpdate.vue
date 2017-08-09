
<template>
    <div id="contact-people-create">
        <form-panel ref="formPanel" method="put" :action="'/contact-people/' + id" :model="contact_person" :horizontal="true" @submitted="preview">
            <template slot="title">Sunting <i>Contact Person</i></template>
            <template slot="header-control">
                <router-link :to="{ name: 'Contact Person' }" class="btn btn-default">Kembali</router-link>
            </template>
            <text-input name="name" :required="true" :label-width="2" :control-width="10" v-model="contact_person.name">
                Nama
            </text-input>
            <text-input name="email" :required="true" :label-width="2" :control-width="10" v-model="contact_person.email">
                Email
            </text-input>
            <text-input name="phone" :label-width="2" :control-width="10" v-model="contact_person.phone">
                Nomor Telepon
            </text-input>
            <text-input name="line" :label-width="2" :control-width="10" v-model="contact_person.line">
                LINE ID
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
    import FormPanel from '../../kits/FormPanel/FormPanel.vue'
    import TextInput from '../../kits/FormPanel/TextInput.vue'
    import RichInput from '../../kits/FormPanel/RichInput.vue'

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
                contact_person: {},
            }
        },

        created() {
            this.getContactPerson()
        },

        mounted() {
            this.prepareComponent()
        },

        methods: {

            getContactPerson() {
                Citeup.get('/contact-people/' + this.id).then(response => {
                    this.contact_person = response.data.data.contact_person
                })
            },

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
