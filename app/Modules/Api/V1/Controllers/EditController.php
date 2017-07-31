<?php

namespace App\Modules\Api\V1\Controllers;

use App\Modules\Models\Edit;
use App\Modules\Electrons\Edits\EditService;
use App\Modules\Api\V1\Requests\Edits\EditIndexRequest;
use App\Modules\Electrons\Shared\Controllers\JsonApiController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EditController extends Controller
{
    use JsonApiController;

    /**
     * A edit service instance.
     *
     * @var EditService
     */
    protected $edits;

    /**
     * Create a new controller instance.
     *
     * @param  EditService  $edits
     * @return void
     */
    public function __construct(EditService $edits)
    {
        $this->edits = $edits;
    }

    /**
     * Get an array of edits data.
     *
     * @param  EditIndexRequest  $request
     * @return Response
     */
    public function index(EditIndexRequest $request)
    {
        return $this->respondJson(
            ['edits' => $this->edits->getMultiple($request->all())]
        );
    }
}
