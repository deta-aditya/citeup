
<template>
    <div id="committees-index">
        <data-panel ref="dataPanel" v-model="users" :expandable="true" :deletable="true">
            Daftar Panitia
            <data-panel-addon slot="control" :refresh="getUsers" :create="{ name: 'Panitia.Buat' }"></data-panel-addon>
            <template slot="list" scope="props">
                <data-panel-list-item :id="props.data.id" :update="{ name: 'Panitia.Sunting', params: { id: props.data.id }}" :delete="'/users/' + props.data.id">
                    <template slot="title">
                        <img :src="props.data.photo | assetify" class="img-circle user-img">
                        {{ props.data.name }} <small>{{ props.data.section }}</small>
                    </template>
                    <p>
                        <small class="text-muted">
                            Terdaftar sejak {{ props.data.created_at | normalize }}.
                        </small>
                    </p>
                    <template slot="actions">
                        <li role="separator" class="divider"></li>
                        <router-link tag="li" :to="{ name: 'Panitia.Lihat', params: { id: props.data.id }}"><a>Lihat Detail</a></router-link>
                    </template>
                </data-panel-list-item>
            </template>
            <template slot="delete-preview" scope="props">
                <div class="panel panel-default delete-preview">
                    <div class="panel-body">
                        <h4><small>#{{ props.data.id }}</small> <img :src="props.data.photo | assetify" class="img-circle user-img"> {{ props.data.name }}</h4>
                        <div><small class="text-muted">
                            Terdaftar sejak {{ props.data.created_at | normalize }}.
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
    import AdminGuardMixin from '../../guards/AdminGuardMixin'
    import DataPanel from '../../kits/DataPanel/DataPanel.vue'
    import DataPanelAddon from '../../kits/DataPanel/Addon.vue'
    import DataPanelListItem from '../../kits/DataPanel/ListItem.vue'

    export default {

        mixins: [AdminGuardMixin],

        data() {
            return {
                users: [],
                dataPanel: null,
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
            this.getUsers()
        },

        mounted() {
            this.prepareComponent()
        },

        methods: {

            getUsers() {
                let data = { role: 3 } // Committee role

                Citeup.get('/users', data).then(
                    response => this.users = response.data.data.users
                )
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
