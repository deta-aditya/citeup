<?php

namespace App\Modules\Api\V1\Requests\Attempts;

use Illuminate\Foundation\Http\FormRequest;

class AttemptFinishRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->user();
        $attempt = $this->route('attempt');

        return $user->isAdmin() || $user->hasKey('put-attempts') || (
                $user->isEntrant() && 
                ($user->entry->id === $attempt->entry->id)
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
            'finished_at' => 'date_format:Y-m-d H:i:s',
        ];
    }
}
