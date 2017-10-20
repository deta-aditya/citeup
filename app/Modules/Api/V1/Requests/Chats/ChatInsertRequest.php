<?php

namespace App\Modules\Api\V1\Requests\Chats;

use Illuminate\Foundation\Http\FormRequest;

class ChatInsertRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $accessor = $this->user();

        return $accessor->isAdmin() || $accessor->isCommittee() || 
            ($accessor->isEntrant() && $accessor->entry_id == $this->input('entry', null));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'message' => 'required|string',
            'entry' => 'required|int|exists:entries,id',
            'committee' => 'required|int|in:0,1',
        ];
    }
}
