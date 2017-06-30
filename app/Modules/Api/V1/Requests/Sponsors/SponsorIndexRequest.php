<?php

namespace App\Modules\Api\V1\Requests\Sponsors;

use App\Modules\Models\Sponsor;
use App\Modules\Electrons\Shared\Requests\ApiIndexRequest;

class SponsorIndexRequest extends ApiIndexRequest
{
    /**
     * The main model for the request.
     *
     * @var Sponsor
     */
    protected $model = Sponsor::class;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('get', Sponsor::class);
    }
}
