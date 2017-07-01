<?php

namespace App\Modules\Api\V1\Requests\Schedules;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleDeleteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->user();

        return $user->isAdmin() || $user->hasKey('delete-schedules');
    }
}
