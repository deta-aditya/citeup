
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-8">
            Activity Monitor
            <div v-for="entrant in entrants">
                @{{ entrant.id }} | @{{ entrant.name }} | @{{ entrant.submission !== null ? entrant.submission.started_at : 'N/A' }} | @{{ entrant.chat }}
            </div>
        </div>
        <div class="col-sm-4">Chat Area</div>
    </div>
</div>
