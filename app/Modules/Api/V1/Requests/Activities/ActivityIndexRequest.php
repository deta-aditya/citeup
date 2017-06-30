<?php

namespace App\Modules\Api\V1\Requests\Activities;

use App\Modules\Models\Activity;
use App\Modules\Electrons\Users\UserService;
use App\Modules\Electrons\Shared\Requests\ApiIndexRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\MessageBag;

class ActivityIndexRequest extends ApiIndexRequest
{
    /**
     * The main model for the request.
     *
     * @var Activity
     */
    protected $model = Activity::class;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('get', Activity::class);
    }
}
