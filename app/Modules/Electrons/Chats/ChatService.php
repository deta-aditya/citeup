<?php

namespace App\Modules\Electrons\Chats;

use App\User;
use App\Modules\Models\Chat;
use App\Modules\Models\Entry;
use App\Modules\Nucleons\Service;
use Carbon\Carbon;

class ChatService extends Service
{
    /**
     * The main model for the service.
     *
     * @var Chat
     */
    protected $model = Chat::class;

    /**
     * Get multiple chats with conditions.
     *
     * @param  array  $params
     * @return array
     */
    public function multiple(array $params)
    {
        return $this->multipleCustom($this->getModel()->query(), $params);
    }

    /**
     * Get multiple chats with custom query and conditions.
     *
     * @param  Builder  $query
     * @param  array    $params
     * @return array
     */
    public function multipleCustom($query, array $params)
    {
        $query = $this->parseQueryString($query, $params);

        if (array_has($params, 'entry')) {
            $query->ofEntry($params['entry']);
        }

        return $query->get();
    }

    /**
     * Create a new chat and return it.
     *
     * @param  array  $data
     * @return Chat
     */
    public function create(array $data)
    {
        $cleaned = $this->clean($data);

        $cleaned['entry_id'] = $data['entry'];

        return Chat::create($cleaned);
    }

    /**
     * Read unread chats of specific entry.
     *
     * @param  int   $entry
     * @param  bool  $committee
     * @return Carbon
     */
    public function read($entry, $committee)
    {
        $chats = Chat::ofEntry($entry)->unread();
        $now = Carbon::now();

        if ($committee) {
            $chats->fromCommittee();
        } else {
            $chats->fromEntrant();
        }

        $chats->update(['read_at' => $now->format('Y-m-d H:i:s')]);

        return $now;
    }
}
