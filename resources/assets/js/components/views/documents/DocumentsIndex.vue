
<template>
    <div class="documents-index">
        <message-box ref="documentView" name="document-view-box" size="lg" backdrop="static" :footerless="true">
            <template slot="title">Dokumen {{ documentView.name }}</template>
            <div class="row">
                <div :class="'col-sm-' + 12 / documentView.data.length" v-for="doc in documentView.data">
                    <p>{{ doc.type === 0 ? 'KTP ' + doc.user.name : 'Bukti Pembayaran' }}</p>
                    <div class="text-center">
                        <img :src="doc.file | assetify" :style="{ width: '100%' }">
                    </div>
                </div>
            </div>
        </message-box>
        <data-panel ref="dataPanel" v-model="entries">
            Daftar Dokumen
            <data-panel-addon slot="control">
                <radio-button name="activity" :list="activities" v-model="activity">
                    <template slot="list" scope="props">{{ props.data }}</template>
                </radio-button>
            </data-panel-addon>
            <template slot="list" scope="props">
                <data-panel-list-item :id="props.data.id" :controls="false" @click="viewDocument(props.data)">
                    <template slot="title">
                        <div class="pull-right">
                            <span v-if="complete(props.data.users)" class="text-primary">Peserta ini sudah melengkapi dokumennya.</span>
                            <template v-else>Peserta ini belum melengkapi dokumennya.</template>
                        </div>
                        {{ props.data.name }} <small>{{ props.data.activity.name }}</small>
                    </template>
                </data-panel-list-item>
            </template>
        </data-panel>
    </div>
</template>

<script>

    import _ from 'lodash'
    import moment from 'moment'
    import Citeup from '../../../citeup'
    import MessageBox from '../../kits/MessageBox.vue'
    import DataPanel from '../../kits/DataPanel/DataPanel.vue'
    import DataPanelAddon from '../../kits/DataPanel/Addon.vue'
    import DataPanelListItem from '../../kits/DataPanel/ListItem.vue'
    import RadioButton from '../../kits/FormPanel/RadioButton/UngroupedList.vue'

    const ACTIVITIES = {
        0: 'Semua',
        1: 'Lomba Logika',
        2: 'Lomba Desain',
        3: 'Seminar IT',
    }
    
    export default {

        data() {
            return {
                entries: [],
                activities: ACTIVITIES,
                activity: 0,
                documentView: {
                    box: null,
                    name: '',
                    data: [],
                },
            }
        },

        filters: {

            normalize(value) {
                return moment(value).format('DD MMM, HH:mm')
            },

            assetify(value) {
                return Citeup.appPath + '/' + value
            },

        },

        watch: {
            activity(newVal) {
                this.getEntries(newVal)
            },
        },

        created() {
            this.getEntries()
        },

        mounted() {
            this.prepareComponent()
        },

        methods: {

            getEntries(activity = 0) {

                let data = {}

                data.with = 'users.documents,activity'

                if (activity > 0) {
                    data.activity = activity
                }

                Citeup.get('/entries', data).then(
                    response => this.entries = response.data.data.entries
                )
            },

            prepareComponent() {
                this.dataPanel = this.$refs.dataPanel
                this.documentView.box = this.$refs.documentView
            },

            complete(users) {
                return this.reduceDocuments(users).filter(item => {
                    return item.file === Citeup.defaultImageClean
                }).length === 0
            },

            viewDocument(entry) {
                this.documentView.name = entry.name
                this.documentView.data = this.reduceDocuments(entry.users).map(item => {
                    return _.merge(item, { user: entry.users.find(subitem => subitem.id === item.user_id) })
                })

                this.documentView.box.open()
            },

            reduceDocuments(users) {
                return users.map(item => {
                    return item.documents
                }).reduce((total, item) => {
                    return total.concat(item)
                })
            },

        },

        components: {
            'data-panel': DataPanel,
            'message-box': MessageBox,
            'radio-button': RadioButton,
            'data-panel-addon': DataPanelAddon,
            'data-panel-list-item': DataPanelListItem,
        }

    }

</script>
