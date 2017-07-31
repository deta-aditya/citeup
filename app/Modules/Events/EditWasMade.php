<?php

namespace App\Modules\Events;

use App\Modules\Contracts\Models\Editable;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class EditWasMade
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The editable instance.
     *
     * @var Editable
     */
    public $editable;

    /**
     * The user instance who performs the edit.
     *
     * @var User
     */
    public $performer;

    /**
     * Create a new event instance.
     *
     * @param  Editable  $editable
     * @return void
     */
    public function __construct(Editable $editable)
    {
        $this->editable = $editable;
        $this->performer = auth()->guard('api')->user();
    }
}
