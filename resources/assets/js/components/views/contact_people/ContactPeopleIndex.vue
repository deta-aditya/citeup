
<template>
    <div id="contact-people-index">

        <data-panel ref="dataPanel" v-model="contact_people" :checkable="true" :expandable="true" :deletable="true">
            Daftar <i>Contact Person</i>
            <data-panel-addon slot="control" :refresh="getFaqs" :create="{ name: 'Contact Person.Buat' }"></data-panel-addon>
            <template slot="list" scope="props">
                <data-panel-list-item :id="props.data.id" :update="{ name: 'Contact Person.Sunting', params: { id: props.data.id }}" :delete="'/contact-people/' + props.data.id">
                    <template slot="title">
                        {{ props.data.name }} <small>{{ props.data.email }}</small>
                    </template>
                    <div>{{ props.data.phone }} | {{ props.data.line }}</div>
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
                        <h4><small>#{{ props.data.id }}</small> {{ props.data.name }} <small>{{ props.data.email }}</small></h4>
                        <div>{{ props.data.phone }} | LINE: {{ props.data.line }}</div>
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
    import Citeup from '../../../citeup'    
    import ContactPeopleMixin from './ContactPeopleMixin'
    import DataPanel from '../../kits/DataPanel/DataPanel.vue'
    import DataPanelAddon from '../../kits/DataPanel/Addon.vue'
    import DataPanelListItem from '../../kits/DataPanel/ListItem.vue'

    const STATES = [
        'user'
    ] 

    export default {

        mixins: [ContactPeopleMixin],

        data() {
            return {
                dataPanel: null,
                contact_people: [],
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
                Citeup.get('/contact-people', { 
                    take: 15 
                }).then(response => this.contact_people = response.data.data.contact_people)
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
