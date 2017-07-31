
<template>
    <div id="schedules-create">
        <form-panel ref="formPanel" method="post" action="/schedules" :model="schedule" :horizontal="true" @submitted="preview">
            <template slot="title">Buat Jadwal</template>
            <template slot="header-control">
                <router-link :to="back" class="btn btn-default">Kembali</router-link>
            </template>
            <static-input name="activity_id" :label-width="2" :control-width="10" v-model="activity.name">
                Acara
            </static-input>
            <date-time-input name="held_at" :label-width="2" :control-width="10" v-model="schedule.held_at">
                Hari dan Jam
            </date-time-input>
            <text-input name="description" :required="true" :label-width="2" :control-width="10" v-model="schedule.description">
                Deskripsi
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

    import Citeup from '../../../../citeup'
    import FormPanel from '../../../kits/FormPanel/FormPanel.vue'
    import TextInput from '../../../kits/FormPanel/TextInput.vue'
    import StaticInput from '../../../kits/FormPanel/StaticInput.vue'
    import DateTimeInput from '../../../kits/FormPanel/DateTimeInput.vue'

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
                back: { name: 'Acara.Lihat', params: { id: this.id } },
                activity: {},
                schedule: {
                    activity: this.id
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
                this.$router.push(this.back)
            },

            submit() {
                this.formPanel.submit()
            },

        },

        components: {
            'form-panel': FormPanel,
            'text-input': TextInput,
            'static-input': StaticInput,
            'date-time-input': DateTimeInput,
        }

    }

</script>
