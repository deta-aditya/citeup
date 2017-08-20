<?php

namespace App\Modules\Api\V1\Requests\Entries;

use App\Modules\Models\Entry;
use App\Modules\Electrons\Keys\KeyService;
use App\Modules\Electrons\Activities\ActivityService;
use App\Modules\Electrons\Shared\Requests\ApiIndexRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\MessageBag;

class EntryIndexRequest extends ApiIndexRequest
{
    /**
     * The main model for the request.
     *
     * @var Entry
     */
    protected $model = Entry::class;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $accessor = $this->user();

        return $accessor->isAdmin() || $accessor->hasKey('get-entries');
    }

    /**
     * Returns additional rules aside from the query string rules.
     *
     * @return array
     */
    protected function additional()
    {
        return [
            'activity' => 'exists:activities,id',
        ];
    }
}
