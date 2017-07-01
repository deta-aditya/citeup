<?php

namespace App\Modules\Api\V1\Requests\Documents;

use App\Modules\Models\Document;
use App\Modules\Electrons\Shared\Requests\ApiIndexRequest;

class DocumentIndexRequest extends ApiIndexRequest
{
    /**
     * The main model for the request.
     *
     * @var Document
     */
    protected $model = Document::class;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->user();

        $entry = $this->is('entry/*') ?
            $this->route('entry')->id :
            $this->input('entry', $user->entry->id);

        return $user->isAdmin() || $user->hasKey('get-documents') || 
            $user->entry->id == $entry;
    }

    /**
     * Returns additional rules aside from the query string rules.
     *
     * @return array
     */
    protected function additional()
    {
        return [
            'entry' => 'int|exists:entries,id',
            'type' => 'int|between:0,9',
        ];
    }
}
