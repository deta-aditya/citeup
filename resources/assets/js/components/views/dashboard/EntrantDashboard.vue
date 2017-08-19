
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
                        <router-link :to="{ name: 'Profil' }">Profil</router-link> &middot;
                        <router-link :to="{ name: 'Logout' }">Logout</router-link>
                    </div>
                    <h1 class="page-title">Selamat Datang {{ user.name }}!</h1>
                </div>
            </div>
        </div>

        <div class="row">
            
            <div class="col-sm-4">
                <div :class="{'form-panel': true, 'trackdown-box': true, 'trackdown-current': ! documentFinished, 'trackdown-completed': documentFinished}">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <i class="fa fa-folder trackdown-icon"></i>
                            <div class="trackdown-title">#1 Kelengkapan Dokumen</div>
                            <div class="trackdown-number">{{ numberOfSubmittedDocuments }} / {{ numberOfPossibleDocuments }}</div>
                            <div class="trackdown-standout">
                                {{ documentFinished ? 'Anda Telah Melengkapi Dokumen.' : 'Segera Lengkapi Dokumen Anda!' }}
                            </div>
                            <div class="text-right">
                                <router-link class="btn btn-link" :to="{ name: 'Dokumen' }">{{ documentFinished ? 'Lihat' : 'Lengkapi' }}</router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-sm-4">
                <div :class="{'form-panel': true, 'trackdown-box': true, 'trackdown-current': documentFinished && ! hasDoneSelection, 'trackdown-completed': hasDoneSelection}"  v-if="user.entry.activity.id !== 3">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <i class="fa fa-map-signs trackdown-icon"></i>
                            <div class="trackdown-title">#2 TAHAP SELEKSI</div>
                            <div class="trackdown-number">{{ stageGetter[$options.STAGE_ELIMINATION].started_at | fromNow }} Hari Lagi</div>
                            <div class="trackdown-standout">
                                {{ documentFinished ? 'Persiapkan Diri Anda!' : 'Silahkan Selesaikan Tahap Sebelumnya.' }}
                            </div>
                            <div class="text-right">
                                <router-link class="btn btn-link" :to="{ name: 'Acara.Lihat', params: { id: user.entry.activity.id }}">Detail Acara</router-link>
                            </div>
                        </div>
                    </div>
                </div>
                <div :class="{'form-panel': true, 'trackdown-box': true, 'trackdown-current': documentFinished && ! postEvent, 'trackdown-completed': postEvent }" v-else>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <i class="fa fa-microphone trackdown-icon"></i>
                            <div class="trackdown-title">#2 ACARA SEMINAR</div>
                            <div class="trackdown-number">{{ stageGetter[$options.STAGE_FINAL].started_at | fromNow }} Hari Lagi</div>
                            <div class="trackdown-standout">
                                {{ documentFinished ? 'Persiapkan Diri Anda!' : 'Silahkan Selesaikan Tahap Sebelumnya.' }}
                            </div>
                            <div class="text-right">
                                <router-link class="btn btn-link" :to="{ name: 'Acara.Lihat', params: { id: user.entry.activity.id }}">Detail Acara</router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-sm-4">
                <div :class="{'form-panel': true, 'trackdown-box': true, 'trackdown-current': postEvent && ! hasTestimonial, 'trackdown-completed': hasTestimonial }">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <i class="fa fa-star trackdown-icon"></i>
                            <div class="trackdown-title">#3 TESTIMONI ACARA</div>
                            <div class="trackdown-number">0 / 5</div>
                            <div class="trackdown-standout">
                                {{ postEvent ? 'Bagaimana Acara CITE UP Ini?' : 'Silahkan Selesaikan Tahap Sebelumnya.' }}
                            </div>
                            <div class="text-right">
                                <button class="btn btn-link disabled">Isi Testimoni</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-sm-8">
                <div class="form-panel switch-tab">
                    <div class="panel panel-default">
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
                                    <div class="media" v-for="item in faqs">
                                        <div class="media-body">
                                            <h4 class="media-heading">{{ item.question }}</h4>
                                            <div v-html="item.answer"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <data-panel ref="dataPanel" v-model="activity.schedules">
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
    import CurrentUser from '../../mixins/CurrentUser'
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
                related: [ { documents: [ {} ] } ],
                activity: { schedules: [] },
                news: [],
                faqs: [],
            }
        },

        computed: {
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

        methods: {
            getActivity(id) {
                getActivity(id).then(activity => this.activity = activity)
            },
            getRelatedEntrants(id) {
                getRelatedEntrants(id).then(related => this.related = related)
            },
            getNews(skip, take) {
                getNews(skip, take).then(news => this.news = news)
            },
            getFaqs(skip, take) {
                getFaqs(skip, take).then(faqs => this.faqs = faqs)
            },
            shortenPreview: shortenPreview,
        },

        components: {
            'countdown': Countdown,
            'data-panel': DataPanel,
            'data-panel-list-item': DataPanelListItem,
        },
    }

</script>
