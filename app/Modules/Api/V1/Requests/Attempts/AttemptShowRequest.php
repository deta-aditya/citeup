<?php

namespace App\Modules\Api\V1\Requests\Attempts;

use Illuminate\Foundation\Http\FormRequest;

class AttemptShowRequest extends FormRequest
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

        return $user->isAdmin() || $user->hasKey('view-attempts') || $user->entry->id === $attempt->entry->id;
    }
}
