
<template>
    <div id="error-page">
        <h1>Terjadi Kesalahan...</h1>
        <p class="lead">{{ errorText }}</p>
    </div>
</template>

<script>

    const STATUS_TEXTS = {
        403: 'Anda dilarang mengakses fitur ini!',
        404: 'Halaman tidak ditemukan!'
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
                return STATUS_TEXTS[this.status];
            }

        }
    }
</script>