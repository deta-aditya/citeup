
<template>
    <div id="finished-view">
        <h2 class="view-title">Selesai</h2>
        <p class="greeting-text">Selamat! Anda telah menyelesaikan proses seleksi.</p>
        <div class="signature-holder text-center">
            <img :src="submission.picture | assetify" class="img-rounded" :style="{ maxWidth: '600px' }"> 
        </div>
        <p class="lead text-center">"{{ submission.description }}"</p>
        <div class="text-center">
            <a :href="dashboard" class="btn btn-lg btn-default btn-done">Keluar</a>
        </div>
    </div>
</template>

<script>
    
    import { merge } from 'lodash'
    import { mapState } from 'vuex'
    import { assetify } from '../../../../components/Citeup/Helper'
    import Citeup from '../../../../citeup'

    const submissionsState = mapState('submissions', {'submission': 'data'})

    export default {
        computed: merge(submissionsState, {
            dashboard() {
                return Citeup.appPath + '/panel'
            }
        }),
        filters: {
            assetify,
        }
    }

</script>
