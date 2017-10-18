
<style lang="scss" scoped>
    .elimination {
        text-align: center;
        padding-top: 100px;

        .fa {
            margin-bottom: 50px;            
        }
    }
</style>

<template>
    <div class="elimination">
        <template v-if="mayContinue">
            <div class="text-center"><i class="fa fa-5x fa-spin fa-compass"></i></div>
            <p class="lead text-center">Mengalihkan Anda...</p>
        </template>
        <template v-else>
            <div class="text-center"><i class="fa fa-5x fa-hand-paper-o"></i></div>
            <p class="lead text-center">Maaf. Anda tidak dapat mengikuti tahap penyisihan.</p>
            <p>Berikut adalah alasan-alasan yang mungkin:</p>
            <ul>
                <li>Dokumen Anda tidak diverifikasi oleh panitia.</li>
                <li>Anda telah didiskualifikasi oleh panitia karena hal tertentu.</li>
                <li>Jika sebelumnya Anda mengikuti sesi uji coba, maka sesi uji coba telah selesai sehingga Anda tidak dapat lagi mengakses fitur ini.</li>
            </ul>
            <p>Jika Anda merasa tidak berada pada salah satu situasi di atas, diskusikan dengan <i>contact person</i> kami: </p>
            <ul>
                <li v-for="contact in contact_people">{{ contact.name }} - {{ contact.phone }}</li>
            </ul>
        </template>
    </div>
</template>

<script>
    
    import { merge } from 'lodash'
    import { mapState } from 'vuex'
    import Citeup from '../../citeup'
    import moment from 'moment-timezone'

    const states = mapState(['user', 'config'])

    export default {

        data() {
            return { contact_people: [] }
        },

        computed: merge(states, {
            mayContinue() {
                return this.user.elimination || 
                    (this.config &&
                        moment().diff(moment(this.config.warming.start)) >= 0 && 
                        moment().diff(moment(this.config.warming.finish)) < 0)
            },
            continueLink() {
                switch (this.user.entry.activity.id) {
                    case 1:
                        return Citeup.appPath + '/elimination/'
                    case 2:
                        return Citeup.appPath + '/submission/'
                }
            },
        }),

        created() {
            if (this.mayContinue) {
                window.location.replace(this.continueLink)
            }

            this.getContactPeople()
        },

        methods: {
            getContactPeople() {
                Citeup.get('/contact-people').then(
                    response => this.contact_people = response.data.data.contact_people
                )
            },
        }
    }

</script>