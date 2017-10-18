<?php

namespace App\Modules\Api\V1\Requests\Chats;

use Illuminate\Foundation\Http\FormRequest;

class ChatReadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->user();

        return $user->isAdmin() || $user->isCommittee() ||
            ($user->isEntrant() && $user->entry->id == $this->input('entry'));
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
        ];
    }
}
