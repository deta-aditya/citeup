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

        if (array_has($params, 'logika')) {
            $query->logika();
        }

        if (array_has($params, 'desain')) {
            $query->desain();
        }

        return $query->get();
    }

    /**
     * Create a new entry and return it.
     *
     * @param  array  $data
     * @return Chat
     */
    public function create(array $data)
    {
        $cleaned = $this->clean($data);

        if (array_has($data, 'entry')) {
            $cleaned['entry_id'] = $data['entry'];
            $cleaned['channel'] = Entry::find($data['entry'])->activity_id;
        }

        return Chat::create($cleaned);
    }
}
