<?php

namespace App\Modules\Api\V1\Requests\Testimonials;

use Illuminate\Foundation\Http\FormRequest;

class TestimonialUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->user();
        $testimonial = $this->route('testimonial');

        return $user->isAdmin() || $user->hasKey('put-testimonials') || (
                $user->isEntrant() && 
                ($user->entry->id === $testimonial->entry->id)
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
            'content' => 'string|max:191',
            'rating' => 'int|between:1,5',
        ];
    }
}
