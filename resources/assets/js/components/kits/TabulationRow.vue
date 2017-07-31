
<style lang="scss" scoped>

    .tabulation-row {

        cursor: pointer;

        & > td {
            min-width: 50px;
        }

    }

    .checked {
        border-left: 6px solid #337ab7;
    }

    .user-img {
        width: 25px;
    }

</style>

<template>
    <tr class="tabulation-row" ref="realRow" @click="check">
        <slot></slot>
    </tr>
</template>

<script>

    export default {

        data() {
            return {
                checked: false
            }
        },

        props: {

            identifier: {
                type: [Number, String],
                required: true
            }

        },

        methods: {

            check() {

                let row = this.$refs.realRow

                row.classList.toggle('checked')

                this.checked = row.classList.contains('checked')

                this.$emit('check', this)
            }

        }

    }

</script>
