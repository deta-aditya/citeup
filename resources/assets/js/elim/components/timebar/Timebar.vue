
<template>
    <div class="progress timebar">
        <div ref="loadingBarProgress" class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" :style="{ minWidth: '60px', width: left, transition: '0.2s' }">
            {{ hours | normalize }}:{{ minutes | normalize }}:{{ seconds | normalize }} 
        </div>    
    </div>
</template>

<script>

    import moment from 'moment'

    const EMPTY_DURATION = 'XX'

    export default {
        props: {
            finish: {
                type: [String, Object],
                required: true,
            },
        },

        data() { 
            return {
                duration: null,
            }
        },
        
        computed: {
            hours() {
                if (this.duration === null) {
                    return EMPTY_DURATION
                } else if (this.duration < 0) {
                    return 0
                }

                return this.duration.hours()

            },
            minutes() {

                if (this.duration === null) {
                    return EMPTY_DURATION
                } else if (this.duration < 0) {
                    return 0
                }

                return this.duration.minutes()

            },
            seconds() {

                if (this.duration === null) {
                    return EMPTY_DURATION
                } else if (this.duration < 0) {
                    return 0
                }

                return this.duration.seconds()

            },
            left() {
                return this.duration === null ? '0%' : (100 - Math.floor(this.duration.asSeconds()) / 7200 * 100) + '%'
            },
        },

        filters: {

            normalize(val) {

                if (val < 10) {
                    return '0' + val.toString()
                } else if (val < 0) {
                    return '00'
                }

                return val

            }

        },

        created() {
            this.interval = setInterval(this.setDuration, 1000)
        },

        methods: {
            setDuration() {
                this.duration = moment.duration(
                    moment(this.finish).diff(moment())
                )

                if (this.duration.asMilliseconds() <= 0) {
                    this.$emit('done')
                    clearInterval(this.interval)
                }
            },
        }
    }


</script>
