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

        return $user->isAdmin() || $user->hasKey('view-submissions') || $user->entry->id === $submission->entry->id;
    }
}
