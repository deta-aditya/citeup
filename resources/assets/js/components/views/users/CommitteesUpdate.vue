
<template>
    <div id="committees-update">
        <committees-form mode="update" :id="id"></committees-form>
    </div>
</template>

<script>

    import CommitteesForm from './CommitteesForm'
    import UsersMixin from './UsersMixin'

    export default {
        mixins: [UsersMixin],
        props: { id: [Number, String] },
        components: {
            'committees-form': CommitteesForm,
        },
    }

</script>
