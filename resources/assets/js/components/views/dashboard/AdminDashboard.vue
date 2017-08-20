
<style lang="scss" scoped>
    
    .activity-icon {
        height: 150px;
        margin: 0 30px 30px 0;
    }

    .news-icon {
        padding-right: 10px;
        height: 75px;
    }

</style>

<template>
    <div class="admin-dashboard">

        <!-- Panel header -->
        <div class="form-panel">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="pull-right">
                        <router-link :to="{ name: 'Logout' }">Logout</router-link>
                    </div>
                    <h1 class="page-title">Selamat Datang {{ user.name }}!</h1>
                </div>
            </div>
        </div>

        <div class="row">
            
            <div class="col-sm-4">
                <trackdown-box :completed="lombaLogikaNumber >= lombaLogikaTarget" :icon="decideProgressClass(lombaLogikaNumber, lombaLogikaTarget)">
                    <template slot="title">Peserta Lomba Logika</template>
                    <template slot="number">{{ lombaLogikaNumber }} / {{ lombaLogikaTarget }}</template>
                    <template slot="standout">
                        {{ lombaLogikaNumber >= lombaLogikaTarget ? 'Sudah Mencapai Target!' : (lombaLogikaTarget - lombaLogikaNumber) + ' Peserta Lagi!' }}
                    </template>
                    <router-link slot="link" class="btn btn-link" :to="{ name: 'Peserta', props: { activity: 1 } }">Lihat</router-link>
                </trackdown-box>
            </div>
            
            <div class="col-sm-4">
                <trackdown-box :completed="lombaDesainNumber >= lombaDesainTarget" :icon="decideProgressClass(lombaDesainNumber, lombaDesainTarget)">
                    <template slot="title">Peserta Lomba Desain</template>
                    <template slot="number">{{ lombaDesainNumber }} / {{ lombaDesainTarget }}</template>
                    <template slot="standout">
                        {{ lombaDesainNumber >= lombaDesainTarget ? 'Sudah Mencapai Target!' : (lombaDesainTarget - lombaDesainNumber) + ' Peserta Lagi!' }}
                    </template>
                    <router-link slot="link" class="btn btn-link" :to="{ name: 'Peserta', props: { activity: 2 } }">Lihat</router-link>
                </trackdown-box>
            </div>
            
            <div class="col-sm-4">
                <trackdown-box :completed="seminarItNumber >= seminarItTarget" :icon="decideProgressClass(seminarItNumber, seminarItTarget)">
                    <template slot="title">Peserta Lomba Logika</template>
                    <template slot="number">{{ seminarItNumber }} / {{ seminarItTarget }}</template>
                    <template slot="standout">
                        {{ seminarItNumber >= seminarItTarget ? 'Sudah Mencapai Target!' : (seminarItTarget - seminarItNumber) + ' Peserta Lagi!' }}
                    </template>
                    <router-link slot="link" class="btn btn-link" :to="{ name: 'Peserta', props: { activity: 3 } }">Lihat</router-link>
                </trackdown-box>
            </div>

        </div>

        <div class="row">
            <div class="col-sm-8">
                <div class="form-panel">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <h2 class="page-title small-title">Navigasi Cepat</h2>
                        </div>
                        <div class="panel-body quick-nav">
                            <div class="row">
                                <router-link v-for="(icon, name, index) in quickNavs" :key="index" class="col-sm-2 quick-nav-item" :to="{ name: name }">
                                    <i :class="['fa', 'fa-' + icon, 'quick-nav-icon']"></i>
                                    <div class="quick-nav-title">{{ name }}</div>
                                </router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-panel">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <h2 class="page-title small-title">Pendaftaran Akan Ditutup Dalam:</h2>
                        </div>
                        <div class="panel-body text-center">
                            <countdown :done="registrationDone"></countdown>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>    
</template>

<script>

    import moment from 'moment'
    import Countdown from '../../misc/Countdown.vue'
    import CurrentUser from '../../mixins/CurrentUser'
    import TrackdownBox from '../../misc/TrackdownBox.vue'
    import { countOf } from '../../Citeup/Entrant/EntrantRepo'
    import ApplicationStages from '../../mixins/ApplicationStages'

    import { 
        assetify, formatDateComplete, 
    } from '../../Citeup/Helper'

    const QUICK_NAVS = {
        'Panitia': 'user-secret',
        'Peserta': 'user',
        'Dokumen': 'folder',
        'Acara': 'bullhorn',
        'FAQ': 'question-circle',
        'Berita': 'file-text',
        'Sponsor': 'handshake-o',
        'Contact Person': 'phone',
        'Konten': 'archive',
        'Konfigurasi': 'cogs',
    }    

    export default {

        mixins: [ApplicationStages, CurrentUser],

        data() {
            return {
                lombaLogikaNumber: 0,
                lombaLogikaTarget: 100,
                lombaDesainNumber: 0,
                lombaDesainTarget: 50,
                seminarItNumber: 0,
                seminarItTarget: 100,
                quickNavs: QUICK_NAVS,
            }
        },

        computed: {
            registrationDone() {
                return this.stageGetter[this.$options.STAGE_REGISTRATION].finished_at || moment().format('YYYY-MM-DD HH:mm:ss')
            }
        },

        filters: {
            fromNow(value) {
                return Math.floor(moment.duration(moment(value).diff(moment())).asDays())
            },
            formatDateComplete: formatDateComplete,
        },
        
        created() {
            this.getCountOfs()
        },

        methods: {
            getCountOfs() {
                countOf(1).then(count => this.lombaLogikaNumber = count)
                countOf(2).then(count => this.lombaDesainNumber = count)
                countOf(3).then(count => this.seminarItNumber = count)
            },
            decideProgressClass(number, target) {
                if (number / target >= 1) {
                    return 'battery-full'
                } else if (number / target >= 0.75) {
                    return 'battery-three-quarters'
                } else if (number / target >= 0.5) {
                    return 'battery-half'
                } else if (number / target >= 0.25) {
                    return 'battery-quarter'
                } else {
                    return 'battery-empty'
                }
            },
        },

        components: {
            'countdown': Countdown,
            'trackdown-box': TrackdownBox,
        },
    }

</script>
