
<template>
    <div>
        Halo!
    </div>
</template>

<script>

    import { mapState } from 'vuex'

    const STATES = [
        'config'
    ]

    export default {
        
        computed: mapState(STATES),

    }

</script>