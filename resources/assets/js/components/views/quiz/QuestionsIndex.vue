
<template>
    <div id="questions-index">

        <data-panel ref="dataPanel" v-model="questions" :expandable="true" :deletable="true">
            Daftar Pertanyaan Quiz
            <data-panel-addon slot="control" :refresh="getQuestions" :create="{ name: 'Pertanyaan Quiz.Buat' }"></data-panel-addon>
            <template slot="list" scope="props">
                <data-panel-list-item :id="props.data.id" :update="{ name: 'Pertanyaan Quiz.Sunting', params: { id: props.data.id }}" :delete="'/questions/' + props.data.id">
                    <template slot="title">
                        <span v-html="shorten(props.data.content)"></span>
                    </template>
                    <p>
                        <small class="text-muted">
                            Dibuat pada {{ props.data.created_at | normalize }}. Terakhir disunting pada {{ props.data.updated_at | normalize }}
                        </small>
                    </p>
                    <template slot="actions">
                        <li role="separator" class="divider"></li>
                        <router-link tag="li" :to="{ name: 'Pertanyaan Quiz.Lihat', params: { id: props.data.id }}"><a>Lihat Detail</a></router-link>
                    </template>
                </data-panel-list-item>
            </template>
            <template slot="delete-preview" scope="props">
                <div class="panel panel-default delete-preview">
                    <div class="panel-body">
                        <h4><small>#{{ props.data.id }}</small> <span v-html="shorten(props.data.content)"></span></h4>
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
    import moment from 'moment-timezone'
    import Citeup from '../../../citeup'    
    import QuestionsMixin from './QuestionsMixin'
    import DataPanel from '../../kits/DataPanel/DataPanel.vue'
    import DataPanelAddon from '../../kits/DataPanel/Addon.vue'
    import DataPanelListItem from '../../kits/DataPanel/ListItem.vue'

    export default {

        mixins: [QuestionsMixin],

        data() {
            return {
                dataPanel: null,
                questions: [],
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
            this.getQuestions()
        },

        mounted() {
            this.prepareComponent()
        },

        methods: {

            getQuestions() {
                Citeup.get('/questions', { 
                    take: 999
                }).then(response => this.questions = response.data.data.questions)
            },

            prepareComponent() {
                this.dataPanel = this.$refs.dataPanel
            },

            shorten(value) {
                if (value !== undefined && value.length > 100) {
                    return value.substring(0, 99) + '...'
                }

                return value
            },

        },

        components: {
            'data-panel': DataPanel,
            'data-panel-addon': DataPanelAddon,
            'data-panel-list-item': DataPanelListItem,
        }

    }

</script>
