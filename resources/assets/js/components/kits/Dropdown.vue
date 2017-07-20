
<script>

    import _ from 'lodash'

    const TRIGGER_ATTRS = {
        'data-toggle': 'dropdown',
        'aria-haspopup': 'true',
        'aria-expanded': 'false',
    }

    const TOGGLE_CLASS = 'dropdown-toggle'

    export default {        
        
        render(createElement) {
            
            switch (this.type) {
                case 'button':
                    return this.buttonType(createElement)
                case 'nav':
                    return this.navType(createElement)
            }

        },

        props: {

            type: {
                type: String,
                default: 'button',
            },

            align: {
                type: String,
                default: 'left',
            },

            up: {
                type: Boolean,
                default: false,
            },

            variant: {
                type: String,
                default: 'default',
            },

            split: {
                type: Boolean,
                default: false,
            },

            size: {
                type: String,
                default: 'default',
            },

            caret: {
                type: Boolean,
                default: true,
            }

        },

        computed: {

            alignmentClass() {
                return 'dropdown-menu-' + this.align
            },

            btnVariant() {
                return 'btn-' + this.variant
            },

            btnSize() {
                return this.size === 'default' ? '' : 'btn-' + this.size
            },

            dropDirection() {
                return this.up ? 'dropup' : 'dropdown'
            },
        },

        mounted() {
            this.prepareEvents()
        },

        methods: {

            prepareEvents() {

                var realDropdown = this.$refs.realDropdown
                var self = this

                $(realDropdown).on('show.bs.dropdown', (e) => {
                    self.$emit('show', e)
                })

                $(realDropdown).on('shown.bs.dropdown', (e) => {
                    self.$emit('shown', e)
                })

                $(realDropdown).on('hide.bs.dropdown', (e) => {
                    self.$emit('hide', e)
                })

                $(realDropdown).on('hidden.bs.dropdown', (e) => {
                    self.$emit('hidden', e)
                })
                
            },

            buttonType(createElement) {

                let classes = [ 'btn-group' ]
                let childs = [
                    this.createButton(createElement, this.split),
                    this.createMenu(createElement),
                ]

                if (this.split) {
                    childs.unshift(createElement(
                        'button', {
                            class: ['btn', this.btnVariant]
                        }, this.$slots.default
                    ))
                }

                if (this.up) {
                    classes.push(this.dropDirection)
                }

                return createElement(
                    'div', {
                        ref: 'realDropdown',
                        class: classes
                    }, childs
                )

            },

            navType(createElement) {
                return createElement(
                    'li', {
                        ref: 'realDropdown',
                        class: [ this.dropDirection ]
                    }, [
                        this.createAnchor(createElement),
                        this.createMenu(createElement),
                    ]
                )
            },

            createButton(createElement, noText) {

                let childs = []

                if (! noText) {
                    childs.push(this.$slots.default)
                }

                if (this.caret) {
                    childs.push(this.createCaret(createElement))
                }

                return createElement(
                    'button', {
                        class: ['btn', TOGGLE_CLASS, this.btnVariant, this.btnSize],
                        attrs: TRIGGER_ATTRS,
                    }, childs
                )

            },

            createAnchor(createElement) {

                let childs = [
                    this.$slots.default,
                ] 

                if (this.caret) {
                    childs.push(this.createCaret(createElement))
                }

                return createElement(
                    'a', {
                        class: [ TOGGLE_CLASS ],
                        attrs: _.merge(TRIGGER_ATTRS, {
                            'role': 'button',
                        }),
                    }, childs
                )
            },

            createCaret(createElement) {
                return createElement(
                    'span', {class: [ 'caret' ]}
                )
            },

            createMenu(createElement) {
                return createElement(
                    'ul', {
                        class: ['dropdown-menu', this.alignmentClass]
                    }, this.$slots.menu
                )
            }

        },

    }
</script>