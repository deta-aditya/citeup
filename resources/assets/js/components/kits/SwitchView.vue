
<template>
    <div class="switch-view">
        <component :is="value"></component>
    </div>
</template>

<script>
    
    export default {

        props: {

            views: {
                required: true,
                type: Array,
            },

            value: {
                required: true,
                type: String,
            },

        },

    }

</script>