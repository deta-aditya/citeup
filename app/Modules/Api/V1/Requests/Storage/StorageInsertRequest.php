<?php

namespace App\Modules\Api\V1\Requests\Storage;

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
            ($this->input('object_type') === 'profiles' && $this->input('object_id') == $user->id) ||
            ($user->isCommittee() && (
                ($this->input('object_type') === 'profiles' && ($user->hasKey('post-users') || $user->hasKey('put-users'))) ||
                ($this->input('object_type') === 'activities' && ($user->hasKey('post-activities') || $user->hasKey('put-activities'))) ||
                ($this->input('object_type') === 'submits' && ($user->hasKey('post-submissions') || $user->hasKey('put-submissions'))) ||
                ($this->input('object_type') === 'documents' && ($user->hasKey('post-documents') || $user->hasKey('put-documents'))) ||
                ($this->input('object_type') === 'questions' && ($user->hasKey('post-questions') || $user->hasKey('put-questions'))) ||
                ($this->input('object_type') === 'choices' && ($user->hasKey('post-choices') || $user->hasKey('put-choices'))) ||
                ($this->input('object_type') === 'galleries' && ($user->hasKey('post-galleries') || $user->hasKey('put-galleries'))) ||
                ($this->input('object_type') === 'news' && ($user->hasKey('post-news') || $user->hasKey('put-news'))) ||
                ($this->input('object_type') === 'sponsors' && ($user->hasKey('post-sponsors') || $user->hasKey('put-sponsors'))) ||
                ($this->input('object_type') === 'imports' && $user->hasKey('post-imports')) ||
                ($this->input('object_type') === 'exports' && $user->hasKey('post-exports'))
            )) ||
            ($user->isEntrant() && ( 
                ($this->input('object_type') === 'submits' && $user->submissions->search(function ($item, $key) {
                    $item->id == $this->input('object_id');
                }) !== false) ||
                ($this->input('object_type') === 'documents' && $user->documents->search(function ($item, $key) {
                    $item->id == $this->input('object_id');
                }) !== false)
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
