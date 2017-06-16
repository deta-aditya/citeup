<?php

namespace App\Modules\Api\V1\Controllers;

use App\Modules\Models\Choice;
use App\Modules\Electrons\Questions\ChoiceService;
use App\Modules\Api\V1\Requests\Choices\ChoiceIndexRequest;
use App\Modules\Api\V1\Requests\Choices\ChoiceInsertRequest;
use App\Modules\Api\V1\Requests\Choices\ChoiceUpdateRequest;
use App\Modules\Electrons\Shared\Controllers\JsonApiController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChoiceController extends Controller
{
    use JsonApiController;

    /**
     * A choice service instance.
     *
     * @var ChoiceService
     */
    protected $choices;

    /**
     * Create a new controller instance.
     *
     * @param  ChoiceService  $choices
     * @return void
     */
    public function __construct(ChoiceService $choices)
    {
        $this->choices = $choices;
    }

    /**
     * Get an array of choices data.
     *
     * @param  ChoiceIndexRequest  $request
     * @return Response
     */
    public function index(ChoiceIndexRequest $request)
    {
        return $this->respondJson(
            ['choices' => $this->choices->getMultiple($request->all())]
        );
    }

    /**
     * Get a choice data.
     *
     * @param  Request   $request
     * @param  Choice  $choice
     * @return Response
     */
    public function show(Request $request, Choice $choice)
    {
        return $this->respondJson(['choice' => $choice]);   
    }

    /**
     * Insert a new choice data.
     *
     * @param  ChoiceInsertRequest  $request
     * @return Response
     */
    public function insert(ChoiceInsertRequest $request)
    {
        $choice = $this->choices->create($request->all());

        return $this->respondJson(['choice' => $choice]);
    }

    /**
     * Update a choice data.
     *
     * @param  ChoiceUpdateRequest  $request
     * @param  Choice               $choice
     * @return Response
     */
    public function update(ChoiceUpdateRequest $request, Choice $choice)
    {
        $this->choices->update($choice, $request->all());

        return $this->respondJson(['choice' => $choice]);
    }

    /**
     * Delete a choice data.
     *
     * @param  Request   $request
     * @param  Choice  $choice
     * @return Response
     */
    public function remove(Request $request, Choice $choice)
    {
        $this->choices->remove($choice);

        return $this->respondJson(['choice' => $choice]);
    }
}
