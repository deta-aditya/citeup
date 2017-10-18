<?php

namespace App\Modules\Api\V1\Requests\Submissions;

use App\Modules\Models\Submission;
use Illuminate\Foundation\Http\FormRequest;

class SubmissionInsertRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->user();

        return $user->isAdmin() || $user->hasKey('post-submissions') || (
            $user->isEntrant() && $user->entry->id == $this->input('entry', null)
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
            'entry' => 'required|int|exists:entries,id',
            'description' => 'string',
            'picture' => 'string|max:191',
        ];
    }
}
