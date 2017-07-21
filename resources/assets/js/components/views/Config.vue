
<style lang="scss" scoped>

    .panel {
        border-radius: 0;
        border: none;
    }

    .panel-heading {
        border-radius: 0;
        
        .fa {
            color: #333;
        }
    }

    .panel-title {

        padding: 5px 0;

        & > .fa {
            padding: 5px;
            margin-right: 3px;
        }

    }

    .panel-body {
        border-radius: 0;    
        padding: 25px
    }

    .panel-cover {
        position: absolute;
        background: rgba(255,255,255,0.7);
        z-index: 10;

        .panel-cover-content {
            display: table-cell;
            vertical-align: middle;

            i.fa {
                margin-bottom: 10px;
            }
        }
    }

    .limiter {
        width: 500px;
    }

</style>

<template>
    <div id="config-page">
        <div ref="panel" class="panel panel-default">
            <div ref="cover" class="panel-cover" v-show="isLoading">
                <div class="panel-cover-content text-center">
                    <i class="fa fa-spinner fa-4x fa-pulse"></i> 
                    <p class="lead">Memuat...</p>
                </div>
            </div>
            <div class="panel-heading clearfix">
                <div class="pull-right">
                    <a class="btn btn-link" href="#" @click.prevent>
                        <i class="fa fa-refresh"></i>
                    </a>
                </div>
                <h1 class="panel-title"><i class="fa fa-cogs"></i> Konfigurasi Aplikasi</h1>
            </div>
            <div class="panel-body">
                <api-form ref="form" method="post" action="/config" :model="formModel">
                    <fieldset>
                        <div class="limiter">
                            <legend><i>Countdown</i> Pendaftaran</legend>
                            <switch-button name="countdown_active" value="active" v-model="value.countdown.active">
                                Status
                            </switch-button>
                            <date-time-input name="countdown_off" v-model="value.countdown.off">
                                Waktu Pendaftaran Dibuka
                            </date-time-input>
                        </div>
                    </fieldset>
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-primary">
                            Simpan Perubahan
                        </button>
                    </div>
                </api-form>
            </div>
        </div>
    </div>
</template>

<script>

    import _ from 'lodash'
    import { mapState } from 'vuex'
    import ApiForm from '../forms/ApiForm.vue'
    import SwitchButton from '../forms/SwitchButton.vue'
    import DateTimeInput from '../forms/DateTimeInput.vue'

    const STATES = [
        'config'
    ]

    export default {

        data() {
            
            return {
                
                value: {
                    countdown: {}
                },

                isLoading: false,
            }

        },

        computed: _.merge(mapState(STATES), {

            formModel() {
                return { value: JSON.stringify(this.value) }
            }

        }),

        watch: {

            config(newVal) {
                this.value = newVal
            }

        },

        created() {
            if (! _.isEmpty(this.config)) {
                this.value = this.config
            }
        },

        mounted() {
            this.prepareComponent()
            this.setCoverHeight()
        },
 
        methods: {

            prepareComponent() {
                
                let form = this.$refs.form
                var self = this

                form.$on('submitting', () => { this.isLoading = true })
                form.$on('submitted', () => { this.isLoading = false })

            },

            setCoverHeight() {
                let panel = this.$refs.panel;
                let cover = this.$refs.cover;
                let coverContent = cover.querySelector('.panel-cover-content');

                this.setDimension(cover, panel);
                this.setDimension(coverContent, panel);
            },

            setDimension(thisOne, likeThisOne) {
                thisOne.style.width = likeThisOne.offsetWidth + 'px';
                thisOne.style.height = likeThisOne.offsetHeight + 'px';
            },

        },

        components: {
            'api-form': ApiForm,
            'switch-button': SwitchButton,
            'date-time-input': DateTimeInput,
        },

    }

</script>
