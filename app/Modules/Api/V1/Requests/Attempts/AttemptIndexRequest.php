<?php

namespace App\Modules\Api\V1\Requests\Attempts;

use App\Modules\Models\Attempt;
use App\Modules\Electrons\Shared\Requests\ApiIndexRequest;

class AttemptIndexRequest extends ApiIndexRequest
{
    /**
     * The main model for the request.
     *
     * @var Attempt
     */
    protected $model = Attempt::class;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->user();

        $entry = strpos($this->url(), 'entries/') !== false ?
            $this->route('entry')->id :
            $this->input('entry', null);

        return $user->isAdmin() || $user->hasKey('get-attempts') || 
            ($user->isEntrant() && $user->entry->id == $entry);
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
            'finished' => 'string|in:true,false',
            'unfinished' => 'string|in:true,false',
        ];
    }
}
