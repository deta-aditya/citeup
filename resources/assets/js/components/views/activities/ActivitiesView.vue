
<style lang="scss" scoped>
    
    .activity-icon {
        height: 150px;
        margin: 0 30px 30px 0;
    }

</style>

<template>
    <div id="activities-view">
        <div class="form-panel">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="pull-right">
                        <router-link class="btn btn-default" :to="{ name: 'Acara' }">Indeks</router-link>
                        <router-link class="btn btn-default" :to="{ name: 'Acara.Sunting', params: { id: id }}">Sunting</router-link>
                    </div>
                    <h1 class="page-title">{{ activity.name }} <small>Acara / #{{ id }}</small></h1>
                </div>
                <div class="panel-body">
                    <img :src="activity.icon | assetify" class="pull-left img-circle activity-icon">
                    <p class="lead">{{ activity.short_description }}</p>
                    <div v-html="activity.description"></div>
                </div>
                <div class="panel-body">
                    Dibuat pada {{ activity.created_at | normalize }}, terakhir disunting pada {{ activity.updated_at | normalize }}
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import moment from 'moment'
    import Citeup from '../../../citeup'
    import FormPanel from '../../kits/FormPanel/FormPanel.vue'

    export default {

        props: {

            id: {
                type: [Number, String],
                required: true
            }

        },

        data() {
            return {
                formPanel: null,
                activity: {},
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
            this.getActivity()
        },

        mounted() {
            this.prepareComponent()
        },

        methods: {

            getActivity() {
                Citeup.get('/activities/' + this.id).then(response => {
                    this.activity = response.data.data.activity
                    console.log(response.data.data.activity)
                })
            },

            prepareComponent() {
                this.formPanel = this.$refs.formPanel
            },

        },

        components: {
            'form-panel': FormPanel,
        }

    }

</script>
