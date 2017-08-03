<?php

namespace App\Modules\Api\V1\Requests\Activities;

use App\Modules\Models\Activity;
use Illuminate\Foundation\Http\FormRequest;

class ActivityInsertRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->user();

        return $user->isAdmin() || $user->hasKey('post-activities');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:191',
            'description' => 'string',
            'short_description' => 'string|max:191',
            'icon' => 'string|max:191',
            'order' => 'int|min:-1',
            'prize_first' => 'int|min:0|nullable',
            'prize_second' => 'int|min:0|nullable',
            'prize_third' => 'int|min:0|nullable',
        ];
    }
}
