<?php

namespace App\Modules\Api\V1\Requests\Entries;

use Illuminate\Foundation\Http\FormRequest;

class EntryInsertRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $accessor = $this->user();

        return $accessor->isAdmin() || $accessor->hasKey('post-entries');
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
            'name' => 'required|string|max:191',
            'agency' => 'string|max:191',
            'address' => 'string',
            'phone' => 'string|max:15',
            'city' => 'string|max:191',
        ];
    }
}
