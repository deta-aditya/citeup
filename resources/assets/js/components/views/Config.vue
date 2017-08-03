
<template>
    <div id="config-page">
        <message-box ref="successMessageBox" name="success">
            <span slot="title">Penyimpanan Berhasil</span>
            Konfigurasi telah berhasil disimpan.
            <div slot="buttons" class="text-right">
                <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
            </div>
        </message-box>
        <div class="form-panel">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="pull-right">
                        <button type="button" class="btn btn-default">Segarkan</button>
                    </div>
                    <h1 class="page-title">Konfigurasi</h1>
                </div>
            </div>
        </div>
        <api-form method="post" action="/config" :model="formModel" @submitting="beforeSubmit" @submitted="afterSubmit">
            <div class="row">
                <div class="col-sm-6">
                    <form-panel :formless="true" :horizontal="true" :bodiless="true" :footerless="true">
                        <div class="panel-body">
                            <h2 class="page-title small-title">Halaman Depan</h2>
                        </div>
                        <div class="panel-body">
                            <h3 class="subtitle text-muted">Penghitung Mundur</h3>
                            <switch-button name="landing-countdown-active" :label-width="4" :control-width="8" value="active" v-model="value.landing.countdown.active">
                                Status
                            </switch-button>
                            <date-time-input name="landing-countdown-off" :label-width="4" :control-width="8" v-model="value.landing.countdown.off">
                                Hitung Hingga
                            </date-time-input>
                            <text-input name="landing-countdown-text" :label-width="4" :control-width="8" v-model="value.landing.countdown.text">
                                Teks
                                <p class="help-block" slot="help-block">Teks in akan ditampilkan di atas penghitung mundur.</p>
                            </text-input>
                            <h2 class="subtitle text-muted">Bagian yang Ditampilkan</h2>
                            <check-list name="landing-show" :control-width="12" :labeled="false" v-model="value.landing.show">
                                <template slot="list" scope="props">
                                    {{ props.data.name }}
                                </template>
                            </check-list>
                        </div>
                    </form-panel>
                </div>
                <div class="col-sm-6">
                    <form-panel :formless="true" :horizontal="true" :bodiless="true" :footerless="true">
                        <div class="panel-body">
                            <h2 class="page-title small-title">Lokasi Perlombaan</h2>
                        </div>
                        <gmap-map class="panel-body" :center="value.address.location" :zoom="15" :style="{ 'height': '400px' }" @click="changeLocation">
                            <gmap-marker :position="value.address.location"></gmap-marker>
                        </gmap-map>
                        <div class="panel-body text-muted">
                            Klik pada lokasi baru untuk mengubah lokasi perlombaan.
                        </div>
                    </form-panel>
                    <form-panel :formless="true" :horizontal="true" :bodiless="true" :footerless="true">
                        <div class="panel-body">
                            <h2 class="page-title small-title">Kontak</h2>
                        </div>
                        <div class="panel-body">
                            <text-input name="contact-email" :label-width="4" :control-width="8" v-model="value.contact.email">
                                Email
                                <p class="help-block" slot="help-block">Pesan dari formulir "Kontak Kami" akan dikirimkan ke alamat di atas.</p>
                            </text-input>
                            <text-input name="contact-facebook" :label-width="4" :control-width="8" v-model="value.contact.facebook">
                                Akun Facebook
                            </text-input>
                            <text-input name="contact-twitter" :label-width="4" :control-width="8" v-model="value.contact.twitter">
                                Akun Twitter
                            </text-input>
                            <text-input name="contact-line" :label-width="4" :control-width="8" v-model="value.contact.line">
                                Akun LINE
                            </text-input>
                            <text-input name="contact-instagram" :label-width="4" :control-width="8" v-model="value.contact.instagram">
                                Akun Instagram
                            </text-input>
                        </div>
                    </form-panel>
                    <form-panel :formless="true" :horizontal="true" :bodiless="true" :footerless="true">
                        <div class="panel-body">
                            <h2 class="page-title small-title">Tahap Aplikasi</h2>
                        </div>
                        <div class="panel-body text-muted">
                            Bagian ini menentukan kapan tahapan pada aplikasi akan berlangsung. Tahapan-tahapan tersebut bertanggungjawab atas aktifitas-aktifitas yang ada pada aplikasi. Suntinglah dengan hati-hati!
                        </div>
                        <div class="panel-body">
                            <div class="panel-group" id="stages-list" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-default" v-for="(stage, index) in value.stages" :key="index">
                                    <div class="panel-heading" role="button" data-toggle="collapse" data-parent="#stages-list" :data-target="'#collapsible-stage-' + index">
                                        <h4 class="panel-title">{{ stage.name }}</h4>
                                    </div>
                                    <div :id="'collapsible-stage-' + index" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <date-time-input :name="'stage-' + index + '-end'" :label-width="4" :control-width="8" v-model="value.stages[index].end">
                                                Berlangsung Hingga
                                            </date-time-input>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form-panel>
                </div>
            </div>
            <button ref="btnSubmit" type="submit" class="btn btn-lg btn-primary pull-right" style="margin-bottom:25px">{{ btnText }}</button>
        </api-form>
    </div>
</template>

<script>

    import _ from 'lodash'
    import Vue from 'vue'
    import Citeup from '../../citeup'
    import { mapState } from 'vuex'
    import * as VueGoogleMaps from 'vue2-google-maps' 
    import ApiForm from '../forms/ApiForm.vue'
    import FormPanel from '../kits/FormPanel/FormPanel.vue'
    import SwitchButton from '../kits/FormPanel/SwitchButton.vue'
    import DateTimeInput from '../kits/FormPanel/DateTimeInput.vue'
    import TextInput from '../kits/FormPanel/TextInput.vue'
    import CheckList from '../kits/FormPanel/CheckList/CheckList.vue'
    import StaticInput from '../kits/FormPanel/StaticInput.vue'
    import MultilineInput from '../kits/FormPanel/MultilineInput.vue'
    import MessageBox from '../kits/MessageBox.vue'

    const STATES = [
        'config'
    ]

    Vue.use(VueGoogleMaps, {
        load: {
            key: Citeup.gmapKey,
        }
    })

    export default {

        data() {
            return {
                successMessageBox: null,
                btnSubmit: null,
                btnText: 'Simpan Perubahan',
                value: {
                    landing: {
                        countdown: {},
                        activities: {},
                    },
                    address: {
                        location: {lat: 0, lng: 0},
                    },
                    contact: {
                        phones: {},
                    }
                },
            }
        },

        computed: _.merge(mapState(STATES), {

            formModel() {
                return { value: JSON.stringify(this.value) }
            },

            phones: {
                get() {

                    var intended = []

                    for (let name in this.value.contact.phones) {
                        intended.push(name + ': ' +  this.value.contact.phones[name])
                    }

                    return intended.join(', ')
                },

                set(newVal) {

                    var intended = {}

                    for (var phone of newVal.split(',')) {
                        var phone = phone.trim()
                        var items = phone.split(':')

                        for (let i = 0; i < items.length; i++) {
                            items[i] = items[i].trim()
                        }

                        if (items[1] === undefined) {
                            items[1] = ''
                        }

                        intended[items[0]] = items[1]
                    }

                    this.value.contact.phones = intended
                },
            },

        }),

        watch: {

            config(newVal) {
                this.value = newVal
            },

        },

        created() {
            if (! _.isEmpty(this.config)) {
                this.value = this.config
            }
        },

        mounted() {
            this.prepareComponent()
        },
 
        methods: {

            prepareComponent() {
                this.btnSubmit = this.$refs.btnSubmit
                this.successMessageBox = this.$refs.successMessageBox
            },

            changeLocation($event) {
                this.value.address.location = $event.latLng.toJSON()
            },

            beforeSubmit() {
                this.btnSubmit.disabled = true
                this.btnText = 'Menyimpan...'
            },

            afterSubmit() {
                this.btnSubmit.disabled = false
                this.btnText = 'Simpan Perubahan'
                this.successMessageBox.open()
            },

        },

        components: {
            'api-form': ApiForm,
            'form-panel': FormPanel,
            'switch-button': SwitchButton,
            'date-time-input': DateTimeInput,
            'text-input': TextInput,
            'check-list': CheckList,
            'static-input': StaticInput,
            'multiline-input': MultilineInput,
            'message-box': MessageBox,
        },

    }

</script>
