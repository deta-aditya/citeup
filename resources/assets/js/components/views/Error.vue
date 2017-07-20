
<style lang="scss" scoped>

    #error-page {

        padding: 15px;
        margin-top: 70px;

        .number-container {
            font-size: 72pt;
            font-weight: lighter;
        }
    }

</style>

<template>
    <div id="error-page" class="text-center">
        <div class="number-container">
            <span>{{ status }}</span>
        </div>
        <h1>{{ errorText }}</h1>
        <p class="lead detailed-text" v-html="detailedText"></p>
        <p>
            <router-link :to="{ name: 'root' }" class="btn btn-lg btn-primary">
                Beranda
            </router-link>
        </p>
    </div>
</template>

<script>

    const ERROR_TEXTS = {
        403: 'Dilarang!',
        404: 'Halaman tidak tersedia!'
    }

    const DETAILED_TEXTS = {
        404: 'Anda mengakses halaman yang tidak tersedia di web ini.\
            Biasanya kasus ini terjadi ketika pengguna <b>mengubah URL dengan sembarangan.</b>\
            Silahkan menuju beranda atau kembali ke halaman sebelumnya.'
    }

    export default {

        props: {

            status: {
                type: Number,
                default: 404
            }

        },

        computed: {

            errorText() {
                return ERROR_TEXTS[this.status];
            },

            detailedText() {
                return DETAILED_TEXTS[this.status];
            }

        },

        methods: {

            back() {
                this.$router.go(-1);
            }

        }
    }
</script>