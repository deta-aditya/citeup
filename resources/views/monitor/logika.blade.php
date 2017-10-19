
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
                    {{-- @{{ entrant.attempt !== null ? entrant.attempt.started_at : 'N/A' }} | @{{ entrant.chat }} --}}
                </a>
            </div>
        </div>
        <div class="col-sm-5 chat-body-container chat-area">
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
    </div>
</div>
