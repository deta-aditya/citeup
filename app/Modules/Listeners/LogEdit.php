<?php

namespace App\Modules\Listeners;

use App\Modules\Events\EditWasMade;
use App\Modules\Electrons\Edits\EditService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogEdit
{
    /**
     * The edit service instance.
     *
     * @var EditService
     */
    public $edits;

    /**
     * Create the event listener.
     *
     * @param  EditService  $edits
     * @return void
     */
    public function __construct(EditService $edits)
    {
        $this->edits = $edits;
    }

    /**
     * Handle the event.
     *
     * @param  EditWasMade  $event
     * @return void
     */
    public function handle(EditWasMade $event)
    {
        $this->edits->log($event->editable, $event->performer);
    }
}
