<?php

namespace App\Modules\Api\V1\Requests\Schedules;

use App\Modules\Models\Schedule;
use Illuminate\Foundation\Http\FormRequest;

class ScheduleInsertRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->user();

        return $user->isAdmin() || $user->hasKey('post-schedules');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'activity' => 'required|int|exists:activities,id',
            'description' => 'required|string|max:191',
            'held_at' => 'required|date_format:Y-m-d H:i:s',
        ];
    }
}
