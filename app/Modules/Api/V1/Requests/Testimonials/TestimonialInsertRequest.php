<?php

namespace App\Modules\Api\V1\Requests\Testimonials;

use App\Modules\Models\Testimonial;
use Illuminate\Foundation\Http\FormRequest;

class TestimonialInsertRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->user();

        return $user->isAdmin() || $user->hasKey('post-testimonials') || (
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
            'content' => 'required|string|max:191',
            'rating' => 'required|int|between:1,5',
        ];
    }
}
