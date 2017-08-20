
<template>
    <div :class="{'form-panel': true, 'trackdown-box': true, 'trackdown-completed': completed, 'trackdown-current': current}" ref="cloakable">
        <div class="panel panel-default">
            <div class="panel-body">
                <i :class="['fa', 'fa-' + icon, 'trackdown-icon']"></i>
                <div class="trackdown-title"><slot name="title"></slot></div>
                <div class="trackdown-number"><slot name="number"></slot></div>
                <div class="trackdown-standout"><slot name="standout"></slot></div>
                <div class="text-right">
                    <slot name="link"></slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import HasCloak from '../mixins/HasCloak'

    export default {

        mixins: [HasCloak],

        props: {
            completed: {
                type: Boolean,
                default: false,
            },
            current: {
                type: Boolean,
                default: false,
            },
            icon: {
                type: String,
            }
        },
        
    }

</script>