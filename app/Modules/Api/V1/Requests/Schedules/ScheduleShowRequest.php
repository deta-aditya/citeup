<?php

namespace App\Modules\Api\V1\Requests\Schedules;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleShowRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
