
<template>
    <div class="sticky-chat" :class="{ 'open': open }">
        <div class="chat-toggler" @click="toggle">
            Tanya Panitia
            <span :class="['glyphicon', 'pull-right', arrowClass]"></span>
        </div>
        <div class="chat-body">
            <div class="chat-message chat-message-me clearfix">
                <div class="chat-caret"></div>
                <div class="chat-message-text">Lorem ipsum dolor sit amet?</div>
            </div>
            <div class="chat-message chat-message-other clearfix">
                <div class="chat-caret"></div>
                <div class="chat-message-text">Consectetur adipiscing elit.</div>
            </div>
            <div class="chat-message chat-message-me clearfix">
                <div class="chat-caret"></div>
                <div class="chat-message-text">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Maecenas porttitor congue massa. Fusce posuere, magna sed pulvinar ultricies, purus lectus malesuada libero, sit amet commodo magna eros quis urna.</div>
            </div>
            <div class="chat-message chat-message-other clearfix">
                <div class="chat-caret"></div>
                <div class="chat-message-text">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Maecenas porttitor congue massa. Fusce posuere, magna sed pulvinar ultricies, purus lectus malesuada libero, sit amet commodo magna eros quis urna. Nunc viverra imperdiet enim. Fusce est. Vivamus a tellus.
                Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Proin pharetra nonummy pede. Mauris et orci.</div>
            </div>
        </div>
        <div class="chat-sender">
            <textarea class="form-control" placeholder="Tekan Enter Untuk Mengirim Pesan..."></textarea>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                open: false
            }
        },
        
        computed: {
            arrowClass() {
                return this.open ? 'glyphicon-chevron-down' : 'glyphicon-chevron-up'
            }
        },

        methods: {
            toggle() {
                // this.open = ! this.open
            }
        },
    }
</script>