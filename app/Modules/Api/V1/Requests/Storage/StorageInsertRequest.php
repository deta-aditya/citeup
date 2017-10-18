<?php

namespace App\Modules\Api\V1\Requests\Storage;

use App\User;
use Illuminate\Foundation\Http\FormRequest;

class StorageInsertRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->user();

        return 
            ($this->input('object_type') === 'profile' && $this->input('object_id') == $user->id) ||
            ($user->isCommittee() && (
                ($this->input('object_type') === 'profile' && ($user->hasKey('post-users') || $user->hasKey('put-users'))) ||
                ($this->input('object_type') === 'activitie' && ($user->hasKey('post-activities') || $user->hasKey('put-activities'))) ||
                ($this->input('object_type') === 'submit' && ($user->hasKey('post-submissions') || $user->hasKey('put-submissions'))) ||
                ($this->input('object_type') === 'document' && ($user->hasKey('post-documents') || $user->hasKey('put-documents'))) ||
                ($this->input('object_type') === 'question' && ($user->hasKey('post-questions') || $user->hasKey('put-questions'))) ||
                ($this->input('object_type') === 'choice' && ($user->hasKey('post-choices') || $user->hasKey('put-choices'))) ||
                ($this->input('object_type') === 'gallery' && ($user->hasKey('post-galleries') || $user->hasKey('put-galleries'))) ||
                ($this->input('object_type') === 'news' && ($user->hasKey('post-news') || $user->hasKey('put-news'))) ||
                ($this->input('object_type') === 'sponsor' && ($user->hasKey('post-sponsors') || $user->hasKey('put-sponsors'))) ||
                ($this->input('object_type') === 'import' && $user->hasKey('post-imports')) ||
                ($this->input('object_type') === 'export' && $user->hasKey('post-exports'))
            )) ||
            ($user->isEntrant() && ( 
                ($this->input('object_type') === 'profile' && $user->entry->id === User::find($this->input('object_id'))->entry->id) ||
                ($this->input('object_type') === 'submit' && $user->entry->id == $this->input('object_id')) ||
                ($this->input('object_type') === 'document' && $user->entry->id == $this->input('object_id'))
            )) ||
            $user->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'object_id' => 'required|int',
            'object_type' => 'required|string',
            'file' => 'file|max:2048',
        ];
    }
}
