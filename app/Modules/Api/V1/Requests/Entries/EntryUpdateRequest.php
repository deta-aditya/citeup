<?php

namespace App\Modules\Api\V1\Requests\Entries;

use Illuminate\Foundation\Http\FormRequest;

class EntryUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->user();
        $entry = $this->route('entry');

        return  $user->isAdmin() || 
                $user->hasKey('put-entries') || 
                ($user->isEntrant() && $user->entry && $user->entry->id == $entry->id);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'string|max:191',
            'agency' => 'string|max:191',
            'address' => 'string',
            'phone' => 'string|max:15',
            'city' => 'string|max:191',
        ];
    }
}
