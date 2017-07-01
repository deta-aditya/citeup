<?php

namespace App\Modules\Api\V1\Requests\Entries;

use Illuminate\Foundation\Http\FormRequest;

class EntryShowRequest extends FormRequest
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

        return $user->isAdmin() || $user->hasKey('view-entries') || 
            $user->entry->id === $entry->id;
    }
}
