<?php

namespace App\Modules\Api\V1\Requests\Entries;

use Illuminate\Foundation\Http\FormRequest;

class AddTestimonialRequest extends FormRequest
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

        return $user->isAdmin() || $user->hasKey('post-entries-testimonials') ||
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
            'content' => 'required|string|max:191',
            'rating' => 'required|int|between:1,5',
        ];
    }
}
