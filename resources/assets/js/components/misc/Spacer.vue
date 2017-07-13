
<script>
    export default {

        render(createElement) {
            return createElement(
                'div',
                {
                    style: {
                        paddingTop: this.vertical + 'px',
                        paddingLeft: this.horizontal + 'px'
                    }
                }
            )
        },

        props: {

            vertical: {
                type: Number,
                default: 0
            },

            horizontal: {
                type: Number,
                default: 0
            }
        }
    }
</script>
