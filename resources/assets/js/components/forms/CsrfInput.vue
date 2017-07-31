
<template>
    <input type="hidden" name="_token" :value="csrfToken">
</template>

<script>

    import Citeup from '../../citeup';

    export default {

        data() {
            return {
                csrfToken: Citeup.csrf
            }
        }

    }
</script>
