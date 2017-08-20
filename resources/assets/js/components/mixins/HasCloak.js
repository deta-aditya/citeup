
export default {

    data() {
        return {
            cloak: null,
            cloakable: null,
            cloaking: this.cloaked,
        }
    },

    props: {
        cloaked: {
            type: Boolean,
            default: false,
        }
    },

    mounted() {
        this.cloakable = this.$refs.cloakable 
        this.mountCloak(this.cloakable)
    },

    watch: {
        cloaking(newVal) {
            if (newVal) {
                this.cloak.style.display = 'block'
            } else {
                this.cloak.style.display = 'none'
            }
        }
    },

    methods: {
        mountCloak(cloakable) {
            this.cloak = this.createCloak(cloakable)
            cloakable.prepend(this.cloak)
        },
        createCloak(cloakable) {
            let cloak = document.createElement('div')
            let cloakContent = document.createElement('div')
            let spinner = document.createElement('i')

            cloak.classList.add('cloak')
            cloak.style.width = cloakable.offsetWidth + 'px'
            cloak.style.height = cloakable.offsetHeight + 'px'

            cloakContent.classList.add('cloak-content', 'text-center')
            cloakContent.style.width = cloakable.offsetWidth + 'px'
            cloakContent.style.height = cloakable.offsetHeight + 'px'

            spinner.classList.add('fa', 'fa-spinner', 'fa-pulse', 'fa-2x')

            if (! this.cloaking) {
                cloak.style.display = 'none'
            }

            cloakContent.appendChild(spinner)
            cloak.appendChild(cloakContent)

            return cloak
        },
    }
}