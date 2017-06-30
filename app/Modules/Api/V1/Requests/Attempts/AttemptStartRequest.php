<?php

namespace App\Modules\Api\V1\Requests\Attempts;

use App\Modules\Models\Attempt;
use Illuminate\Foundation\Http\FormRequest;

class AttemptStartRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('post', Attempt::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'entry' => 'required|int|exists:entries,id',
            'started_at' => 'required|date_format:Y-m-d H:i:s',
        ];
    }
}
