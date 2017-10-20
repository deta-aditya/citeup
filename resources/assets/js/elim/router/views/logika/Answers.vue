
<template>
    <question-select></question-select>
</template>

<script>

    import { mapGetters } from 'vuex'
    import QuestionSelect from './QuestionSelect.vue'
    
    export default {

        computed: mapGetters('stage', ['countdown']),

        created() {
            if (this.countdown) {
                return this.$router.push({ name: 'Root' })
            }
        },

        components: {
            'question-select': QuestionSelect,
        },
    }

</script>