
<style lang="scss" scoped>
    
    .user-photo {
        height: 150px;
    }

    .context {
        font-size: 16pt;
        font-weight: 300;
    }

    .panel-foot {
        border-top: 1px solid #ddd;
    }

    .fa-minus {
        color: #fff;
    }

</style>

<template>
    <div id="documents-view">
        <div class="form-panel">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="pull-right">
                        <router-link class="btn btn-default" :to="{ name: 'Peserta.Lihat', params: { id: id } }">Detail Peserta</router-link>
                        <button type="button" class="btn btn-primary" v-if="completed && ! approved" @click="approve(id)">Setujui</button>
                    </div>
                    <h1 class="page-title">Dokumen {{ entry.name }} <small>Peserta {{ entry.activity.name }} / #{{ id }} / Dokumen</small></h1>
                </div>
                <div class="panel-body text-center" :style="{ fontSize: '14pt' }">
                    <template v-if="approved">Dokumen peserta ini sudah disetujui.</template>
                    <template v-else>{{ completed ? 'Peserta ini sudah melengkapi dokumennya.' : 'Peserta ini belum melengkapi dokumennya.' }}</template>
                </div>
                <div class="row gutterless">
                    <div :class="'col-sm-' + 12 / documents.length" v-for="(doc, index) in documents">
                        <div class="panel-body text-center">
                            <p class="lead" style="margin:0">{{ doc.type === 0 ? 'KTP ' + doc.user.name : 'Bukti Pembayaran' }}</p>
                        </div>      
                        <div class="panel-body text-center">
                            <img :src="doc.file | assetify" :style="{ width: '100%' }">
                        </div>      
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import _ from 'lodash'
    import moment from 'moment'
    import Citeup from '../../../citeup'
    import DocumentsMixin from './DocumentsMixin'
    import FormPanel from '../../kits/FormPanel/FormPanel.vue'
    import DocumentsChecker from '../../mixins/DocumentsChecker'

    export default {

        mixins: [DocumentsMixin, DocumentsChecker],

        props: {

            id: {
                type: [Number, String],
                required: true
            }

        },

        data() {
            return {
                formPanel: null,
                entry: { activity: {} },
                documents: [],
            }
        },

        computed: {
            completed() {
                return this.documents.filter(item => {
                    return item.file === Citeup.defaultImageClean
                }).length === 0
            },
            approved() {
                return this.entry.stage === 1
            }
        },

        filters: {

            normalize(value, format = 'DD MMM, HH:mm') {
                return moment(value).format(format)
            },

            assetify(value) {
                return Citeup.appPath + '/' + value
            },

        },

        created() {
            this.getDocuments(this.id)
            this.getEntries(this.id)
        },

        mounted() {
            this.prepareComponent()
        },

        methods: {

            prepareComponent() {
                //
            },

            getEntries(id) {
                Citeup.get('/entries/' + id).then(response => {
                    this.entry = response.data.data.entry
                })
            },

            getDocuments(entryId) {
                Citeup.get('/documents', { entry: entryId, with: 'user', }).then(response => {
                    this.documents = response.data.data.documents
                })
            },

            approve(id) {
                Citeup.post('/entrants/' + id + '/approve').then(response => {
                    this.$router.push({ name: 'Peserta' })
                })
            },

        },

        components: {
            'form-panel': FormPanel,
        }

    }

</script>
