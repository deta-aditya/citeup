<?php

namespace App\Modules\Listeners;

use App\Modules\Events\EditWasMade;
use Illuminate\Auth\Events\Registered;
use App\Modules\Electrons\Documents\DocumentService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateDocumentForUser
{
    /**
     * The document service instance.
     *
     * @var DocumentService
     */
    public $documents;

    /**
     * Create the event listener.
     *
     * @param  DocumentService  $documents
     * @return void
     */
    public function __construct(DocumentService $documents)
    {
        $this->documents = $documents;
    }

    /**
     * Handle the event.
     *
     * @param  Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        $this->documents->create([
            'user' => $event->user->id,
            'type' => DocumentService::TYPE_ID_CARD,
        ]);

        if (! $event->user->crew) {
            $this->documents->create([
                'user' => $event->user->id,
                'type' => DocumentService::TYPE_PAYMENT_PROOF,
            ]);
        }
    }
}
