
<div class="container-fluid">
    <div class="greeting-text">Monitor Lomba Logika</div>
    <div class="row">
        <div class="col-sm-7 entrant-list-container">
            <div class="entrant-list list-group">
                <a v-for="entrant in entrants" :class="{'entrant-item': true, 'list-group-item': true, 'has-unread-chat': entrant.chat > 0, 'selected': entrant.id === selected.id}" href="#" @click.prevent="selectEntrant(entrant)">
                    <h4>@{{ entrant.name }} <small>#@{{ entrant.id }}</small>
                        <div class="pull-left status-container">
                            <span :class="{'attempt-start-status': true, 'badge': true, 'done': entrant.attempt !== null}" data-toggle="tooltip" data-placement="bottom" :title="entrant.attempt !== null ? 'Peserta ini mulai pada ' + entrant.attempt.started_at : 'Peserta ini belum memulai' ">&nbsp;</span>
                            <span :class="{'attempt-finish-status': true, 'badge': true, 'done': entrant.attempt !== null && entrant.attempt.finished_at !== null}" data-toggle="tooltip" data-placement="bottom" :title="entrant.attempt !== null && entrant.attempt.finished_at !== null ? 'Peserta ini selesai pada ' + entrant.attempt.finished_at : 'Peserta ini belum selesai' ">&nbsp;</span>
                            <span class="badge answers-count" data-toggle="tooltip" data-placement="bottom" title="Jumlah soal yang telah dijawab">@{{ entrant.attempt === null ? 0 : entrant.attempt.answers.length }}</span>
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
