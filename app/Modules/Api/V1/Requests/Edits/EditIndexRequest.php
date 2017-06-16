<?php

namespace App\Modules\Api\V1\Requests\Edits;

use App\Modules\Models\Edit;
use App\Modules\Electrons\Shared\Requests\ApiIndexRequest;

class EditIndexRequest extends ApiIndexRequest
{
    /**
     * The main model for the request.
     *
     * @var Edit
     */
    protected $model = Edit::class;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Returns additional rules aside from the query string rules.
     *
     * @return array
     */
    protected function additional()
    {
        return [
            'activity' => 'int|exists:activities,id',
            'schedule' => 'int|exists:schedules,id',
            'news' => 'int|exists:news,id',
            'gallery' => 'int|exists:galleries,id',
            'user' => 'int|exists:users,id',
        ];
    }
}
