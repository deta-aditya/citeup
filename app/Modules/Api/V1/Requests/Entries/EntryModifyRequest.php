<?php

namespace App\Modules\Api\V1\Requests\Entries;

use Illuminate\Foundation\Http\FormRequest;

class EntryModifyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $accessor = $this->user();

        $isAdmin = $accessor->isAdmin();

        return strpos($this->url(), 'entries/') !== false ? 
            $isAdmin || $accessor->hasKey('post-entries') :
            $isAdmin || $accessor->hasKey('post-users-entries');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'stage' => 'int|between:0,5',
            'status' => 'int|in:0,1',
        ];
    }
}
