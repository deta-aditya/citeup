
<div class="container-fluid">
    <div class="greeting-text">Monitor Lomba Desain</div>
    <div class="row">
        <div class="col-sm-7 entrant-list-container">
            <div class="entrant-list list-group">
                <a v-for="entrant in entrants" :class="{'entrant-item': true, 'list-group-item': true, 'has-unread-chat': entrant.chat > 0, 'selected': entrant.id === selected.id}" href="#" @click.prevent="selectEntrant(entrant)">
                    <h4>@{{ entrant.name }} <small>#@{{ entrant.id }}</small>
                        <div class="pull-left status-container">
                            <span :class="{'attempt-start-status': true, 'badge': true, 'done': entrant.submission !== null}" data-toggle="tooltip" data-placement="bottom" :title="entrant.submission !== null ? 'Peserta ini mulai pada ' + entrant.submission.created_at : 'Peserta ini belum memulai' ">&nbsp;</span>
                            <span :class="{'attempt-finish-status': true, 'badge': true, 'done': entrant.submission !== null && entrant.submission.picture !== defaultImage}" data-toggle="tooltip" data-placement="bottom" :title="entrant.submission !== null && entrant.submission.picture !== defaultImage ? 'Peserta ini selesai pada ' + entrant.submission.updated_at : 'Peserta ini belum selesai' ">&nbsp;</span>
                        </div>
                        <span class="pull-right" v-if="entrant.chat > 0">
                            @{{ entrant.chat }}
                        </span>
                    </h4>
                </a>
            </div>
        </div>
        <div class="col-sm-5 chat-body-container chat-area">
            <div ref="chatBody" class="chat-body">
                <p class="lead chat-greeting" v-if="loadingChat"><i class="fa fa-pulse fa-spinner fa-3x"></i></p>
                <template v-else-if="selected.id">
                    <div :class="{'chat-message': true, 'clearfix': true, 'chat-message-me': chat.committee === 1, 'chat-message-other': chat.committee === 0}" v-for="chat in chats">
                        <div class="chat-caret"></div>
                        <div class="chat-message-text">@{{ chat.message }}</div>
                    </div>
                </template>
                <p class="lead chat-greeting" v-else-if="! selected.id">Klik pada Peserta yang Akan Dikirimi Pesan</p>
            </div>
            <div class="chat-sender">
                <textarea class="form-control" v-model="sendable.message" placeholder="Tekan Enter Untuk Mengirim Pesan..." @keyup.enter="sendChatMessage" :disabled="sendingMessage || ! selected.id"></textarea>
                <p v-if="sendingMessage" class="text-muted"><i class="fa fa-pulse fa-spinner"></i> Mengirim pesan</p>
            </div>
        </div>
    </div>
</div>
