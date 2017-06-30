<?php

namespace App\Modules\Api\V1\Controllers;

use App\Modules\Models\Testimonial;
use App\Modules\Electrons\Testimonials\TestimonialService;
use App\Modules\Api\V1\Requests\Testimonials\TestimonialIndexRequest;
use App\Modules\Api\V1\Requests\Testimonials\TestimonialInsertRequest;
use App\Modules\Api\V1\Requests\Testimonials\TestimonialUpdateRequest;
use App\Modules\Electrons\Shared\Controllers\JsonApiController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    use JsonApiController;

    /**
     * A testimonial service instance.
     *
     * @var TestimonialService
     */
    protected $testimonials;

    /**
     * Create a new controller instance.
     *
     * @param  TestimonialService  $testimonials
     * @return void
     */
    public function __construct(TestimonialService $testimonials)
    {
        $this->testimonials = $testimonials;
    }

    /**
     * Get an array of testimonials data.
     *
     * @param  TestimonialIndexRequest  $request
     * @return Response
     */
    public function index(TestimonialIndexRequest $request)
    {
        return $this->respondJson(
            ['testimonials' => $this->testimonials->getMultiple($request->all())]
        );
    }

    /**
     * Get a testimonial data.
     *
     * @param  Request   $request
     * @param  Testimonial  $testimonial
     * @return Response
     */
    public function show(Request $request, Testimonial $testimonial)
    {
        $this->authorize('view', $testimonial);

        return $this->respondJson(['testimonial' => $testimonial]);   
    }

    /**
     * Insert a new testimonial data.
     *
     * @param  TestimonialInsertRequest  $request
     * @return Response
     */
    public function insert(TestimonialInsertRequest $request)
    {
        $testimonial = $this->testimonials->create($request->all());

        return $this->respondJson(['testimonial' => $testimonial]);
    }

    /**
     * Update a testimonial data.
     *
     * @param  TestimonialUpdateRequest  $request
     * @param  Testimonial               $testimonial
     * @return Response
     */
    public function update(TestimonialUpdateRequest $request, Testimonial $testimonial)
    {
        $this->testimonials->update($testimonial, $request->all());

        return $this->respondJson(['testimonial' => $testimonial]);
    }

    /**
     * Delete a testimonial data.
     *
     * @param  Request   $request
     * @param  Testimonial  $testimonial
     * @return Response
     */
    public function remove(Request $request, Testimonial $testimonial)
    {
        $this->authorize('delete', $testimonial);

        $this->testimonials->remove($testimonial);

        return $this->respondJson(['testimonial' => $testimonial]);
    }
}
