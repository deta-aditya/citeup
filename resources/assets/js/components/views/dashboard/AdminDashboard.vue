
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
                <div :class="{'form-panel': true, 'trackdown-box': true, 'trackdown-completed': lombaLogikaNumber >= lombaLogikaTarget}">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <i :class="['fa', decideProgressClass(lombaLogikaNumber, lombaLogikaTarget), 'trackdown-icon']"></i>
                            <div class="trackdown-title">Peserta Lomba Logika</div>
                            <div class="trackdown-number">{{ lombaLogikaNumber }} / {{ lombaLogikaTarget }}</div>
                            <div class="trackdown-standout">
                                {{ lombaLogikaNumber >= lombaLogikaTarget ? 'Sudah Mencapai Target!' : (lombaLogikaTarget - lombaLogikaNumber) + ' Peserta Lagi!' }}
                            </div>
                            <div class="text-right">
                                <router-link class="btn btn-link" :to="{ name: 'Peserta', props: { activity: 1 } }">Lihat</router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-sm-4">
                <div :class="{'form-panel': true, 'trackdown-box': true, 'trackdown-completed': lombaDesainNumber >= lombaDesainTarget}">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <i :class="['fa', decideProgressClass(lombaDesainNumber, lombaDesainTarget), 'trackdown-icon']"></i>
                            <div class="trackdown-title">Peserta Lomba Desain</div>
                            <div class="trackdown-number">{{ lombaDesainNumber }} / {{ lombaDesainTarget }}</div>
                            <div class="trackdown-standout">
                                {{ lombaDesainNumber >= lombaDesainTarget ? 'Sudah Mencapai Target!' : (lombaDesainTarget - lombaDesainNumber) + ' Peserta Lagi!' }}
                            </div>
                            <div class="text-right">
                                <router-link class="btn btn-link" :to="{ name: 'Peserta', props: { activity: 2 } }">Lihat</router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-sm-4">
                <div :class="{'form-panel': true, 'trackdown-box': true, 'trackdown-completed': seminarItNumber >= seminarItTarget}">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <i :class="['fa', decideProgressClass(seminarItNumber, seminarItTarget), 'trackdown-icon']"></i>
                            <div class="trackdown-title">Peserta Seminar IT</div>
                            <div class="trackdown-number">{{ seminarItNumber }} / {{ seminarItTarget }}</div>
                            <div class="trackdown-standout">
                                {{ seminarItNumber >= seminarItTarget ? 'Sudah Mencapai Target!' : (seminarItTarget - seminarItNumber) + ' Peserta Lagi!' }}
                            </div>
                            <div class="text-right">
                                <router-link class="btn btn-link" :to="{ name: 'Peserta', props: { activity: 3 } }">Lihat</router-link>
                            </div>
                        </div>
                    </div>
                </div>
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
                            <countdown :done="stageGetter[$options.STAGE_REGISTRATION].finished_at"></countdown>
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
            //
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
                    return 'fa-battery-full'
                } else if (number / target >= 0.75) {
                    return 'fa-battery-three-quarters'
                } else if (number / target >= 0.5) {
                    return 'fa-battery-half'
                } else if (number / target >= 0.25) {
                    return 'fa-battery-quarter'
                } else {
                    return 'fa-battery-empty'
                }
            },
        },

        components: {
            'countdown': Countdown,
        },
    }

</script>
