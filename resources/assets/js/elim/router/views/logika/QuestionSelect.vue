
<template>
    <div id="question-select">
        <message-box ref="finishBox" name="finish-box" size="lg" class="text-center">
            <h2 class="box-title">Yakin Selesai?</h2>
            <p class="box-subtitle">Waktu tersisa sebanyak 54 menit lagi.</p>
            <p>Silahkan periksa ulang pekerjaan Anda. Perlu diingat Anda tidak dapat menjawab soal apapun setelah menekan tombol selesai!</p>
            <div slot="buttons" class="text-right">
                <button type="button" class="btn btn-default" data-dismiss="modal">Periksa Kembali</button>
                <button type="button" class="btn btn-primary">Selesai</button>
            </div>
        </message-box>
        <div class="greeting-text">Pilih Soal yang Akan Dikerjakan</div>
        <div class="question-answered">Anda telah menjawab 19 dari 50 soal.</div>
        <div class="row question-list">
            <div class="col-sm-1 question-item-placeholder" v-for="number in 50">
                <router-link :to="{ name: 'QuestionView', params: { id: number }}" class="question-item">{{ number }}</router-link>
            </div>
        </div>
        <div class="text-center">
            <button type="button" class="btn btn-lg btn-primary btn-done">Selesai</button>
        </div>
    </div>
</template>

<script>

    import MessageBox from '../../../../components/kits/MessageBox.vue'

    export default {
        data() {
            return {}
        },
        mounted() {
            // this.finishBox = this.$refs.finishBox
        },
        components: {
            'message-box': MessageBox,
        }
    }

</script>
