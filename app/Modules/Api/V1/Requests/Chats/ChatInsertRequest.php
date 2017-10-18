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
        $rules = [
            'message' => 'required|string',
        ];

        if ($this->user()->isEntrant()) {
            $rules['entry'] = 'required|int|exists:entries,id';
        } else {
            $rules['channel'] = 'required|int|in:1,2';
        }

        return $rules;
    }
}
