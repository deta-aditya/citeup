<?php

namespace App\Modules\Api\V1\Requests\Schedules;

use App\Modules\Models\Schedule;
use App\Modules\Electrons\Users\UserService;
use App\Modules\Electrons\Shared\Requests\ApiIndexRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\MessageBag;

class ScheduleIndexRequest extends ApiIndexRequest
{
    /**
     * The main model for the request.
     *
     * @var Schedule
     */
    protected $model = Schedule::class;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Returns additional rules aside from the query string rules.
     *
     * @return array
     */
    protected function additional()
    {
        return [
            'activity' => 'int|exists:activities,id',
        ];
    }
}
