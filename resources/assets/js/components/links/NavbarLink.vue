
<template>
    <router-link tag="li" :to="to">
        <a><slot></slot></a>
    </router-link>
</template>

<script>

    export default {
        props: {
            to: {
                type: [String, Object],
                required: true
            }
        },
    }
</script>