<?php

namespace App\Modules\Api\V1\Requests\Entries;

use Illuminate\Foundation\Http\FormRequest;

class AddDocumentRequest extends FormRequest
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

        return $user->isAdmin() || $user->hasKey('post-entries-documents') ||
            ($user->isEntrant() && $user->entry->id == $entry->id);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'file' => 'required|string|max:191',
            'type' => 'required|int|between:0,9',
        ];
    }
}
