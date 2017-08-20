
<template>
    <div id="faqs-index">

        <data-panel ref="dataPanel" v-model="faqs" :expandable="true" :deletable="true">
            Daftar FAQ
            <data-panel-addon slot="control" :refresh="getFaqs" :create="{ name: 'FAQ.Buat' }"></data-panel-addon>
            <template slot="list" scope="props">
                <data-panel-list-item :id="props.data.id" :update="{ name: 'FAQ.Sunting', params: { id: props.data.id }}" :delete="'/faqs/' + props.data.id">
                    <template slot="title">
                        {{ props.data.question }}
                    </template>
                    <div v-html="props.data.answer"></div>
                    <p>
                        <small class="text-muted">
                            Dibuat pada {{ props.data.created_at | normalize }}. Terakhir disunting pada {{ props.data.updated_at | normalize }}
                        </small>
                    </p>
                </data-panel-list-item>
            </template>
            <template slot="delete-preview" scope="props">
                <div class="panel panel-default delete-preview">
                    <div class="panel-body">
                        <h4><small>#{{ props.data.id }}</small> {{ props.data.question }}</h4>
                        <div v-html="props.data.answer"></div>
                        <div><small class="text-muted">
                            Dibuat pada {{ props.data.created_at | normalize }}. Terakhir disunting pada {{ props.data.updated_at | normalize }}
                        </small></div>
                    </div>
                </div>
            </template>
        </data-panel>

    </div>
</template>

<script>

    import _ from 'lodash'
    import moment from 'moment'
    import FaqsMixin from './FaqsMixin'
    import Citeup from '../../../citeup'
    import DataPanel from '../../kits/DataPanel/DataPanel.vue'
    import DataPanelAddon from '../../kits/DataPanel/Addon.vue'
    import DataPanelListItem from '../../kits/DataPanel/ListItem.vue'

    export default {

        mixins: [FaqsMixin],

        data() {
            return {
                dataPanel: null,
                faqs: [],
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

        created() {
            this.getFaqs()
        },

        mounted() {
            this.prepareComponent()
        },

        methods: {

            getFaqs() {
                Citeup.get('/faqs', { 
                    take: 15 
                }).then(response => this.faqs = response.data.data.faqs)
            },

            prepareComponent() {
                this.dataPanel = this.$refs.dataPanel
            },

        },

        components: {
            'data-panel': DataPanel,
            'data-panel-addon': DataPanelAddon,
            'data-panel-list-item': DataPanelListItem,
        }

    }

</script>
