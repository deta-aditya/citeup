
<template>
    <div :class="{ 'sticky-chat': true, 'chat-body-container': true, 'open': open }">
        <div class="chat-toggler" @click="toggle">
            Tanya Panitia
            <span class="badge answers-count pull-right" v-if="unread > 0">{{ unread }}</span>
            <span :class="['glyphicon', 'pull-right', arrowClass]" v-else></span>
        </div>
        <div ref="chatBody" class="chat-body">
            <div :class="{'chat-message': true, 'clearfix': true, 'chat-message-me': chat.committee === 0, 'chat-message-other': chat.committee === 1}" v-for="chat in chats">
                <div class="chat-caret"></div>
                <div class="chat-message-text">{{ chat.message }}</div>
            </div>
        </div>
        <div class="chat-sender">
            <textarea class="form-control" v-model="sendable.message" placeholder="Tekan Enter Untuk Mengirim Pesan..." @keyup.enter="sendChatMessage" :disabled="sendingMessage"></textarea>
            <p v-if="sendingMessage" class="text-muted"><i class="fa fa-pulse fa-spinner"></i> Mengirim pesan</p>
        </div>
    </div>
</template>

<script>

    import { merge } from 'lodash'
    import { mapState, mapActions } from 'vuex'

    const computed = merge(
        mapState('user', {'user': 'data'}),
        mapState('chats', {'chats': 'data'})
    )

    const methods = merge(
        mapActions('chats', ['getChats', 'sendChat', 'readChats'])
    )

    export default {
        data() {
            return {
                sendable: {},                
                open: false,
                sendingMessage: false,
            }
        },
        
        computed: merge(computed, {
            arrowClass() {
                return this.open ? 'glyphicon-chevron-down' : 'glyphicon-chevron-up'
            },
            unread() {
                return this.chats.filter(item => item.read_at === null && item.committee === 1).length
            },
        }),

        mounted() {
            this.getAllChats()
            this.sendable.entry = this.user.entry.id
            this.sendable.committee = 0
        },

        methods: merge(methods, {
            toggle() {
                this.open = ! this.open

                if (this.open) {
                    this.readChats(this.user.entry.id)
                    setTimeout(() => this.scrollToBottom(this.$refs.chatBody), 500)
                }
            },
            getAllChats() {
                this.getChats(this.user.entry.id).then(() => {
                    if (this.open) {

                        if (this.unread > 0) {
                            this.readChats(this.user.entry.id)
                        }
                        this.scrollToBottom(this.$refs.chatBody)
                    }

                    setTimeout(this.getAllChats, 5000)
                })
            },
            sendChatMessage() {
                this.sendingMessage = true

                this.sendChat(this.sendable).then(() => {
                    this.sendingMessage = false
                    this.sendable.message = ''
                    this.scrollToBottom(this.$refs.chatBody)
                })
            },
            scrollToBottom(scrollable) {
                scrollable.scrollTop = scrollable.scrollHeight 
            },
        }),
    }
</script>