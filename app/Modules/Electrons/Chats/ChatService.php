<?php

namespace App\Modules\Electrons\Chats;

use App\User;
use App\Modules\Models\Chat;
use App\Modules\Models\Entry;
use App\Modules\Nucleons\Service;

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
     * @return this
     */
    public function read($entry, $committee)
    {
        $chats = Chat::ofEntry($entry)->unread();

        if ($committee) {
            $chats->fromCommittee();
        } else {
            $chats->fromEntrant();
        }

        $chats = $chats->get();

        $chats->read_at = Carbon::now()->parse('Y-m-d H:i:s');
        $chats->save();

        return $this;
    }
}
