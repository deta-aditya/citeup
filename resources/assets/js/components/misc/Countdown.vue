
<style lang="scss" scoped>


</style>

<template>
    <div class="countdown">
        <div class="unit-item">
            <div class="unit-number">{{ days | normalize }}</div>
            <div class="unit-info" v-if="labeled">Hari</div>
        </div>
        <div class="unit-item">
            <div class="unit-number">{{ hours | normalize }}</div>
            <div class="unit-info" v-if="labeled">Jam</div>
        </div>
        <div class="unit-item">
            <div class="unit-number">{{ minutes | normalize }}</div>
            <div class="unit-info" v-if="labeled">Menit</div>
        </div>
        <div class="unit-item">
            <div class="unit-number">{{ seconds | normalize }}</div>
            <div class="unit-info" v-if="labeled">Detik</div>
        </div>

    </div>
</template>

<script>

    import moment from 'moment'

    const EMPTY_DURATION = 'XX'

    export default {

        props: {

            done: {
                type: String,
                required: true,
            },

            tick: {
                type: Number,
                default: 1000,
            },

            labeled: {
                type: Boolean,
                default: true,
            },

        },

        data() {
            return {
                timer: null,
                duration: null,
            }
        },

        computed: {

            days() {

                if (this.duration === null) {
                    return EMPTY_DURATION
                } else if (this.duration < 0) {
                    return 0
                }

                return Math.floor(this.duration.asDays())

            },

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
            this.interval = setInterval(this.setDuration, this.tick)
        },

        methods: {
            setDuration() {
                this.duration = moment.duration(
                    moment(this.done).diff(moment())
                )

                if (this.duration.asMilliseconds() <= 0) {
                    this.$emit('done');
                    clearInterval(this.interval)
                }
            },
        },

    }

</script>
