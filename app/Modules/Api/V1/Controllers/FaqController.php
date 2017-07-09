<?php

namespace App\Modules\Api\V1\Controllers;

use App\Modules\Models\Faq;
use App\Modules\Electrons\Edits\EditService;
use App\Modules\Electrons\Faqs\FaqService;
use App\Modules\Api\V1\Requests\Edits\EditIndexRequest;
use App\Modules\Api\V1\Requests\Faqs\FaqIndexRequest;
use App\Modules\Api\V1\Requests\Faqs\FaqShowRequest;
use App\Modules\Api\V1\Requests\Faqs\FaqInsertRequest;
use App\Modules\Api\V1\Requests\Faqs\FaqUpdateRequest;
use App\Modules\Api\V1\Requests\Faqs\FaqDeleteRequest;
use App\Modules\Electrons\Shared\Controllers\JsonApiController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    use JsonApiController;

    /**
     * A faq service instance.
     *
     * @var FaqService
     */
    protected $faqs;

    /**
     * Create a new controller instance.
     *
     * @param  FaqService  $faqs
     * @return void
     */
    public function __construct(FaqService $faqs)
    {
        $this->faqs = $faqs;
    }

    /**
     * Get an array of faqs data.
     *
     * @param  FaqIndexRequest  $request
     * @return Response
     */
    public function index(FaqIndexRequest $request)
    {
        return $this->respondJson(
            ['faqs' => $this->faqs->getMultiple($request->all())]
        );
    }

    /**
     * Get a faq data.
     *
     * @param  FaqShowRequest   $request
     * @param  Faq   $faq
     * @return Response
     */
    public function show(FaqShowRequest $request, Faq $faq)
    {
        return $this->respondJson(['faq' => $faq]);   
    }

    /**
     * Insert a new faq data.
     *
     * @param  FaqInsertRequest  $request
     * @return Response
     */
    public function insert(FaqInsertRequest $request)
    {
        $faq = $this->faqs->create($request->all());

        return $this->respondJson(['faq' => $faq]);
    }

    /**
     * Update a faq data.
     *
     * @param  FaqUpdateRequest  $request
     * @param  Faq               $faq
     * @return Response
     */
    public function update(FaqUpdateRequest $request, Faq $faq)
    {
        $this->faqs->update($faq, $request->all());

        return $this->respondJson(['faq' => $faq]);
    }

    /**
     * Delete a faq data.
     *
     * @param  FaqDeleteRequest   $request
     * @param  Faq   $faq
     * @return Response
     */
    public function remove(FaqDeleteRequest $request, Faq $faq)
    {   
        $this->faqs->remove($faq);

        return $this->respondJson(['faq' => $faq]);
    }

    /**
     * Get edits of the given faq.
     *
     * @param  EditIndexRequest   $request
     * @param  Faq            $faq
     * @param  EditService        $edits
     * @return Response
     */
    public function edits(EditIndexRequest $request, Faq $faq, EditService $edits)
    {
        $queries = $request->all();

        $queries['faq'] = $faq->id;

        return $this->respondJson(
            ['edits' => $edits->getMultiple($queries)]
        );
    }
}
