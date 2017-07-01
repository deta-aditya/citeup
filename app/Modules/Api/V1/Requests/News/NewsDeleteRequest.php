<?php

namespace App\Modules\Api\V1\Requests\News;

use Illuminate\Foundation\Http\FormRequest;

class NewsDeleteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->user();

        return $user->isAdmin() || $user->hasKey('delete-news');
    }
}
