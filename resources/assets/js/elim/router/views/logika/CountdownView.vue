
<template>
    <div id="countdown-view">
        <div class="greeting-text">Halo {{ user.entry.name }}. Sudah Siapkah Anda?</div>
        <div class="row">
            <div class="col-sm-6">
                <h2 class="view-title">Peraturan</h2>
                <div class="super-list">
                    <div class="super-list-item">
                        <div class="super-list-number">
                            <span>1</span>
                        </div>
                        <div class="super-list-content">
                            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Maecenas porttitor congue massa. Fusce posuere, magna sed pulvinar ultricies, purus lectus malesuada libero, sit amet commodo magna eros quis urna.</p>
                            <p>Nunc viverra imperdiet enim. Fusce est. Vivamus a tellus.</p>
                            <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Proin pharetra nonummy pede. Mauris et orci.</p>
                            <p>Aenean nec lorem. In porttitor. Donec laoreet nonummy augue.</p>
                            <p>Suspendisse dui purus, scelerisque at, vulputate vitae, pretium mattis, nunc. Mauris eget neque at sem venenatis eleifend. Ut nonummy.</p>
                        </div>
                    </div>
                    <div class="super-list-item">
                        <div class="super-list-number">
                            <span>2</span>
                        </div>
                        <div class="super-list-content">
                            Godspeed.
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <h2 class="view-title">Panduan</h2>
                <div class="super-list">
                    <div class="super-list-item">
                        <div class="super-list-number">
                            <span>1</span>
                        </div>
                        <div class="super-list-content">
                            <p>Aenean nec lorem. In porttitor. Donec laoreet nonummy augue.</p>
                            <p>Suspendisse dui purus, scelerisque at, vulputate vitae, pretium mattis, nunc. Mauris eget neque at sem venenatis eleifend. Ut nonummy.</p>
                        </div>
                    </div>
                    <div class="super-list-item">
                        <div class="super-list-number">
                            <span>2</span>
                        </div>
                        <div class="super-list-content">
                            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Maecenas porttitor congue massa. Fusce posuere, magna sed pulvinar ultricies, purus lectus malesuada libero, sit amet commodo magna eros quis urna.</p>
                            <p>Nunc viverra imperdiet enim. Fusce est. Vivamus a tellus.</p>
                            <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Proin pharetra nonummy pede. Mauris et orci.</p>
                            <div class="text-center"><img :src="defaultImage" class="img-rounded"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center" v-if="isWarmingUp">
            <button type="button" class="btn btn-lg btn-primary btn-done" @click="warmUp">Uji Coba</button>
        </div>
    </div>
</template>

<script>

    import _ from 'lodash'
    import moment from 'moment'
    import { mapState, mapMutations } from 'vuex'
    import Citeup from '../../../../citeup'

    const STATE_USER = {'user': 'data'}
    const MUTATIONS_STAGE = {
        'setStatus': 'STAGE_SET_STATUS',
        'setTimebarInfo': 'STAGE_SET_TIMEBAR_INFO',
    }

    export default {
        data() {
            return {
                warming: {}
            }
        },
        computed: _.merge(mapState('user', STATE_USER), {
            defaultImage() {
                return Citeup.defaultImage
            },
            isWarmingUp() {
                return moment().diff(moment(this.warming.start)) >= 0 
                    && moment().diff(moment(this.warming.finish)) < 0
            },
        }),
        created() {
            Citeup.get('/config').then(response => {
                this.warming = response.data.data.config.warming
            })
        },
        methods: _.merge(mapMutations('stage', MUTATIONS_STAGE), {
            warmUp() {
                this.setStatus({ status: 1 })
                this.setTimebarInfo({ 
                    start: this.warming.start, 
                    finish: this.warming.finish,
                })
            },
        }),
    }

</script>