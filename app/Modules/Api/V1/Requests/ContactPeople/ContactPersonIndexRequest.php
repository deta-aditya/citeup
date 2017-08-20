<?php

namespace App\Modules\Api\V1\Requests\ContactPeople;

use App\Modules\Models\ContactPerson;
use App\Modules\Electrons\Shared\Requests\ApiIndexRequest;

class ContactPersonIndexRequest extends ApiIndexRequest
{
    /**
     * The main model for the request.
     *
     * @var ContactPerson
     */
    protected $model = ContactPerson::class;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
