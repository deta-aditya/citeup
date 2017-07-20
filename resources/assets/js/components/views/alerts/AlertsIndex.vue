
<style lang="scss" scoped>
    
</style>

<template>
    <div id="alerts-index">
        <tabulation ref="tabulation" title="Notifikasi" :data="alerts" :data-detail="announcedUsers" :options="alertTabulationOpts">
            <template slot="title">
                <i class="fa fa-bell"></i> 
                Tabel Notifikasi
            </template>
        </tabulation>
        <div :id="announceToModalId" class="modal fade" tabindex="-1" role="dialog" v-if="user.admin">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Umumkan Notifikasi ke...</h4>
                    </div>
                    <table class="table">
                        <tbody>
                            <tr>
                                <th>ID</th>
                                <th>Foto</th>
                                <th>Nama</th>
                                <th>Peran</th>
                            </tr>
                            <tr v-for="user in announceable" is="tabulation-row" :identifier="user.id" :key="user.id" @check="check">
                                <td>{{ user.id }}</td>
                                <td><img :src="user.profile.photo" class="img-circle user-img"></td>
                                <td>{{ user.name }}</td>
                                <td>{{ user.rolename | translateRole }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" @click="announce">Umumkan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import _ from 'lodash'
    import moment from 'moment'
    import { mapState } from 'vuex'
    import Citeup from '../../../citeup'
    import Tabulation from '../../kits/Tabulation.vue'
    import TabulationRow from '../../kits/TabulationRow.vue'

    const STATES = [
        'user'
    ]

    const PICKED_ANNOUNCEABLE_FIELDS = [
        'id', 'profile', 'name', 'rolename',
    ]

    const ALERT_TABOPS_ADMIN = {
        features: {
            create: true,
            update: true,
            remove: true,
            detail: true
        },
        forms: {
            create: { name: 'alerts.create' },
            update: '/alerts/?/update',
        },
        columns: ['ID', 'Judul', 'Konten', 'Dibuat pada', 'Disunting pada'],
        actions: {
            individual: [
                {
                    name: 'Umumkan ke...',
                    action: 'announce-to',
                }
            ],
            checked: [
                {
                    name: 'Umumkan Tertanda ke...',
                    action: 'announce-checked-to',
                }
            ],
        },
        detail: {
            columns: ['ID', 'Foto', 'Nama', 'Diumumkan pada', 'Dilihat pada'],
            actions: [
                {
                    name: 'Lihat',
                    action: 'see',
                },
                {
                    name: 'Tidak Lihat',
                    action: 'unsee',
                },
                {
                    name: 'Lepaskan',
                    action: 'unannounce'
                }
            ]
        },
        take: 15,
        hideId: false,
        isLoading: true
    }

    const ALERT_TABOPS_NORMAL = {
        features: {
            create: false,
            update: false,
            remove: false,
            detail: false,
        },
        columns: ['Judul', 'Konten', 'Diumumkan Pada', 'Dilihat pada'],
        actions: {
            individual: [
                {
                    name: 'Lihat',
                    action: 'see-individual',
                },
            ],
            checked: [
                {
                    name: 'Lihat Tertanda',
                    action: 'see-checked',
                }
            ],
        },
        take: 15,
        hideId: true,
        isLoading: true
    }    

    export default {

        data() {
            return {
                alerts: [],
                tabulation: {},
                alertToAnnounce: 0,
                announceable: [],
                announcedUsers: [],
                checked: [],
                announceToModalId: 'modal-announce-to',
                alertTabulationOpts: ALERT_TABOPS_NORMAL
            }
        },

        computed: _.merge(mapState(STATES), {
            //
        }),

        watch: {

            user(newUser) {
                if (newUser.admin) {
                    this.toAdminMode()
                }
            }

        },

        filters: {

            translateRole(value) {

                switch (value) {
                    case 'Committee': return 'Panitia'; break
                    case 'Entrant': return 'Peserta'; break
                    default: return value
                }

            },

        },
        
        beforeRouteEnter(to, from, next) {
            next(vm => vm.getAlerts())
        },

        created() {
            if (this.user.admin) {
                this.toAdminMode()
            }
        },

        mounted() {
            this.prepareComponent()
            this.prepareEvents()
        },

        methods: {

            getAlerts() {

                let uri = '/alerts'
                let user = this.user
                let self = this
                let params = { take: 15 }

                if (user.entrant) {
                    uri = '/users/' + user.id + uri
                }
                
                this.alerts = []

                Citeup.get(uri, params).then(response => {
                    self.mapAlerts(response.data.data.alerts)
                    self.tabulation.isLoading = false
                })

            },

            mapAlerts(alerts) {

                alerts.forEach(alert => {

                    let toBeStored = {
                        id: alert.id,
                        title: alert.title,
                        content: alert.content,
                    }

                    if (this.user.admin) {
                        toBeStored.created_at = moment(alert.created_at).format('DD MMM, HH:mm')
                        toBeStored.updated_at = moment(alert.updated_at).format('DD MMM, HH:mm')
                    } else {
                        toBeStored.announced_at = moment(alert.announced_at).format('DD MMM, HH:mm')
                        toBeStored.seen_at = alert.seen_at === null ? 'N/A' : moment(alert.seen_at).format('DD MMM, HH:mm')
                    }

                    this.alerts.push(toBeStored)

                }, this)

            },

            prepareComponent() {
                this.tabulation = this.$refs.tabulation
            },

            prepareEvents() {

                let announceToModal = $('#' + this.announceToModalId)

                announceToModal.on('hidden.bs.modal', () => this.announceable = [])

                this.tabulation.$on('remove', this.removeAlerts)
                this.tabulation.$on('announce-to', this.prepareAnnounce)
                this.tabulation.$on('detail-shown', this.loadAnnouncedUsers)
                this.tabulation.$on('unannounce', this.unannounce)
                this.tabulation.$on('see', this.see)
                this.tabulation.$on('unsee', this.unsee)
                this.tabulation.$on('see-individual', this.seeIndividual)

            },

            toAdminMode() {
                this.alertTabulationOpts = ALERT_TABOPS_ADMIN
            },

            removeAlerts(alerts) {

                let self = this
                let done = []

                this.tabulation.isLoading = true

                for (let alert of alerts) {

                    Citeup.delete('/alerts/' + alert.id).then(response => {
                        
                        self.alerts.splice(
                            self.alerts.findIndex(el => el.id === alert.id)
                        , 1)

                        done.push(alert.id)

                        if (done.length === alerts.length) {
                            this.tabulation.isLoading = false
                        }

                    })

                }

            },

            check(row) {

                let id = row.identifier
                let index = this.checked.indexOf(id)

                if (index < 0) {
                    this.checked.push(id)
                } else {
                    this.checked.splice(index, 1)
                }

            },

            prepareAnnounce(target) {

                let self = this

                this.alertToAnnounce = target
                this.tabulation.isLoading = true

                Citeup.get('/users').then(response => {

                    $('#' + self.announceToModalId).modal('show')

                    self.tabulation.isLoading = false

                    self.mapAnnounceable(response.data.data.users)
                })

            },

            announce() {

                let params = {
                    announce: this.checked
                }

                this.tabulation.isLoading = true

                Citeup.post('/alerts/' + this.alertToAnnounce + '/users', params).then(this.postAnnounce)

            },

            unannounce(alertId, id) {

                let params = {
                    unannounce: [id]
                }

                this.tabulation.isLoading = true

                Citeup.post('/alerts/' + alertId + '/users', params).then(
                    response => this.loadAnnouncedUsers(alertId)
                )

            },

            see(alertId, id) {

                let params = {
                    see: [alertId]
                }

                this.tabulation.isLoading = true

                Citeup.post('/users/' + id + '/alerts', params).then(
                    response => this.loadAnnouncedUsers(alertId)
                )

            },

            seeIndividual(id) {

                let params = {
                    see: [id]
                }

                this.tabulation.isLoading = true

                Citeup.post('/users/' + this.user.id + '/alerts', params).then(
                    response => this.getAlerts()
                )

            },

            unsee(alertId, id) {

                let params = {
                    unsee: [alertId]
                }

                this.tabulation.isLoading = true

                Citeup.post('/users/' + id + '/alerts', params).then(
                    response => this.loadAnnouncedUsers(alertId)
                )

            },

            postAnnounce() {

                $('#' + this.announceToModalId).modal('hide')

                if (! this.tabulation.detailIsShown) {
                    this.tabulation.showDetail(this.alertToAnnounce)
                }

                this.announceable = this.checked = []
                this.alertToAnnounce = 0

            },

            mapAnnounceable(users) {
                
                users.forEach(user => {

                    let announceable = _.pick(user, PICKED_ANNOUNCEABLE_FIELDS)

                    if (announceable.profile === null) {
                        announceable.profile = {
                            photo: Citeup.defaultImage
                        }
                    } else {
                        announceable.profile.photo = Citeup.appPath + '/' + announceable.profile.photo
                    }

                    this.announceable.push(announceable)

                }, this)

            },

            loadAnnouncedUsers(target) {

                this.tabulation.isLoading = true

                Citeup.get('/alerts/' + target + '/users').then(response => {
                    this.mapAnnouncedUsers(response.data.data.users)
                    this.tabulation.isLoading = false
                })

            },

            mapAnnouncedUsers(users) {

                this.announcedUsers = []

                users.forEach(user => {

                    this.announcedUsers.push({
                        id: user.id,
                        photo: user.profile === null ? 'img:' + Citeup.defaultImage : 'img:' + Citeup.appPath + '/' + user.profile.photo,
                        name: user.name,
                        announced_at: moment(user.announced_at).format('DD MMM, HH:mm'),
                        seen_at: user.seen_at === null ? 'N/A' : moment(user.seen_at).format('DD MMM, HH:mm')
                    })

                }, this)

            },

        },

        components: {
            'tabulation': Tabulation,
            'tabulation-row': TabulationRow
        }

    }

</script>
