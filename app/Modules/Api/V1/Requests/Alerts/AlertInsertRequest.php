<?php

namespace App\Modules\Api\V1\Requests\Alerts;

use App\Modules\Models\Alert;
use Illuminate\Foundation\Http\FormRequest;

class AlertInsertRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->user();

        return $user->isAdmin() || $user->hasKey('post-alerts');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:191',
            'content' => 'required|string|max:191',
            'users' => 'array',
            'users.*' => 'int|exists:users,id',
        ];
    }
}
