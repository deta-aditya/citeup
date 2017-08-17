<?php

namespace App\Modules\Api\V1\Requests\Entries;

use Illuminate\Foundation\Http\FormRequest;

class EntrantQualifyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->isAdmin() || 
            ($this->user()->isCommittee() && $this->user()->hasKey('put-entries'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
