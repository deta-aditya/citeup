<?php

namespace App\Modules\Api\V1\Requests\Entries;

use Illuminate\Foundation\Http\FormRequest;

class AddSubmissionRequest extends FormRequest
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

        return $user->isAdmin() || $user->hasKey('post-entries-submissions') || 
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
            'description' => 'required|string',
            'picture' => 'required|string|max:191',
        ];
    }
}
