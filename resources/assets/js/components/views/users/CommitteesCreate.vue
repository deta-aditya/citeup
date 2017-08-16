
<template>
    <div id="committees-create">
        <committees-form mode="create"></committees-form>
    </div>
</template>

<script>

    import CommitteesForm from './CommitteesForm'
    import AdminGuardMixin from '../../guards/AdminGuardMixin'

    export default {
        mixins: [AdminGuardMixin],
        components: {
            'committees-form': CommitteesForm,
        },
    }

</script>
