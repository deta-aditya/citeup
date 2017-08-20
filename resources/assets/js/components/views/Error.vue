
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
            <router-link :to="{ name: 'Dasbor' }" class="btn btn-lg btn-primary">
                Dasbor
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
        403: 'Stop! Anda tidak memiliki izin untuk mengakses fitur ini.',
        404: 'Waduh! Anda mencoba mengakses halaman yang tidak tersedia di aplikasi ini.',
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
                this.$router.back();
            }

        }
    }
</script>