
<style lang="scss" scoped>

    $unseen-bg: #d9edf7;
    $screen-sm: 768px;
    $fa-margin: 5px;

    .fa-bell-o ~ span {
        margin-left: $fa-margin;
    }
    
    .alert-list-item {

        border-bottom: 1px solid #d3e0e9;

        @media (min-width: $screen-sm) {
            width: 500px;
        }

        %small-text-size {
            font-size: 12px;
        }

        .alert-title {
            font-size: 16px;
        }

        .alert-content {
            @extend %small-text-size;
            white-space: normal;
        }

        .alert-announced-at {
            @extend %small-text-size;

            .fa {
                margin-right: $fa-margin;
            }
        }

        .alert-seen-at {
            @extend %small-text-size;

            .fa {
                margin-right: $fa-margin;
            }
        }

        .no-alerts {
            padding: 20px;
        }

        &.unseen {
            background: $unseen-bg;
        }
    }

</style>

<template>
    <dropdown ref="dropdown" type="nav" :caret="false" align="right">
        <i class="fa fa-lg fa-bell-o" title="Notifikasi"></i>
        <span v-if="showLabel" class="label label-primary">{{ unseenAlerts.length }}</span>
        <span class="visible-xs-inline">Notifikasi</span>
        <template slot="menu">
            <li v-for="alert in alerts" :key="alert.id">
                <a :class="{'alert-list-item': true, 'unseen': alert.seen_at === null}">
                    <h4>
                        <small class="pull-right alert-announced-at">
                            <i class="fa fa-paper-plane-o"></i> 
                            {{ alert.announced_at | humanize }}
                        </small> {{ alert.title }}
                    </h4> 
                    <p class="alert-content">{{ alert.content }}</p>
                    <p class="text-muted alert-seen-at" v-if="alert.seen_at !== null">
                        <i class="fa fa-eye"></i> {{ alert.seen_at | humanize }}
                    </p>
                </a>
            </li>
            <li v-if="noAlerts">
                <a class="alert-list-item">
                    <p class="no-alerts lead text-center">Tidak Ada Notifikasi</p>
                </a>
            </li>
            <nav-link to="/alerts" class="text-center see-all">Lihat Semua</nav-link>
        </template>
    </dropdown>
</template>

<script>

    import _ from 'lodash'
    import moment from 'moment'
    import { mapState } from 'vuex'
    import Citeup from '../../citeup'
    import Dropdown from '../kits/Dropdown.vue'
    import NavLink from '../links/NavLink.vue'

    const STATES = [
        'user'
    ]
    
    export default {

        data() {
            return {
                seen: false,
                label: true,
                alerts: []
            }
        },

        computed: _.merge(mapState(STATES), {

            unseenAlerts() {
                return this.alerts.filter((alert) => alert.seen_at === null)
            },

            userHasUnseenAlerts() {
                return this.unseenAlerts.length > 0
            },

            showLabel() {
                return this.userHasUnseenAlerts && this.label
            },

            noAlerts() {
                return this.alerts.length === 0
            },

        }),

        created() {
            this.getAlerts()
        },

        mounted() {
            this.prepareEvents()
        },

        filters: {

            humanize(date) {
                return date.format('DD MMM, HH:mm')
            }

        },

        components: {
            'dropdown': Dropdown,
            'nav-link': NavLink,
        },

        methods: {

            getAlerts() {

                let uri = '/users/' + this.user.id + '/alerts'
                let params = { take: 5 }

                this.alerts = []

                Citeup.get(uri, params).then(response => this.mapAlerts(response.data.data.alerts))

            },

            mapAlerts(alerts) {

                let seenAll = true

                alerts.forEach(alert => {

                    if (alert.seen_at === null) {
                        seenAll = false
                    }

                    this.alerts.push({
                        id: alert.alert_id,
                        title: alert.title,
                        content: alert.content,
                        announced_at: moment(alert.announced_at),
                        seen_at: alert.seen_at === null ? null : moment(alert.seen_at)
                    })

                }, this)

                if (seenAll) {
                    this.seen = true
                }

            },

            prepareEvents() {
                this.$refs.dropdown.$on('shown', this.hideLabel)
                this.$refs.dropdown.$on('hide', this.seeAlerts)
            },

            hideLabel() {
                
                if (this.label) {
                    this.label = false
                }

            },

            seeAlerts() {

                var params = {
                    see: []
                }

                if (this.seen || this.noAlerts) {
                    return
                }

                for (let alert of this.alerts) {

                    if (alert.seen_at !== null) {
                        continue
                    }

                    params.see.push(alert.id)

                }

                Citeup.post('/users/' + this.user.id + '/alerts', params).then(response => {
                    
                    this.seen = true
                    
                    this.getAlerts()

                })

            }

        }

    }

</script>
