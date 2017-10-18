<?php

namespace App\Modules\Api\V1\Requests\Chats;

use App\Modules\Models\Chat;
use App\Modules\Electrons\Keys\KeyService;
use App\Modules\Electrons\Activities\ActivityService;
use App\Modules\Electrons\Shared\Requests\ApiIndexRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\MessageBag;

class ChatIndexRequest extends ApiIndexRequest
{
    /**
     * The main model for the request.
     *
     * @var Chat
     */
    protected $model = Chat::class;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $accessor = $this->user();

        return $accessor->isAdmin() || $accessor->isCommittee() || 
            ($accessor->isEntrant() && $accessor->entry->activity_id == $this->input('channel', null));
    }

    /**
     * Returns additional rules aside from the query string rules.
     *
     * @return array
     */
    protected function additional()
    {
        return [
            'channel' => 'int|in:1,2',
        ];
    }
}
