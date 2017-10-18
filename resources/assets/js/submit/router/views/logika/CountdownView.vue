
<template>
    <div id="countdown-view">
        <div class="greeting-text">Halo {{ user.entry.name }}. Sudah Siapkah Anda?</div>
        <div class="row">
            <div class="col-sm-6">
                <h2 class="view-title">Peraturan</h2>
                <div class="super-list">
                    <div class="super-list-item">
                        <div class="super-list-number">
                            <span>1</span>
                        </div>
                        <div class="super-list-content">
                            Babak penyisihan dilakukan secara online pada 21 Oktober 2017 pukul 09:00 WIB hingga 11:00 WIB.
                        </div>
                    </div>
                    <div class="super-list-item">
                        <div class="super-list-number">
                            <span>2</span>
                        </div>
                        <div class="super-list-content">
                            Peserta diharuskan untuk mengakses halaman ini beberapa menit sebelum seleksi dimulai.
                        </div>
                    </div>
                    <div class="super-list-item">
                        <div class="super-list-number">
                            <span>3</span>
                        </div>
                        <div class="super-list-content">
                            Peserta diharuskan untuk terkoneksi pada jaringan internet cepat agar tidak terputus pada rentang waktu tersebut. Apabila koneksi peserta terputus, peserta dapat mengakses kembali halaman ini dan melanjutkan tahap penyisihan tanpa diberikan tambahan waktu.
                        </div>
                    </div>
                    <div class="super-list-item">
                        <div class="super-list-number">
                            <span>4</span>
                        </div>
                        <div class="super-list-content">
                            Panitia memiliki hak untuk mendiskualifikasi peserta yang terindikasi melakukan pelanggaran.
                        </div>
                    </div>
                    <div class="super-list-item">
                        <div class="super-list-number">
                            <span>5</span>
                        </div>
                        <div class="super-list-content">
                            Peserta dapat menekan tombol “Selesai” atau menunggu hingga waktu selesai untuk mengakhiri seleksi.
                        </div>
                    </div>
                    <div class="super-list-item">
                        <div class="super-list-number">
                            <span>6</span>
                        </div>
                        <div class="super-list-content">
                            Peserta tidak diharuskan untuk mengisi semua soal untuk menyelesaikan tahap seleksi. Namun, diharapkan setiap peserta untuk mengisi semua soal yang tersedia sebelum waktu habis.
                        </div>
                    </div>
                    <div class="super-list-item">
                        <div class="super-list-number">
                            <span>7</span>
                        </div>
                        <div class="super-list-content">
                            Peserta akan diberikan sebanyak 50 soal logika berbentuk pilihan ganda.
                        </div>
                    </div>
                    <div class="super-list-item">
                        <div class="super-list-number">
                            <span>8</span>
                        </div>
                        <div class="super-list-content">
                            Segala jenis aktifitas peserta seperti memilih soal, memilih jawaban, dan menyelesaikan seleksi terekam oleh panitia.
                        </div>
                    </div>
                    <div class="super-list-item">
                        <div class="super-list-number">
                            <span>9</span>
                        </div>
                        <div class="super-list-content">
                            Peserta yang bertanya kepada panitia diharuskan untuk menuliskan pertanyaannya dengan singkat dan jelas. 
                        </div>
                    </div>
                    <div class="super-list-item">
                        <div class="super-list-number">
                            <span>10</span>
                        </div>
                        <div class="super-list-content">
                            Peserta diperbolehkan untuk mengakses kembali soal-soal dan melihat jawabannya masing-masing setelah selesai melaksanakan tahap seleksi. 
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <h2 class="view-title">Panduan</h2>
                <div class="super-list">
                    <div class="super-list-item">
                        <div class="super-list-number">
                            <span>1</span>
                        </div>
                        <div class="super-list-content">
                            Klik pada tombol yang bertuliskan nomor soal untuk membukanya.
                            <div><img :src="'images/web/guide1.png' | assetify" class="img-rounded" :style="{ width: '100%' }"></div>
                        </div>
                    </div>
                    <div class="super-list-item">
                        <div class="super-list-number">
                            <span>2</span>
                        </div>
                        <div class="super-list-content">
                            Untuk menjawab soal, klik pada pilihan yang tersedia.
                            <div><img :src="'images/web/guide2.png' | assetify" class="img-rounded" :style="{ width: '100%' }"></div>
                        </div>
                    </div>
                    <div class="super-list-item">
                        <div class="super-list-number">
                            <span>3</span>
                        </div>
                        <div class="super-list-content">
                            Kerjakan semua soal sebelum waktu yang tersedia habis!
                            <div><img :src="'images/web/guide3.png' | assetify" class="img-rounded" :style="{ width: '100%' }"></div>
                        </div>
                    </div>
                    <div class="super-list-item">
                        <div class="super-list-number">
                            <span>4</span>
                        </div>
                        <div class="super-list-content">
                            Sudah yakin dengan jawaban-jawaban Anda? Klik tombol selesai, lalu konfirmasi dengan mengklik tombol selesai pada jendela.
                            <div><img :src="'images/web/guide4.png' | assetify" class="img-rounded" :style="{ width: '100%' }"></div>
                        </div>
                    </div>
                    <div class="super-list-item">
                        <div class="super-list-number">
                            <span>5</span>
                        </div>
                        <div class="super-list-content">
                            Kebingungan? Tanyakan kejelasan kepada panitia dengan mengklik tombol "Tanya Panitia", lalu ketik pertanyaan Anda.
                            <div><img :src="'images/web/guide5.png' | assetify" class="img-rounded" :style="{ width: '100%' }"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center" v-if="isWarmingUp">`
            <button type="button" class="btn btn-lg btn-primary btn-done" @click="warmUp">Uji Coba</button>
        </div>
    </div>
</template>

<script>

    import _ from 'lodash'
    import moment from 'moment-timezone'
    import { mapState, mapMutations } from 'vuex'
    import Citeup from '../../../../citeup'
    import { assetify } from '../../../../components/Citeup/Helper'

    const STATE_USER = {'user': 'data'}
    const MUTATIONS_STAGE = {
        'setStatus': 'STAGE_SET_STATUS',
        'setTimebarInfo': 'STAGE_SET_TIMEBAR_INFO',
    }

    export default {
        data() {
            return {
                warming: {}
            }
        },
        computed: _.merge(mapState('user', STATE_USER), {
            defaultImage() {
                return Citeup.defaultImage
            },
            isWarmingUp() {
                return moment().diff(moment(this.warming.start)) >= 0 
                    && moment().diff(moment(this.warming.finish)) < 0
            },
        }),
        filters: {
            assetify,
        },
        created() {
            Citeup.get('/config').then(response => {
                this.warming = response.data.data.config.warming
            })
        },
        methods: _.merge(mapMutations('stage', MUTATIONS_STAGE), {
            warmUp() {
                this.setStatus({ status: 1 })
                this.setTimebarInfo({ 
                    start: this.warming.start, 
                    finish: this.warming.finish,
                })
            },
        }),
    }

</script>