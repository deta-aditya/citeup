<?php

namespace App\Modules\Api\V1\Requests\Attempts;

use Illuminate\Foundation\Http\FormRequest;

class AddAnswersRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->user();

        return $user->isAdmin() || $user->hasKey('post-attempts-answers') || 
            ($user->isEntrant() && $user->attempts->search(function ($item, $key) {
                return $item->id === $this->route('attempt')->id;
            }) !== false);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'answers' => 'required|array',
            'answers.*' => 'int|exists:choices,id',
        ];
    }
}
