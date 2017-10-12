<?php

namespace App\Modules\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Electrons\Stages\StageService;
use App\Modules\Api\V1\Requests\Stages\StageIndexRequest;
use App\Modules\Electrons\Shared\Controllers\JsonApiController;
use Illuminate\Http\Request;

class StageController extends Controller
{
    use JsonApiController;

    /**
     * A StageService instance.
     *
     * @var StageService
     */
    protected $stages;

    /**
     * Create a new controller instance.
     *
     * @param  StageService  $stages
     * @return void
     */
    public function __construct(StageService $stages)
    {
        $this->stages = $stages;
    }
    
    /**
     * Get stages data.
     *
     * @param  StageIndexRequest  $request
     * @return Response
     */
    public function index(StageIndexRequest $request)
    {
        return $this->respondJson([
            'stages' => $this->stages->multiple()
        ]);
    }

    /**
     * Get the current stage data.
     *
     * @return Response
     */
    public function current()
    {
        return $this->respondJson([
            'stage' => $this->stages->current()
        ]);
    }

}
