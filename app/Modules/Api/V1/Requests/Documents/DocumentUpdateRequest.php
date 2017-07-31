<?php

namespace App\Modules\Api\V1\Requests\Documents;

use Illuminate\Foundation\Http\FormRequest;

class DocumentUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->user();
        $document = $this->route('document');

        return $user->isAdmin() || $user->hasKey('put-documents') || (
                $user->isEntrant() && 
                ($user->entry->id === $document->entry->id)
            );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'file' => 'string|max:191',
            'type' => 'int|between:0,9',
        ];
    }
}
