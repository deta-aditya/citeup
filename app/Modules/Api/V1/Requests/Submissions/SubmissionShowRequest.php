<?php

namespace App\Modules\Api\V1\Requests\Submissions;

use Illuminate\Foundation\Http\FormRequest;

class SubmissionShowRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->user();
        $submission = $this->route('submission');

        return $user->isAdmin() || $user->hasKey('view-submissions') || (
            $user->isEntrant() && $user->entry->id === $submission->entry->id
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
            //
        ];
    }
}
