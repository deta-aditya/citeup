
<template>
    <div id="finished-view">
        <h2 class="view-title">Selesai</h2>
        <div class="signature-holder text-center">
            <i class="fa fa-check-circle"></i>
        </div>
        <p class="greeting-text">Selamat! Anda telah menyelesaikan proses seleksi.</p>
        <div class="text-center">
            <router-link :to="{ name: 'Answers' }" class="btn btn-lg btn-primary btn-done">Lihat Jawaban</router-link>
            <a :href="dashboard" class="btn btn-lg btn-default btn-done">Keluar</a>
        </div>
    </div>
</template>

<script>

    import Citeup from '../../../../citeup'

    export default {
        computed: {
            dashboard() {
                return Citeup.appPath + '/panel'
            }
        },
    }

</script>