
<template>
    <router-link tag="li" active-class="active" :to="to">
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