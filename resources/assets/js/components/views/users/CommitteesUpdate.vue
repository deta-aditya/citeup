
<template>
    <div id="committees-update">
        <committees-form mode="update" :id="id"></committees-form>
    </div>
</template>

<script>

    import CommitteesForm from './CommitteesForm'
    import AdminGuardMixin from '../../guards/AdminGuardMixin'

    export default {
        mixins: [AdminGuardMixin],
        props: { id: [Number, String] },
        components: {
            'committees-form': CommitteesForm,
        },
    }

</script>
