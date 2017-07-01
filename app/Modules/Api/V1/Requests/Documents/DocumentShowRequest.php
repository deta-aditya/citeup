<?php

namespace App\Modules\Api\V1\Requests\Documents;

use Illuminate\Foundation\Http\FormRequest;

class DocumentShowRequest extends FormRequest
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
        
        return $user->isAdmin() || $user->hasKey('view-documents') || $user->entry->id === $document->entry->id;
    }
}
