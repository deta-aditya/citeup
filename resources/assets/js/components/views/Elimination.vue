
<template>
    <p class="lead text-center" :style="{ marginTop: '100px' }">Mengalihkan Anda...</p>
</template>

<script>
    
    import Citeup from '../../citeup'

    export default {
        mounted() {
            window.location.replace(Citeup.appPath + '/elimination/')
        },
    }

</script>