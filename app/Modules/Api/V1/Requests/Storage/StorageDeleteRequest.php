<?php

namespace App\Modules\Api\V1\Requests\Storage;

use Illuminate\Foundation\Http\FormRequest;

class StorageDeleteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->user();
        
        list($trail, $mime, $objType, (int)$objId, $filename) = explode('/', $this->input('link'));

        return 
            ($objType === 'profiles' && $objId === $user->id) ||
            ($user->isCommittee() && (
                ($objType === 'profiles' && ($user->hasKey('delete-users') || $user->hasKey('put-users'))) ||
                ($objType === 'activities' && ($user->hasKey('delete-activities') || $user->hasKey('put-activities'))) ||
                ($objType === 'submits' && ($user->hasKey('delete-submissions') || $user->hasKey('put-submissions'))) ||
                ($objType === 'documents' && ($user->hasKey('delete-documents') || $user->hasKey('put-documents'))) ||
                ($objType === 'questions' && ($user->hasKey('delete-questions') || $user->hasKey('put-questions'))) ||
                ($objType === 'choices' && ($user->hasKey('delete-choices') || $user->hasKey('put-choices'))) ||
                ($objType === 'galleries' && ($user->hasKey('delete-galleries') || $user->hasKey('put-galleries'))) ||
                ($objType === 'news' && ($user->hasKey('delete-news') || $user->hasKey('put-news'))) ||
                ($objType === 'sponsors' && ($user->hasKey('delete-sponsors') || $user->hasKey('put-sponsors')))
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
            'link' => 'required|string',
        ];
    }
}
