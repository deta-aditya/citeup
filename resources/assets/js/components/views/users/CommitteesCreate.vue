
<template>
    <div id="committees-create">
        <committees-form mode="create"></committees-form>
    </div>
</template>

<script>

    import CommitteesForm from './CommitteesForm'
    import UsersMixin from './UsersMixin'

    export default {
        mixins: [UsersMixin],
        components: {
            'committees-form': CommitteesForm,
        },
    }

</script>
