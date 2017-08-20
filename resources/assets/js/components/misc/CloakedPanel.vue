
<template>
    <div ref="cloakable" class="form-panel">
        <div class="panel panel-default">
            <slot></slot>
        </div>
    </div>
</template>

<script>

    import HasCloak from '../mixins/HasCloak'
    
    export default {
        mixins: [HasCloak],
    }

</script>