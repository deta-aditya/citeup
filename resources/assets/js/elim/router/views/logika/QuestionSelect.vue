
<template>
    <div id="question-select">
        <message-box ref="finishBox" name="finish-box" class="text-center" :headerless="true">
            <h2 class="finish-box-title">Yakin Selesai?</h2>
            <p class="finish-box-subtitle">Waktu tersisa sebanyak 54 menit lagi.</p>
            <p>Silahkan periksa ulang pekerjaan Anda. Perlu diingat bahwa Anda tidak akan dapat menjawab soal apapun setelah menekan tombol selesai!</p>
            <div slot="buttons" class="text-right">
                <button type="button" class="btn btn-default" data-dismiss="modal">Periksa Kembali</button>
                <button type="button" class="btn btn-primary" @click="finish">Selesai</button>
            </div>
        </message-box>
        <div class="greeting-text">{{ finished ? 'Pilih Soal' : 'Pilih Soal yang Akan Dikerjakan' }} </div>
        <div class="question-answered">
            <template v-if="! finished">Anda telah menjawab 19 dari 50 soal.</template>
            <template v-else>Anda menyelesaikan seleksi pada 10:59:59.</template>
        </div>
        <div class="row question-list">
            <div class="col-sm-1 question-item-placeholder" v-for="number in 50">
                <router-link :to="{ name: 'QuestionView', params: { id: number }}" class="question-item">{{ number }}</router-link>
            </div>
        </div>
        <div class="text-center">
            <button type="button" class="btn btn-lg btn-primary btn-done" @click="openFinishBox" v-if="! finished">Selesai</button>
            <router-link :to="{ name: 'Root' }" type="button" class="btn btn-lg btn-default btn-done" v-else>Kembali</router-link>
        </div>
    </div>
</template>

<script>

    import _ from 'lodash'
    import { mapGetters, mapActions } from 'vuex'
    import MessageBox from '../../../../components/kits/MessageBox.vue'

    const GETTERS_STAGE = ['finished']
    const ACTIONS_STAGE = ['toFinish']

    export default {
        data() {
            return {}
        },
        computed: _.merge(mapGetters('stage', GETTERS_STAGE)),
        methods: _.merge(mapActions('stage', ACTIONS_STAGE), {
            openFinishBox() {
                this.$refs.finishBox.open()
            },
            finish() {
                this.$refs.finishBox.close()
                this.toFinish()
            },
        }),
        components: {
            'message-box': MessageBox,
        }
    }

</script>
