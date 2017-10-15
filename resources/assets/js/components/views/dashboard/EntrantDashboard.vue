
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
    <div class="entrant-dashboard">

        <!-- Panel header -->
        <div class="form-panel">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="pull-right">
                        <template v-if="activity.guide"><a :href="activity.guide | assetify" target="_blank">Panduan</a> &middot;</template>
                        <router-link :to="{ name: 'Profil' }">Profil</router-link> &middot;
                        <router-link :to="{ name: 'Logout' }">Logout</router-link>
                    </div>
                    <h1 class="page-title">Selamat Datang {{ user.name }}!</h1>
                </div>
            </div>
        </div>

        <div class="row">
            
            <div class="col-sm-4">
                <trackdown-box :current="! (documentFinished || documentApproved)" :completed="documentFinished" icon="folder" ref="trackdownBoxDocument">
                    <template slot="title">#1 Kelengkapan Dokumen</template>
                    <template slot="number">{{ numberOfSubmittedDocuments }} / {{ numberOfPossibleDocuments }}</template>
                    <template slot="standout">
                        <template v-if="documentApproved">Dokumen Anda Telah Disetujui!</template>
                        <template v-else-if="documentFinished">Silahkan Tunggu Persetujuan Panitia.</template>
                        <template v-else>Segera Lengkapi Dokumen Anda!</template>
                    </template>
                    <router-link slot="link" class="btn btn-link" :to="{ name: 'Dokumen' }">{{ documentFinished ? 'Lihat' : 'Lengkapi' }}</router-link>
                </trackdown-box>
            </div>
            
            <div class="col-sm-4">
                <trackdown-box :current="documentApproved && ! hasDoneSelection" :completed="hasDoneSelection" icon="map-signs" v-if="user.entry.activity.id !== 3" ref="trackdownBoxSelection">
                    <template slot="title">#2 TAHAP SELEKSI</template>
                    <template slot="number">{{ stageGetter[$options.STAGE_ELIMINATION].started_at | fromNow }} Hari Lagi</template>
                    <template slot="standout">
                        {{ documentFinished ? 'Persiapkan Diri Anda!' : 'Silahkan Selesaikan Tahap Sebelumnya.' }}
                    </template>
                    <router-link slot="link" class="btn btn-link" :to="activityLink">{{ documentApproved ? 'Ke Halaman Seleksi' : 'Detail Acara' }}</router-link>
                </trackdown-box>
                <trackdown-box :current="documentFinished && ! postEvent" :completed="postEvent" icon="microphone" v-else ref="trackdownBoxSelection">
                    <template slot="title">#2 ACARA SEMINAR</template>
                    <template slot="number">{{ stageGetter[$options.STAGE_FINAL].started_at | fromNow }} Hari Lagi</template>
                    <template slot="standout">
                        {{ documentFinished ? 'Persiapkan Diri Anda!' : 'Silahkan Selesaikan Tahap Sebelumnya.' }}
                    </template>
                    <router-link slot="link" class="btn btn-link" :to="{ name: 'Acara.Lihat', params: { id: user.entry.activity.id }}">Detail Acara</router-link>
                </trackdown-box>
            </div>
            
            <div class="col-sm-4">
                <trackdown-box :current="postEvent && ! hasTestimonial" :completed="hasTestimonial" icon="star">
                    <template slot="title">#3 TESTIMONI ACARA</template>
                    <template slot="number">0 / 5</template>
                    <template slot="standout">
                        {{ postEvent ? 'Bagaimana Acara CITE UP Ini?' : 'Silahkan Selesaikan Tahap Sebelumnya.' }}
                    </template>
                    <button slot="link" class="btn btn-link disabled">Isi Testimoni</button>
                </trackdown-box>
            </div>

        </div>

        <div class="row">
            <div class="col-sm-8">
                <cloaked-panel class="switch-tab" ref="switchTab">
                    <div class="panel-body nav-wrapper">
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#activity" aria-controls="activity" role="tab" data-toggle="tab">Acara</a></li>
                            <li role="presentation"><a href="#news" aria-controls="news" role="tab" data-toggle="tab">Berita</a></li>
                            <li role="presentation"><a href="#faqs" aria-controls="faqs" role="tab" data-toggle="tab">FAQ</a></li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="activity">
                            <div class="panel-body limited-height">
                                <img :src="activity.icon | assetify" class="pull-left img-rounded activity-icon">
                                <p class="lead">{{ activity.short_description }}</p>
                                <div v-html="activity.description"></div>
                                <table class="table" v-if="activity.id !== 3">
                                    <tbody>
                                        <tr>
                                            <th>Hadiah Juara 1</th><td>Rp{{ activity.prize_first | monetize }}</td>
                                        </tr>
                                        <tr>
                                            <th>Hadiah Juara 2</th><td>Rp{{ activity.prize_second | monetize }}</td>
                                        </tr>
                                        <tr>
                                            <th>Hadiah Juara 3</th><td>Rp{{ activity.prize_third | monetize }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="news">
                            <div class="panel-body limited-height">
                                <div class="text-center" v-if="news.length === 0">Tidak Ada Berita</div>
                                <div class="media" v-for="item in news">
                                    <div class="media-left">
                                        <img class="media-object news-icon" :src="item.picture | assetify">
                                    </div>
                                    <div class="media-body">
                                        <h4 class="media-heading">
                                            <router-link :to="{ name: 'Berita.Lihat', params: { id: item.id }}">{{ item.title }}</router-link>
                                        </h4>
                                        <div v-html="shortenPreview(item.content)"></div>
                                        <div class="help-block">Diposting pada {{ item.created_at | formatDateShort }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="faqs">
                            <div class="panel-body limited-height">
                                <div class="text-center" v-if="faqs.length === 0">Tidak Ada FAQs</div>
                                <div class="media" v-for="item in faqs">
                                    <div class="media-body">
                                        <h4 class="media-heading">{{ item.question }}</h4>
                                        <div v-html="item.answer"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </cloaked-panel>
            </div>
            <div class="col-sm-4">
                <data-panel v-model="activity.schedules" ref="dataPanelSchedules">
                    Jadwal Acara
                    <template slot="list" scope="props">
                        <data-panel-list-item :id="props.data.id" size="small" :show-id="false" :controls="false">
                            <template slot="title">{{ props.data.description }}</template>
                            <p>{{ props.data.held_at | formatDateComplete }}</p>
                        </data-panel-list-item>
                    </template>
                </data-panel>
            </div>
        </div>
    </div>    
</template>

<script>

    import moment from 'moment'
    import Countdown from '../../misc/Countdown.vue'
    import CloakedPanel from '../../misc/CloakedPanel'
    import CurrentUser from '../../mixins/CurrentUser'
    import TrackdownBox from '../../misc/TrackdownBox.vue'
    import DataPanel from '../../kits/DataPanel/DataPanel.vue'
    import DocumentsChecker from '../../mixins/DocumentsChecker'
    import ApplicationStages from '../../mixins/ApplicationStages'
    import DataPanelListItem from '../../kits/DataPanel/ListItem.vue'
    import { getRelatedEntrants } from '../../Citeup/Entrant/EntrantRepo'
    import { listInfiniteScroll as getFaqs } from '../../Citeup/Faq/FaqRepo'
    import { listInfiniteScroll as getNews } from '../../Citeup/News/NewsRepo'
    import { findById as getActivity } from '../../Citeup/Activity/ActivityRepo'

    import { 
        monetize, assetify, formatDateComplete, 
        formatDateShort, shortenPreview 
    } from '../../Citeup/Helper'

    export default {

        mixins: [ApplicationStages, CurrentUser, DocumentsChecker],

        data() {
            return {
                elements: {
                    switchTab: null,
                    trackdownBoxDocument: null,
                    trackdownBoxSelection: null,
                    dataPanelSchedules: null,
                },
                related: [ { documents: [] } ],
                activity: { id: 0, schedules: [] },
                news: [],
                faqs: [],
                hasDoneLoading: {
                    activity: false,
                    news: false,
                    faqs: false,
                }
            }
        },

        computed: {
            documentApproved() {
                return this.user.entry.stage === 1
            },
            documentFinished() {
                return this.documentsComplete(this.related)
            },
            numberOfPossibleDocuments() {
                return this.possibleDocuments(this.user.entry.activity.id)
            },
            numberOfSubmittedDocuments() {
                return this.submittedDocuments(this.related)
            },
            hasDoneSelection() {
                return false // to do
            },
            postEvent() {
                return moment().diff(moment(this.stageGetter[this.$options.STAGE_POST_EVENT]).started_at) >= 0
            },
            hasTestimonial() {
                return false // to do 
            },
            activityLink() {
                return this.documentApproved ? 
                    { name: 'Seleksi' } :
                    { name: 'Acara.Lihat', params: { id: user.entry.activity.id }}
            },
        },

        watch: {
            stageGetter(newVal) {
                this.elements.trackdownBoxSelection.cloaking = false
            },
            numberOfSubmittedDocuments(related) {
                this.elements.trackdownBoxDocument.cloaking = false
            }
        },

        filters: {
            fromNow(value) {
                return Math.floor(moment.duration(moment(value).diff(moment())).asDays())
            },
            monetize: monetize,
            assetify: assetify,
            formatDateShort: formatDateShort,
            formatDateComplete: formatDateComplete,
        },
        
        created() {
            this.getRelatedEntrants(this.user.entry.id)
            this.getActivity(this.user.entry.activity.id)
            this.getNews(0, 10)
            this.getFaqs(0, 100)
        },

        mounted() {
            this.elements.switchTab = this.$refs.switchTab
            this.elements.trackdownBoxDocument = this.$refs.trackdownBoxDocument
            this.elements.trackdownBoxSelection = this.$refs.trackdownBoxSelection
            this.elements.dataPanelSchedules = this.$refs.dataPanelSchedules

            this.elements.switchTab.cloaking = true
            this.elements.trackdownBoxDocument.cloaking = true
            this.elements.dataPanelSchedules.cloaking = true

            this.elements.trackdownBoxSelection.cloaking = this.stages.length === 0
        },

        methods: {
            getActivity(id) {
                getActivity(id).then(activity => {
                    this.activity = activity
                    this.hasDoneLoading.activity = true
                    this.elements.switchTab.cloaking = ! this.switchTabCompleted()
                    this.elements.dataPanelSchedules.cloaking = false
                })
            },
            getRelatedEntrants(id) {
                getRelatedEntrants(id).then(related => this.related = related)
            },
            getNews(skip, take) {
                getNews(skip, take).then(news => {
                    this.news = news 
                    this.hasDoneLoading.news = true
                    this.elements.switchTab.cloaking = ! this.switchTabCompleted()
                })
            },
            getFaqs(skip, take) {
                getFaqs(skip, take).then(faqs => {
                    this.faqs = faqs
                    this.hasDoneLoading.faqs = true
                    this.elements.switchTab.cloaking = ! this.switchTabCompleted()
                })
            },
            switchTabCompleted() {
                return this.hasDoneLoading.activity && this.hasDoneLoading.news && this.hasDoneLoading.faqs
            },
            shortenPreview: shortenPreview,
        },

        components: {
            'countdown': Countdown,
            'data-panel': DataPanel,
            'trackdown-box': TrackdownBox,
            'cloaked-panel': CloakedPanel,
            'data-panel-list-item': DataPanelListItem,
        },
    }

</script>
